/*
 * Javascript Validation CakePHP Helper
 * Copyright (c) 2008 Matt Curry
 * www.PseudoCoder.com
 *
 * @author      mattc <matt@pseudocoder.com>
 * @version     0.2
 * @license     MIT
 *
 */
 
function validateForm(form, rules, options) {
  console.log(options);
  
  var errors = false;
  
  //clear out any old errors
  if (options['messageId']) {
    $("#" + options['messageId']).html("");
    $("#" + options['messageId']).slideUp();
  }
  $(".error-message").hide();
  $("input").removeClass("form-error");
  
  //loop through the validation rules and check for errors
  $.each(rules, function(field) {
    var val = $.trim($("#" + field).val());
    
    $.each(this, function() {
      console.log(this['rule']);
      
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
          console.log(eval(options));
          if(options['messageId']) {
            console.log("here");
            $("#" + options['messageId']).append("<p>" + this['message'] + "</p>");
          }
          
          //add the form-error class to the input
          $("#" + field).addClass("form-error");
          $("#" + field).after('<div class="error-message">'  + this['message'] +  '</div>');
        }
      }
    });
  });
  
  if(options['messageId']) {
    if($("#" + options['messageId']).html() != "") {
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