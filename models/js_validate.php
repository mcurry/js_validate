<?php
class JsValidate extends JsValidateAppModel {
  var $name = 'JsValidate';
  var $useTable = false;

  var $validate = array(
                    'alphaNumeric' => array(
                                      'rule1' => array('rule' => 'alphaNumeric')
                                    ),
                    'between' => array(
                                 'rule1' => array('rule' => array('between', 5, 10))
                               ),
                    'blank' => array(
                               'rule1' => array('rule' => 'blank')
                             ),
                    'boolean' => array(
                                 'rule1' => array('rule' => 'boolean')
                               ),
                    'cc' => array(
                            'rule1' => array('rule' => 'cc')
                          ),
                    'comparison' => array(
                                    'rule1' => array('rule' => array('comparison', '>=', 18)),
                                    'rule2' => array('rule' => array('comparison', 'is less', 3))
                                  ),
                    'date' => array(
                              'rule1' => array('rule' => 'date')
                            ),
                    'decimal' => array(
                              'rule1' => array('rule' => 'decimal'),
                              'rule2' => array('rule' => array('decimal', 4))
                            ),
                    'email' => array(
                              'rule1' => array('rule' => 'email')
                            ),
                    'equalTo' => array(
                              'rule1' => array('rule' => array('equalTo', 'cake')) 
                            ),
                    'extension' => array(
                              'rule1' => array('rule' => 'extension'),
                              'rule2' => array('rule' => array('extension', array('psd')))
                            ),
                    'ip' => array(
                              'rule1' => array('rule' => 'ip')
                            ),
                    'isUnique' => array(
                              'rule1' => array('rule' => 'isUnique')
                            ),
                    'minLength' => array(
                              'rule1' => array('rule' => array('minLength', '5'))
                            ),
                    'maxLength' => array(
                              'rule1' => array('rule' => array('maxLength', '7'))
                            ),
                    'money' => array(
                              'rule1' => array('rule' => 'money')
                            ),
                    'multiple' => array(
                              'rule1' => array('rule' => array('multiple', array('in' => array('foo', 'bar'), 'min' => 1, 'max' => 3)))
                            ),
                    'inList' => array(
                              'rule1' => array('rule' => array('inList', array('foo', 'bar')))
                            ),
                    'numeric' => array(
                              'rule1' => array('rule' => 'numeric')
                            ),
                    'notEmpty' => array(
                              'rule1' => array('rule' => 'notEmpty')
                            ),
                    'phone' => array(
                              'rule1' => array('rule' => array('phone', null, 'us'))
                            ),
                    'postal' => array(
                              'rule1' => array('rule' => array('postal', null, 'us'))
                            ),
                    'range' => array(
                              'rule1' => array('rule' => array('range', 0, 10))
                            ),
                    'ssn' => array(
                              'rule1' => array('rule' => array('ssn', null, 'us'))
                            ),
                    'url' => array(
                              'rule1' => array('rule' => 'url')
                            )
                  );
}
?>