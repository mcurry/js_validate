<?php echo $this->Javascript->codeBlock('var validationRules = ' . $validation->bind('JsValidate', array('form' => false)) . ';'); ?>
                             
<?php echo $this->Html->script(array('/js_validate/js/jquery.validation',
                                   'http://github.com/jquery/qunit/raw/master/qunit/qunit.js',
                                   '/js_validate/js/unit_tests')); ?>
<?php echo $this->Html->css(array('http://github.com/jquery/qunit/raw/master/qunit/qunit.css')); ?>

<h1 id="qunit-header">CakePHP jQuery Validation Unit Tests</h1>
<h2 id="qunit-banner"></h2>
<h2 id="qunit-userAgent"></h2>
<ol id="qunit-tests"></ol>