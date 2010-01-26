<?php
/*
 * CakePHP jQuery Validation Plugin
 * Copyright (c) 2009 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/cakephp_plugin_validation
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

class ValidationHelper extends Helper {
  var $helpers = array('Javascript');

  //For security reasons you may not want to include all possible validations.
  //In your bootstrap you can define which are allowed
  //Configure::write('javascriptValidationWhitelist', array('alphaNumeric', 'minLength'));
  var $whitelist = false;

  function bind($modelNames, $options=array()) {
    $defaultOptions = array('form' => 'form', 'inline' => true, 'root' => Router::url('/'), 'watch' => array(), 'catch' => true);
    $options = am($defaultOptions, $options);
    $pluginOptions = array_intersect_key($options, array('messageId' => true, 'root' => true, 'watch' => true));

    //load the whitelist
    $this->whitelist = Configure::read('javascriptValidationWhitelist');

    $validation = array();
    if (!is_array($modelNames)) {
      $modelNames = array($modelNames);
    }

    //filter the rules to those that can be handled with JavaScript
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
						$message = sprintf(__($key, true), __($field, true));
						if($key != $message) {
							$validator['message'] = $message;
						} else {
							$validator['message'] = sprintf('%s %s',
																							__('There was a problem with the field', true),
																							Inflector::humanize($field)
																						 );
						}
          }

          if (!empty($validator['rule'])) {
            $rule = $this->__convertRule($validator['rule']);
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

            if (in_array($validator['rule'], array('blank'))) {
              //Cake Validation::_check returning true is actually false for blank
              //add a "!" so that JavaScript knows
              $temp['negate'] = true;
            }

            $validation[$modelName . Inflector::camelize($field)][] = $temp;
          }
        }
      }
			
			if(!empty($pluginOptions['watch'])) {
				$pluginOptions['watch'] = $this->__fixWatch($modelName, $pluginOptions['watch']);
			}			
    }
		
		if ($options['form']) {
			if($options['catch']) {
				$js = sprintf('$(function() { $("%s").validate(%s, %s) });',
											$options['form'],
											$this->Javascript->object($validation),
											$this->Javascript->object($pluginOptions));
			} else {
				$js = sprintf('$(function() { $("%s").data("validation", %s) });',
											$options['form'],
											$this->Javascript->object($validation));	
			}
    } else {
      return $this->Javascript->object($validation);
    }

    if ($options['inline']) {
      return sprintf($this->Javascript->tags['javascriptblock'], $js);
    } else {
      $this->Javascript->codeBlock($js, array('inline' => false));
    }

    return;
  }

  function __convertRule($rule) {
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

    if ($rule == 'comparison') {
      $params[0] = str_replace(array(' ', "\t", "\n", "\r", "\0", "\x0B"), '', strtolower($params[0]));
      switch ($params[0]) {
        case 'isgreater':
          $params[0] = '>';
          break;
        case 'isless':
          $params[0] = '<';
          break;
        case 'greaterorequal':
          $params[0] = '>=';
          break;
        case 'lessorequal':
          $params[0] = '<=';
          break;
        case 'equalto':
          $params[0] = '==';
          break;
        case 'notequal':
          $params[0] = '!=';
          break;
      }
    }

    //Certain Cake built-in validations can be handled with regular expressions,
    //but aren't on the Cake side.
    switch ($rule) {
      case 'alphaNumeric':
        return '/^[0-9A-Za-z]+$/';
      case 'between':
        return sprintf('/^.{%d,%d}$/', $params[0], $params[1]);
      case 'boolean':
        return array('rule' => 'boolean');
      case 'date':
        //Some of Cake's date regexs aren't JavaScript compatible. Skip for now
        if (!empty($params[0])) {
          $params = $params[0];
        } else {
          $params = 'ymd';
        }
        return array('rule' => 'date', 'params' => $params);
      case 'email':
        return VALID_EMAIL_JS;
      case 'equalTo':
        return sprintf('/^%s$/', $params[0]);
      case 'extension':
        if (empty($params[0])) {
          $params = array('gif', 'jpeg', 'png', 'jpg');
        } else {
          $params = $params[0];
        }
        return sprintf('/\.(%s)$/', implode('|', $params));
      case 'inList':
        return array('rule' => 'inList', 'params' => $params[0]);
      case 'ip':
        return VALID_IP_JS;
      case 'minLength':
        return sprintf('/^[\s\S]{%d,}$/', $params[0]);
      case 'maxLength':
        return sprintf('/^[\s\S]{0,%d}$/', $params[0]);
      case 'money':
        //The Cake regex for money was giving me issues, even within PHP.  Skip for now
        return array('rule' => 'money');
      case 'multiple':
        $defaults = array('in' => null, 'max' => null, 'min' => null);
        $params = array_merge($defaults, $params[0]);
        return array('rule' => 'multiple', 'params' => $params);
	    case 'notEmpty':
        return array('rule' => 'notEmpty');
      case 'numeric':
        //Cake uses PHP's is_numeric function, which actually accepts a varied input
        //(both +0123.45e6 and 0xFF are valid) then what is allowed in this regular expression.
        //99% of people using this validation probably want to restrict to just numbers in standard
        //decimal notation.  Feel free to alter or delete.
        return '/^[+-]?[0-9|.]+$/';
      case 'range':
      case 'comparison':
        //Don't think there is a way to do this with a regular expressions,
        //so we'll handle this with plain old javascript
        return array('rule' => $rule, 'params' => array($params[0], $params[1]));
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

    if ($regex) {
      //special handling
      switch ($rule) {
        case 'postal':
        case 'ssn':
          //I'm not a regex guru and I have no idea what "\\A\\b" and "\\b\\z" do.
          //Is it just to match start and end of line?  Why not use
          //"^" and "$" then?  Eitherway they don't work in JavaScript.
          return str_replace(array('\\A\\b', '\\b\\z'), array('^', '$'), $regex);
      }
      return $regex;
    }

    return array('rule' => $rule, 'params' => $params);
  }

	function __fixWatch($modelName, $fields) {
		foreach($fields as $i => $field) {
			if (strpos($field, '.') !== false) {
				list($model, $field) = explode('.', $field);
				$fields[$i] = ucfirst($model) . ucfirst($field);
			} else {
				$fields[$i] = $modelName . ucfirst($field);
			}
		}
		
		return $fields;
	}
}
?>