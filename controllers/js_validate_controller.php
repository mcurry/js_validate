<?php
class JsValidateController extends JsValidateAppController {
	var $name = 'JsValidate';
	var $helpers = array('Javascript', 'JsValidate.Validation');
	var $components = array('RequestHandler');

	function beforeFilter() {

	}

	function field($fieldId) {
		Configure::write('debug', 0);

		$modelName = array_shift(array_keys($this->data));
		$Model = ClassRegistry::init($modelName);
		$Model->data = $this->data;

		$fieldName = array_shift(array_keys(array_shift($this->data)));

		$output = array('field' => $fieldId);
		$output['result'] = $Model->validates(array('fieldList' => array($fieldName)));

		$errors = $Model->validationErrors;
		if ($errors) {
			$output['message'] = array_pop($errors);
		}

		$this->set('output', $output);
	}

	function test() {
		if (Configure::read('debug') < 1) {
			die(__('Debug setting does not allow access to this url.', true));
		}
	}

	function test_min() {
		if (Configure::read('debug') < 1) {
			die(__('Debug setting does not allow access to this url.', true));
		}
	}
}
?>