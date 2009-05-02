<?php
App::import('Helper', array('JsValidate.Validation', 'Javascript'));
App::import('Model', 'JsValidate.JsValidate');

class JsValidateTestCase extends CakeTestCase {
  var $JsValidate = null;
  var $Validation = null;

  function start() {
    parent::start();
    $this->JsValidate = & ClassRegistry::init('JsValidate.JsValidate');
    $this->JsValidate->backupValidate = $this->JsValidate->validate;
    $this->JsValidate->validate = array();

    $this->Validation = new ValidationHelper();
    $this->Validation->Javascript = new JavascriptHelper();
  }

  function testInstances() {
    $this->assertTrue(is_a($this->JsValidate, 'JsValidate'));
    $this->assertTrue(is_a($this->Validation, 'ValidationHelper'));
    $this->assertTrue(is_a($this->Validation->Javascript, 'JavascriptHelper'));
  }

  function testNoValidation() {
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $this->assertEqual('[]', $validation);
  }

  function testAlphaNumeric() {
    $this->JsValidate->validate = array('alphaNumberic' => $this->JsValidate->backupValidate['alphaNumeric']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateAlphaNumberic":[{"rule":"\/^[0-9A-Za-z]+$\/","message":"There was a problem with the field AlphaNumberic"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testBetween() {
    $this->JsValidate->validate = array('between' => $this->JsValidate->backupValidate['between']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateBetween":[{"rule":"\/^.{5,10}$\/","message":"There was a problem with the field Between"}]}';
    $this->assertEqual($expected, $validation);
    
  }

  function testBlank() {
    $this->JsValidate->validate = array('blank' => $this->JsValidate->backupValidate['blank']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateBlank":[{"rule":"\/[^\\\\s]\/","message":"There was a problem with the field Blank","negate":true}]}';
    $this->assertEqual($expected, $validation);
  }

  function testBoolean() {
    $this->JsValidate->validate = array('boolean' => $this->JsValidate->backupValidate['boolean']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateBoolean":[{"rule":{"rule":"boolean"},"message":"There was a problem with the field Boolean"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testCC() {
    $this->JsValidate->validate = array('cc' => $this->JsValidate->backupValidate['cc']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateCc":[{"rule":{"rule":"cc","params":[]},"message":"There was a problem with the field Cc"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testComparison() {
    $this->JsValidate->validate = array('comparison' => $this->JsValidate->backupValidate['comparison']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateComparison":[{"rule":{"rule":"comparison","params":[">=",18]},"message":"There was a problem with the field Comparison"},{"rule":{"rule":"comparison","params":["<",3]},"message":"There was a problem with the field Comparison"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testDate() {
    $this->JsValidate->validate = array('date' => $this->JsValidate->backupValidate['date']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateDate":[{"rule":{"rule":"date","params":"ymd"},"message":"There was a problem with the field Date"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testDecimal() {
    $this->JsValidate->validate = array('decimal' => $this->JsValidate->backupValidate['decimal']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateDecimal":[{"rule":"\/^[-+]?[0-9]*\\\\.{1}[0-9]+(?:[eE][-+]?[0-9]+)?$\/","message":"There was a problem with the field Decimal"},{"rule":"\/^[-+]?[0-9]*\\\\.{1}[0-9]{4}$\/","message":"There was a problem with the field Decimal"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testEmail() {
    $this->JsValidate->validate = array('email' => $this->JsValidate->backupValidate['email']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateEmail":[{"rule":"\/^([a-zA-Z0-9_\\\\.\\\\-])+\\\\@(([a-zA-Z0-9\\\\-])+\\\\.)+([a-zA-Z0-9]{2,4})+$\/","message":"There was a problem with the field Email"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testEqualTo() {
    $this->JsValidate->validate = array('equalTo' => $this->JsValidate->backupValidate['equalTo']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateEqualTo":[{"rule":"\/^cake$\/","message":"There was a problem with the field EqualTo"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testExtension() {
    $this->JsValidate->validate = array('extension' => $this->JsValidate->backupValidate['extension']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateExtension":[{"rule":"\/\\\\.(gif|jpeg|png|jpg)$\/","message":"There was a problem with the field Extension"},{"rule":"\/\\\\.(psd)$\/","message":"There was a problem with the field Extension"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testInList() {
    $this->JsValidate->validate = array('inList' => $this->JsValidate->backupValidate['inList']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateInList":[{"rule":{"rule":"inList","params":["foo","bar"]},"message":"There was a problem with the field InList"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testIp() {
    $this->JsValidate->validate = array('ip' => $this->JsValidate->backupValidate['ip']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateIp":[{"rule":"\/^[\\\\d]{1,3}\\\\.[\\\\d]{1,3}\\\\.[\\\\d]{1,3}\\\\.[\\\\d]{1,3}$\/","message":"There was a problem with the field Ip"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testIsUnique() {
    $this->JsValidate->validate = array('isUnique' => $this->JsValidate->backupValidate['isUnique']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateIsUnique":[{"rule":{"rule":"isUnique","params":[]},"message":"There was a problem with the field IsUnique"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testMinLength() {
    $this->JsValidate->validate = array('minLength' => $this->JsValidate->backupValidate['minLength']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateMinLength":[{"rule":"\/^.{5,}$\/","message":"There was a problem with the field MinLength"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testMaxLength() {
    $this->JsValidate->validate = array('maxLength' => $this->JsValidate->backupValidate['maxLength']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateMaxLength":[{"rule":"\/^.{0,7}$\/","message":"There was a problem with the field MaxLength"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testIsMoney() {
    $this->JsValidate->validate = array('money' => $this->JsValidate->backupValidate['money']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateMoney":[{"rule":{"rule":"money"},"message":"There was a problem with the field Money"}]}';
    $this->assertEqual($expected, $validation);
  }

  function testIsMultiple() {
    $this->JsValidate->validate = array('multiple' => $this->JsValidate->backupValidate['multiple']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateMultiple":[{"rule":{"rule":"multiple","params":{"in":["foo","bar"],"max":3,"min":1}},"message":"There was a problem with the field Multiple"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testNumeric() {
    $this->JsValidate->validate = array('numeric' => $this->JsValidate->backupValidate['numeric']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateNumeric":[{"rule":"\/^[+-]?[0-9]+$\/","message":"There was a problem with the field Numeric"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function atestNotEmpty() {
    $this->JsValidate->validate = array('notEmpty' => $this->JsValidate->backupValidate['notEmpty']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateNotEmpty":[{"rule":"\/[^\\\\s]+\/m","message":"There was a problem with the field notEmpty"}]}';
    $this->assertEqual($expected, $validation);
  }
}