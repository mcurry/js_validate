<?php
/*
 * Javascript Validation CakePHP Helper
 * Copyright (c) 2008 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/cakephp/tree/master/helpers/validation
 * http://sandbox2.pseudocoder.com/demo/validation
 *
 * @author      mattc <matt@pseudocoder.com>
 * @license     MIT
 *
 */

//feel free to replace these or overwrite in your bootstrap.php
if (!defined('VALID_EMAIL_JS')) {
  define('VALID_EMAIL_JS', '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/');
}
//I know the octals should be capped at 255
if (!defined('VALID_IP_JS')) {
  define('VALID_IP_JS', '/^[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}$/');
}

//list taken from /cake/libs/validation.php line 497
if (!defined('DEFAULT_VALIDATION_EXTENSIONS')) {
  define('DEFAULT_VALIDATION_EXTENSIONS', 'gif,jpeg,png,jpg');
}

class ValidationHelper extends Helper {
  var $helpers = array('Javascript');

  //For security reasons you may not want to include all possible validations.
  //In your bootstrap you can define which are allowed
  //Configure::write('javascriptValidationWhitelist', array('alphaNumeric', 'minLength'));
  var $whitelist = false;

  function rules($modelNames, $options=array()) {
    $scriptTags = '';

    if (empty($options) || !is_array($options)) {
      $options = array();
    }

    $defaultOptions = array('formId' => false, 'inline' => true, 'messageId' => 'messages');
    $options = array_merge($defaultOptions, $options);

    //load the whitelist
    $this->whitelist = Configure::read('javascriptValidationWhitelist');

    if (!is_array($modelNames)) {
      $modelNames = array($modelNames);
    }

    //catch the form submit
    $formId = 'form';
    if ($options['formId']) {
      $formId = '#' . $formName;
    }
    $scriptTags  	.= "$(document).ready(function(){
                        $('". $formId . "').submit( function() {
                          return validateForm(this, rules, eval(" . json_encode(array('messageId' => $options['messageId'])) . "));
                        });
                      });\n";

    //filter the rules to those that can be handled with JavaScript
    $validation = array();
    foreach($modelNames as $modelName) {
      $model = classRegistry::init($modelName);

      foreach ($model->validate as $field => $validators) {
        if (array_intersect(array('rule', 'allowEmpty', 'on', 'message', 'last'), array_keys($validators))) {
          $validators = array($validators);
        }
        
        foreach($validators as $key => $validator) {
          $rule = null;

          if (!is_array($validator)) {
            $validator = array('rule' => $validator);
          }

          //skip rules that are applied only on created or updates
          if (!empty($validator['on'])) {
            continue;
          }

          if (!isset($validator['message'])) {
            $validator['message'] = sprintf('%s %s',
                                            __('There was a problem with the field', true),
                                            Inflector::humanize($field)
                                           );
          }


          if (!empty($validator['rule'])) {
            $rule = $this->convertRule($validator['rule']);
          }

          if ($rule) {
            $temp = array('rule' => $rule,
                          'message' => __($validator['message'], true)
                         );

						if (isset($validator['last']) && $validator['last'] === true) {
						    $temp['last'] = true;
						} 

            if (isset($validator['allowEmpty']) && $validator['allowEmpty'] === true) {
              $temp['allowEmpty'] = true;
            }

            if (in_array($validator['rule'], array('alphaNumeric', 'blank'))) {
              //Cake Validation::_check returning true is actually false for alphaNumeric and blank
              //add a "!" so that JavaScript knows
              $temp['negate'] = true;
            }

            $validation[$modelName . Inflector::camelize($field)][] = $temp;
          }
        }
      }
    }

    $scriptTags 	.= "var rules = eval(" . json_encode($validation) . ");\n";

    if ($options['inline']) {
      return sprintf($this->Javascript->tags['javascriptblock'], $scriptTags);
    } else {
      $this->Javascript->codeBlock($scriptTags, array('inline' => false));
    }

    return true;
  }

  function convertRule($rule) {
    $regex = false;

    if ($rule == '_extract') {
      return false;
    }

    if (is_array($this->whitelist) && !in_array($rule, $this->whitelist)) {
      return false;
    }

    $params = array();
    if (is_array($rule)) {
      $params = array_slice($rule, 1);
      $rule = $rule[0];
    }

    //Certain Cake built-in validations can be handled with regular expressions,
    //but aren't on the Cake side.
    switch ($rule) {
      case 'between':
        return sprintf('/^.{%d,%d}$/', $params[0], $params[1]);
      case 'date':
        //Some of Cake's date regexs aren't JavaScript compatible. Skip for now
        return false;
      case 'email':
        return VALID_EMAIL_JS;
      case 'equalTo':
        return sprintf('/^%s$/', $params[0]);
      case 'extension':
        return sprintf('/\.(%s)$/', implode('|', explode(',', DEFAULT_VALIDATION_EXTENSIONS)));
      case 'ip':
        return VALID_IP_JS;
      case 'minLength':
        return sprintf('/^.{%d,}$/', $params[0]);
      case 'maxLength':
        return sprintf('/^.{0,%d}$/', $params[0]);
      case 'money':
        //The Cake regex for money was giving me issues, even within PHP.  Skip for now
        return false;
      case 'numeric':
        //Cake uses PHP's is_numeric function, which actually accepts a varied input
        //(both +0123.45e6 and 0xFF are valid) then what is allowed in this regular expression.
        //99% of people using this validation probably want to restrict to just numbers in standard
        //decimal notation.  Feel free to alter or delete.
        return '/^[+-]?[0-9]+$/';
      case 'range':
        //Don't think there is a way to do this with a regular expressions,
        //so we'll handle this with plain old javascript
        return sprintf('range|%s|%s', $params[0], $params[1]);
    }

    //try to lookup the regular expression from
    //CakePHP's built-in validation rules
    $Validation =& Validation::getInstance();
    if (method_exists($Validation, $rule)) {
      $Validation->regex = null;
      call_user_func_array(array(&$Validation, $rule), array_merge(array(true), $params));

      if ($Validation->regex) {
        $regex = $Validation->regex;
      }
    }

    //special handling
    switch ($rule) {
      case 'alphaNumeric':
        //Not sure what the "u" modifier is, but JavaScript can't handle it.
        return str_replace('/mu', '/m', $regex);
      case 'postal':
      case 'ssn':
        //I'm not a regex guru and I have no idea what "\\A\\b" and "\\b\\z" do.
        //Is it just to match start and end of line?  Why not use
        //"^" and "$" then?  Eitherway they don't work in JavaScript.
        return str_replace(array('\\A\\b', '\\b\\z'), array('^', '$'), $regex);
    }

    return $regex;
  }
}
?>