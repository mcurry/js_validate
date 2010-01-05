<?php $javascript->codeBlock('var validationRules = ' . $validation->bind('JsValidate', array('form' => false)) . ';',
                             array('inline' => false)); ?>
                             
<?php echo $javascript->link(array('/js_validate/js/jquery.validation.min',
                                   'http://github.com/jquery/qunit/raw/master/qunit/qunit.js',
                                   '/js_validate/js/unit_tests'),
                             false); ?>
<?php echo $html->css(array('http://github.com/jquery/qunit/raw/master/qunit/qunit.css'), null, null, false); ?>

<h1>CakePHP jQuery Validation Unit Tests</h1>
<h2 id="banner"></h2>
<h2 id="userAgent"></h2>

<ol id="tests"></ol>

<div id="main"></div>
