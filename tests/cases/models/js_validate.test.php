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
    $expected = '{"JsValidate.JsValidateMinLength":[{"rule":"\/^[\\\\s\\\\S]{5,}$\/","message":"There was a problem with the field MinLength"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testMaxLength() {
    $this->JsValidate->validate = array('maxLength' => $this->JsValidate->backupValidate['maxLength']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateMaxLength":[{"rule":"\/^[\\\\s\\\\S]{0,7}$\/","message":"There was a problem with the field MaxLength"}]}';
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
    $expected = '{"JsValidate.JsValidateNumeric":[{"rule":"\/^[+-]?[0-9|.]+$\/","message":"There was a problem with the field Numeric"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testNotEmpty() {
    $this->JsValidate->validate = array('notEmpty' => $this->JsValidate->backupValidate['notEmpty']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateNotEmpty":[{"rule":{"rule":"notEmpty"},"message":"There was a problem with the field NotEmpty"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testPhone() {
    $this->JsValidate->validate = array('phone' => $this->JsValidate->backupValidate['phone']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidatePhone":[{"rule":"\/^(?:\\\\+?1)?[-. ]?\\\\(?[2-9][0-8][0-9]\\\\)?[-. ]?[2-9][0-9]{2}[-. ]?[0-9]{4}$\/","message":"There was a problem with the field Phone"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testPostal() {
    $this->JsValidate->validate = array('postal' => $this->JsValidate->backupValidate['postal']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidatePostal":[{"rule":"\/^[0-9]{5}(?:-[0-9]{4})?$\/i","message":"There was a problem with the field Postal"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testRange() {
    $this->JsValidate->validate = array('range' => $this->JsValidate->backupValidate['range']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateRange":[{"rule":{"rule":"range","params":[0,10]},"message":"There was a problem with the field Range"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testSsn() {
    $this->JsValidate->validate = array('ssn' => $this->JsValidate->backupValidate['ssn']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateSsn":[{"rule":"\/^[0-9]{3}-[0-9]{2}-[0-9]{4}$\/i","message":"There was a problem with the field Ssn"}]}';
    $this->assertEqual($expected, $validation);
  }
  
  function testUrl() {
    $this->JsValidate->validate = array('url' => $this->JsValidate->backupValidate['url']);
    $validation = $this->Validation->bind('JsValidate.JsValidate', array('form' => false));
    $expected = '{"JsValidate.JsValidateUrl":[{"rule":"\/^(?:(?:https?|ftps?|file|news|gopher):\\\\\/\\\\\/)?(?:(?:(?:25[0-5]|2[0-4][0-9]|(?:(?:1[0-9])?|[1-9]?)[0-9])\\\\.){3}(?:25[0-5]|2[0-4][0-9]|(?:(?:1[0-9])?|[1-9]?)[0-9])|(?:[a-z0-9][-a-z0-9]*\\\\.)*(?:[a-z0-9][-a-z0-9]{0,62})\\\\.(?:(?:[a-z]{2}\\\\.)?[a-z]{2,4}|museum|travel))(?::[1-9][0-9]{0,3})?(?:\\\\\/?|\\\\\/([\\\\!\"\\\\$&\'\\\\(\\\\)\\\\*\\\\+,-\\\\.@_\\\\:;\\\\=\\\\\/0-9a-z]|(%[0-9a-f]{2}))*)?(?:\\\\?([\\\\!\"\\\\$&\'\\\\(\\\\)\\\\*\\\\+,-\\\\.@_\\\\:;\\\\=\\\\\/0-9a-z]|(%[0-9a-f]{2}))*)?(?:#([\\\\!\"\\\\$&\'\\\\(\\\\)\\\\*\\\\+,-\\\\.@_\\\\:;\\\\=\\\\\/0-9a-z]|(%[0-9a-f]{2}))*)?$\/i","message":"There was a problem with the field Url"}]}';
    $this->assertEqual($expected, $validation);
  }
}