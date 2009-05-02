<?php $javascript->codeBlock('var validationRules = ' . $validation->bind('JsValidate', array('form' => false)) . ';',
                             array('inline' => false)); ?>
                             
<?php echo $javascript->link(array('http://jqueryjs.googlecode.com/svn/trunk/qunit/testrunner.js',
                                   '/js_validate/js/unit_tests'),
                             false); ?>
<?php echo $html->css(array('http://jqueryjs.googlecode.com/svn/trunk/qunit/testsuite.css'), null, null, false); ?>

<h1>CakePHP jQuery Validation Unit Tests</h1>
<h2 id="banner"></h2>
<h2 id="userAgent"></h2>

<ol id="tests"></ol>

<div id="main"></div>
