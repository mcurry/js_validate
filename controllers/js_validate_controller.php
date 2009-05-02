<?php
class JsValidateController extends JsValidateAppController {
	var $name = 'JsValidate';
  var $helpers = array('JsValidate.Validation');
  
	function test() {
    if (Configure::read('debug') < 1) {
      die(__('Debug setting does not allow access to this url.', true));
    }
	}
}

?>