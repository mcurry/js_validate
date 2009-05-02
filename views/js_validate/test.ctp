<?php echo $javascript->link(array('http://jqueryjs.googlecode.com/svn/trunk/qunit/testrunner.js',
                                   '/js_validate/js/jquery.validation')); ?>
<?php echo $html->css(array('http://jqueryjs.googlecode.com/svn/trunk/qunit/testsuite.css')); ?>

<script type="text/javascript">
  var validationRules = <?php echo $validation->bind('JsValidate', array('form' => false)) ?>;
</script>

<?php echo $javascript->link(array('/js_validate/js/unit_tests')); ?>

<h1>CakePHP jQuery Validation Unit Tests</h1>
<h2 id="banner"></h2>
<h2 id="userAgent"></h2>

<ol id="tests"></ol>

<div id="main"></div>
