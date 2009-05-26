/*
 * CakePHP jQuery Validation Plugin
 * Copyright (c) 2009 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/cakephp_plugin_validation
 * http://sandbox2.pseudocoder.com/demo/validation
 *
 * @author      mattc <matt@pseudocoder.com>
 * @license     MIT
 *
 */

(function($) {
  var options = null;
  $.fn.validate = function(rules, opts) {
    options = $.extend({}, $.fn.validate.defaults, opts);
    
    return this.each(function() {
      $this = $(this);
      $this.submit(function() {
        var errors = [];
        
        $.fn.validate.beforeFilter();
      
        $.each(rules, function(field) {
          var val = $("#" + field).val();
          if(typeof val == "string") {
            val = $.trim(val);
          }
          
          $.each(this, function() {
            //field doesn't exist...skip
            if ($("#" + field).attr("id") == undefined) {
              return true;
            }

            if (this['allowEmpty'] && typeof val == "string" && val == '') {
              return true;
            }

            if (this['allowEmpty'] && typeof val == "object" && val == null) {
              return true;
            }
            
            if (!$.fn.validate.validateRule(val, this['rule'], this['negate'])) {
              errors.push(this['message']);
              
              $.fn.validate.setError(field, this['message']);
              
              if (this['last'] === true) {
                return false;
              }  
            }
          });
        });
      
        $.fn.validate.afterFilter(errors);

        if(errors.length > 0) {
          return false;
        }
        
        return true;
      });
    });
  };
  
  $.fn.validate.validateRule = function(val, rule, negate) {
    if(negate == undefined) {
      negate = false;
    }
        
    //handle custom functions
    if(typeof rule == 'object') {
      if($.fn.validate[rule.rule] != undefined) {
        return $.fn.validate[rule.rule](val, rule.params);
      } else {
        return true;
      }
    }

    //handle regex rules
    if (negate && val.match(eval(rule))) {
      return false;
    } else if (!negate && !val.match(eval(rule))) {
      return false;
    }
    
    return true;
  };
  
  $.fn.validate.boolean = function(val) {
    return $.fn.validate.inList(val, [0, 1, '0', '1', true, false]);
  };
    
  $.fn.validate.comparison = function(val, params) {
    if(val == "") {
      return false;
    }
    
    val = Number(val);
    if(val == "NaN") {
      return false;
    }
    
    if(eval(val + params[0] + params[1])) {
      return true;
    }
    
    return false;
  };
  
  $.fn.validate.inList = function(val, params) {
    if(params != null) {
      if($.inArray(val, params) == -1) {
        return false;
      }
    }
    
    return true;
  };
  
  $.fn.validate.range = function(val, params) {
    if (val < parseInt(params[0])) {
      return false;
    }
    if (val > parseInt(params[1])) {
      return false;
    }
    
    return true;
  };
  
  $.fn.validate.multiple = function(val, params) {
    if(typeof val != "object" || val == null) {
      return false;
    }
    
    if(params.min != null && val.length < params.min) {
      return false;
    }
    if(params.max != null && val.length > params.max) {
      return false;
    }
    
    if(params.in != null) {
      for(i = 0; i < params.in.length; i ++) {
        if($.inArray(params.in[i], val) == -1) {
          return false;
        }
      }
    }
    
    return true;
  };
  
  $.fn.validate.setError = function(field, message) {
    //add the form-error class to the input
    $("#" + field).addClass("form-error")
                  .parents("div:first").addClass("error")
                  .append('<div class="error-message">'  + message +  '</div>');
  };
  
  $.fn.validate.beforeFilter = function() {
    if(options.messageId != null) {
      $("#" + options.messageId).html("")
                                .slideDown();
    }
    
    $(".error-message").hide();
    $("input").removeClass("form-error");
    $("div").removeClass("error")
  };  

  $.fn.validate.afterFilter = function(errors) {
    if(options.messageId != null) {
      $("#" + options.messageId).html(errors.join("<br />"))
                                .slideDown();
    }
  };
})(jQuery);