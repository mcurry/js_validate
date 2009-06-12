$(function(){
  test("alphaNumeric", function() {    
    ok( $.fn.validate.validateRule("Ab1", validationRules.JsValidateAlphaNumeric[0].rule), "Ab1");
    ok( !$.fn.validate.validateRule("Ab 1", validationRules.JsValidateAlphaNumeric[0].rule), "Ab 1");
    ok( !$.fn.validate.validateRule("Ab1 ", validationRules.JsValidateAlphaNumeric[0].rule), "Ab1 ");
    ok( !$.fn.validate.validateRule("A+b", validationRules.JsValidateAlphaNumeric[0].rule), "A+b");
  });
  
  test("between", function() {    
    ok( $.fn.validate.validateRule("aaaaa", validationRules.JsValidateBetween[0].rule), "aaaaa");
    ok( $.fn.validate.validateRule("aaaaaaa", validationRules.JsValidateBetween[0].rule), "aaaaaaa");
    ok( $.fn.validate.validateRule("aaaaaaaaaa", validationRules.JsValidateBetween[0].rule), "aaaaaaaaaa");
    ok( !$.fn.validate.validateRule("aaaaaaaaaaaaaaaaaaaa", validationRules.JsValidateBetween[0].rule), "aaaaaaaaaaaaaaaaaaaa");
    ok( !$.fn.validate.validateRule("", validationRules.JsValidateBetween[0].rule), "");
  });
  
  test("blank", function() {    
    ok( $.fn.validate.validateRule("", validationRules.JsValidateBlank[0].rule, true), "<blank>");
    ok( $.fn.validate.validateRule("  ", validationRules.JsValidateBlank[0].rule, true), "<space>");
    ok( !$.fn.validate.validateRule("a", validationRules.JsValidateBlank[0].rule, true), "a");
  });
  
  test("boolean", function() {    
    ok( $.fn.validate.validateRule(1, validationRules.JsValidateBoolean[0].rule), "int 1");
    ok( $.fn.validate.validateRule(0, validationRules.JsValidateBoolean[0].rule), "int 0");
    ok( $.fn.validate.validateRule("1", validationRules.JsValidateBoolean[0].rule), "str 1");
    ok( $.fn.validate.validateRule("0", validationRules.JsValidateBoolean[0].rule), "str 0");
    ok( $.fn.validate.validateRule(true, validationRules.JsValidateBoolean[0].rule), "bool true");
    ok( $.fn.validate.validateRule(false, validationRules.JsValidateBoolean[0].rule), "bool false");
    ok( !$.fn.validate.validateRule("01", validationRules.JsValidateBoolean[0].rule), "01");
    ok( !$.fn.validate.validateRule("true", validationRules.JsValidateBoolean[0].rule), "str true");
    ok( !$.fn.validate.validateRule("a", validationRules.JsValidateBoolean[0].rule), "a");
  });
  
  test("cc", function() {    
    ok( $.fn.validate.validateRule("12345", validationRules.JsValidateCc[0].rule), "12345");
  });
  
  test("comparison", function() {    
    ok( $.fn.validate.validateRule("18", validationRules.JsValidateComparison[0].rule), "18");
    ok( $.fn.validate.validateRule("19", validationRules.JsValidateComparison[0].rule), "19");
    ok( !$.fn.validate.validateRule("12", validationRules.JsValidateComparison[0].rule), "12");
    ok( $.fn.validate.validateRule("1", validationRules.JsValidateComparison[1].rule), "1");
    ok( $.fn.validate.validateRule("-3", validationRules.JsValidateComparison[1].rule), "-3");
    ok( !$.fn.validate.validateRule("3", validationRules.JsValidateComparison[1].rule), "3");
  });
  
  test("date", function() {    
    ok( $.fn.validate.validateRule("12345", validationRules.JsValidateDate[0].rule), "12345");
  });
  
  test("decimal", function() {    
    ok( $.fn.validate.validateRule("2.2", validationRules.JsValidateDecimal[0].rule), "2.2");
    ok( !$.fn.validate.validateRule("2", validationRules.JsValidateDecimal[0].rule), "2");
    ok( $.fn.validate.validateRule("-2.2", validationRules.JsValidateDecimal[0].rule), "-2.2");
    ok( !$.fn.validate.validateRule("2.", validationRules.JsValidateDecimal[0].rule), "2.");
    ok( $.fn.validate.validateRule("2.2663", validationRules.JsValidateDecimal[1].rule), "2.26653");
    ok( !$.fn.validate.validateRule("2.23", validationRules.JsValidateDecimal[1].rule), "2.23");
  });
  
  test("email", function() {    
    ok( $.fn.validate.validateRule("a@a.com", validationRules.JsValidateEmail[0].rule), "a@a.com");
    ok( !$.fn.validate.validateRule("a@.com", validationRules.JsValidateEmail[0].rule), "a@.com");
    ok( !$.fn.validate.validateRule("@a.com", validationRules.JsValidateEmail[0].rule), "@a.com");
    ok( !$.fn.validate.validateRule("a@a.c", validationRules.JsValidateEmail[0].rule), "a@a.c");
    ok( !$.fn.validate.validateRule("a@a.", validationRules.JsValidateEmail[0].rule), "a@a.");
    ok( !$.fn.validate.validateRule("a.com", validationRules.JsValidateEmail[0].rule), "a.com");
  });
  
  test("equalTo", function() {    
    ok( $.fn.validate.validateRule("file.gif", validationRules.JsValidateExtension[0].rule), "file.gif");
    ok( !$.fn.validate.validateRule("file.psd", validationRules.JsValidateExtension[0].rule), "file.psd");
    ok( !$.fn.validate.validateRule("file.gif", validationRules.JsValidateExtension[1].rule), "file.gif");
    ok( $.fn.validate.validateRule("file.psd", validationRules.JsValidateExtension[1].rule), "file.psd");
  });
  
   test("inList", function() {    
    ok( $.fn.validate.validateRule("foo", validationRules.JsValidateInList[0].rule), "foo");
    ok( $.fn.validate.validateRule("bar", validationRules.JsValidateInList[0].rule), "bar");
    ok( !$.fn.validate.validateRule("foobar", validationRules.JsValidateInList[0].rule), "foobar");
  });
   
  test("ip", function() {    
    ok( $.fn.validate.validateRule("192.168.1.1", validationRules.JsValidateIp[0].rule), "192.168.1.1");
    ok( !$.fn.validate.validateRule("1921.168.1.1", validationRules.JsValidateIp[0].rule), "1921.168.1.1");
  });
  
  test("isUnique", function() {    
    ok( $.fn.validate.validateRule("test", validationRules.JsValidateIsUnique[0].rule), "test");
  });
  
  test("minLength", function() {    
    ok( $.fn.validate.validateRule("aaaaa", validationRules.JsValidateMinLength[0].rule), "aaaaa");
    ok( $.fn.validate.validateRule("aaaaaa", validationRules.JsValidateMinLength[0].rule), "aaaaaa");
    ok( !$.fn.validate.validateRule("aaaa", validationRules.JsValidateMinLength[0].rule), "aaaa");
  });
  
  test("maxLength", function() {    
    ok( $.fn.validate.validateRule("aaaaa", validationRules.JsValidateMaxLength[0].rule), "aaaaa");
    ok( $.fn.validate.validateRule("aaaaaaa", validationRules.JsValidateMaxLength[0].rule), "aaaaaaa");
    ok( !$.fn.validate.validateRule("aaaaaaaaaaaa", validationRules.JsValidateMaxLength[0].rule), "aaaaaaaaaaaa");
  });
  
  test("money", function() {    
    ok( $.fn.validate.validateRule("$cash", validationRules.JsValidateMoney[0].rule), "$cash");
  });
  
  test("multiple", function() {    
    ok( $.fn.validate.validateRule(["foo", "bar"], validationRules.JsValidateMultiple[0].rule), '["foo", "bar"]');
    ok( $.fn.validate.validateRule(["foo", "bar", "cat"], validationRules.JsValidateMultiple[0].rule), '["foo", "bar", "cat"]');
    ok( !$.fn.validate.validateRule(["foo", "bar", "cat", "dog"], validationRules.JsValidateMultiple[0].rule), '["foo", "bar", "cat", "dog"]');
    ok( !$.fn.validate.validateRule(["foo", "Bar"], validationRules.JsValidateMultiple[0].rule), '["foo", "bar"]');
  });
  
  test("numeric", function() {    
    ok( $.fn.validate.validateRule("49", validationRules.JsValidateNumeric[0].rule), "49");
    ok( $.fn.validate.validateRule("+49", validationRules.JsValidateNumeric[0].rule), "+49");
    ok( $.fn.validate.validateRule("-49", validationRules.JsValidateNumeric[0].rule), "-49");
    ok( $.fn.validate.validateRule("49.5", validationRules.JsValidateNumeric[0].rule), "49.5");
    ok( !$.fn.validate.validateRule("forty nine", validationRules.JsValidateNumeric[0].rule), "forty nine");
  });
  
  test("notEmpty", function() {    
    ok( $.fn.validate.validateRule("whatever", validationRules.JsValidateNotEmpty[0].rule), "whatever");
    ok( !$.fn.validate.validateRule("", validationRules.JsValidateNotEmpty[0].rule), "<blank>");
  });
  
  test("phone", function() {    
    ok( $.fn.validate.validateRule("555-555-5555", validationRules.JsValidatePhone[0].rule), "555-555-5555");
    ok( !$.fn.validate.validateRule("555-5a5-5555", validationRules.JsValidatePhone[0].rule), "555-5a5-5555");
  });
  
  test("postal", function() {    
    ok( $.fn.validate.validateRule("12345", validationRules.JsValidatePostal[0].rule), "12345");
    ok( $.fn.validate.validateRule("12345-9876", validationRules.JsValidatePostal[0].rule), "12345-9876");
    ok( !$.fn.validate.validateRule("1234a-9876", validationRules.JsValidatePostal[0].rule), "1234a-9876");
  });
  
  test("range", function() {    
    ok( $.fn.validate.validateRule("5", validationRules.JsValidateRange[0].rule), "5");
    ok( $.fn.validate.validateRule("0", validationRules.JsValidateRange[0].rule), "0");
    ok( $.fn.validate.validateRule("10", validationRules.JsValidateRange[0].rule), "10");
    ok( !$.fn.validate.validateRule("-1", validationRules.JsValidateRange[0].rule), "-1");
    ok( !$.fn.validate.validateRule("12", validationRules.JsValidateRange[0].rule), "12");
  });
  
  test("ssn", function() {    
    ok( $.fn.validate.validateRule("555-55-5555", validationRules.JsValidateSsn[0].rule), "555-55-5555");
    ok( !$.fn.validate.validateRule("5a5-55-5555", validationRules.JsValidateSsn[0].rule), "55-5a5-5555");
  });
  
  test("url", function() {    
    ok( $.fn.validate.validateRule("www.pseudocoder.com", validationRules.JsValidateUrl[0].rule), "www.pseudocoder.com");
    ok( $.fn.validate.validateRule("http://cakephp.org", validationRules.JsValidateUrl[0].rule), "http://cakephp.org");
    ok( !$.fn.validate.validateRule("ww.zendcm", validationRules.JsValidateUrl[0].rule), "ww.zendcm");
  });
});