<?php
class JsValidateController extends JsValidateAppController {
	var $name = 'JsValidate';
  var $helpers = array('JsValidate.Validation');
  
  function beforeFilter() {
    if (Configure::read('debug') < 1) {
      die(__('Debug setting does not allow access to this url.', true));
    }
  }
  
	function test() {
	}

	function test_min() {
	}
}

?>