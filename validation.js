/*
 * Javascript Validation CakePHP Helper
 * Copyright (c) 2008 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/cakephp/tree/master/helpers/validation
 * http://sandbox2.pseudocoder.com/demo/validation
 *
 * @author      mattc <matt@pseudocoder.com>
 * @license     MIT
 *
 */
 
function validateForm(form, rules, options) {
  var errors = false;
  
  if (options['messageId'] && $.trim($("#" + options['messageId']).html()) != "" ) {
    $("#" + options['messageId']).slideUp().html("");
  }

  $(".error-message").hide();
  $("input").removeClass("form-error");
  $("div").removeClass("error");

  //loop through the validation rules and check for errors
  $.each(rules, function(field) {
    var val = $.trim($("#" + field).val());
    
    $.each(this, function() {
      //check if the input exists
      if ($("#" + field).attr("id") != undefined) {
        var valid = true;
        
        if (this['allowEmpty'] && val == '') {
          //do nothing
        } else if (this['rule'].match(/^range/)) {
          var range = this['rule'].split('|');
          if (val < parseInt(range[1])) {
            valid = false;
          }
          if (val > parseInt(range[2])) {
            valid = false;
          }
        } else if (this['negate']) {
          if (val.match(eval(this['rule']))) {
            valid = false;
          }
        } else if (!val.match(eval(this['rule']))) {
          valid = false;
        }
        
        if (!valid) {
          errors = true;
          
          //add the error message
          if(options['messageId']) {
            $("#" + options['messageId']).append("<p>" + this['message'] + "</p>");
          }
          
          //add the form-error class to the input
          $("#" + field).addClass("form-error");
          $("#" + field).parents("div:first").addClass("error");
          $("#" + field).after('<div class="error-message">'  + this['message'] +  '</div>');
          
          if (this['last'] === true) {
            return false;
          }  
        }
      }
    });
  });
  
  if(options['messageId']) {
    if($.trim($("#" + options['messageId']).html()) != "") {
      $("#" + options['messageId']).wrapInner("<div class='error'></div>");
      $("#" + options['messageId']).slideDown();
    }
  }
  
  if(errors) {
    return false;
  } else {
    return true;
  }
}