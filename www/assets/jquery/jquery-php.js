/*
 * jQuery PHP Plugin
 * version: 0.8.3 (16/03/2009)
 * author:  Anton Shevchuk (http://anton.shevchuk.name)
 * @requires jQuery v1.2.1 or later
 * Examples and documentation at: http://jquery.hohli.com/
 */
(function($) {

$.extend({
    php: function (url, params) {
        $.ajax({
           url: "/" + url,
           type: "POST",
           data: params,
           dataType : "json",
           beforeSend: function(){
               return php.beforeSend();
           },
           success: function(data, textStatus){
               return php.success(data, textStatus);
           },
           error: function (xmlEr, typeEr, except) {
               return php.error(xmlEr, typeEr, except);
           },
           complete: function (XMLHttpRequest, textStatus) {
               return php.complete(XMLHttpRequest, textStatus);
           }
        });
    }
});



php = {
    beforeSend:function() {
        return true;
    },
     success:function (response, textStatus) {
		for (var i=0;i<response['q'].length; i++) {
			var selector  = $(response['q'][i]['s']);
			var methods   = response['q'][i]['m'];
			var arguments = response['q'][i]['a'];
			for (var j=0;j<methods.length; j++) {
				try {
					var method   = methods[j];
					var argument = arguments[j];
					if (method && method!= '' && method!= 'undefined') {
					    switch (true) {
					        case (method == 'ready' || method == 'map' || method == 'queue'):
					           selector = selector[method](window[argument[0]]);
					           break;
					        case ((method == 'bind' || method == 'one') && argument.length == 3):
					           selector = selector[method](argument[0],argument[1],window[argument[2]]);
					           break;
					        case ((method == 'toggle' || method == 'hover') && argument.length == 2):
					           selector = selector[method](window[argument[0]],window[argument[1]]);
					           break;
					        case (method == 'filter' && argument.length == 1):
					           if (window[argument[0]] && window[argument[0]] != '' && window[argument[0]] != 'undefined') {
					               selector = selector[method](window[argument[0]]);
					           } else {
					               selector = selector[method](argument[0]);
					           }
					           break;
					        case ((   method == 'show'      || method == 'hide'
					               || method == 'slideDown' || method == 'slideUp' || method == 'slideToggle'
					               || method == 'fadeIn'    || method == 'fadeOut'

					             ) && argument.length == 2):
					           selector = selector[method](argument[0],window[argument[1]]);
					           break;
					        case ((   method == 'blur'      || method == 'change'
					               || method == 'click'     || method == 'dblclick'
					               || method == 'error'     || method == 'focus'
					               || method == 'keydown'   || method == 'keypress'  || method == 'keyup'
					               || method == 'load'      || method == 'unload'
					               || method == 'mousedown' || method == 'mousemove' || method == 'mouseout'
					               || method == 'mouseover' || method == 'mouseup'
					               || method == 'resize'    || method == 'scroll'
					               || method == 'select'    || method == 'submit'
					             ) && argument.length == 1):
					           selector = selector[method](window[argument[0]]);
					           break;
					        case (method == 'fadeTo' && argument.length == 3):
					           selector = selector[method](argument[0],argument[1],window[argument[2]]);
					           break;
					        case (method == 'animate' && argument.length == 4):
					           selector = selector[method](argument[0],argument[1],argument[2],window[argument[3]]);
					           break;
					        case (argument.length == 0):
					           selector = selector[method]();
					           break;
					        case (argument.length == 1):
					           selector = selector[method](argument[0]);
					           break;
					        case (argument.length == 2):
					           selector = selector[method](argument[0],argument[1]);
					           break;
					        case (argument.length == 3):
					           selector = selector[method](argument[0],argument[1],argument[2]);
					           break;
					        case (argument.length == 4):
					           selector = selector[method](argument[0],argument[1],argument[2],argument[3]);
					           break;
					        default:
					           selector = selector[method](argument);
					           break;
					    }
					}
				} catch (error) {
					alert('onAction: $("'+ response['q'][i]['s'] +'").'+ method +'("'+ argument +'")\n'
									+' in file: ' + error.fileName + '\n'
									+' on line: ' + error.lineNumber +'\n'
									+' error:   ' + error.message);
				}
		    }
	    }
        $.each(response['a'], function (func, params) {
            for (var i=0;i<params.length; i++) {
                try {
                    php[func](params[i]);
                } catch (error) {
                    alert('onAction: ' + func + '('+ params[i] +')\n'
                                       +' in file: ' + error.fileName + '\n'
                                       +' on line: ' + error.lineNumber +'\n'
                                       +' error:   ' + error.message);
                }
            }
        });
    },
     error:function (xmlEr, typeEr, except) {
        var exObj = except ? except : false;
        $('#php-error').remove();
        var printCss  =
            "<style type='text/css'>" +
                "#php-error{ width:640px; position:absolute; top:4px; right:4px; border:1px solid #f00;z-index:100000 }"+
                "#php-error .php-title{ width:636px; height:26px; position:relative; line-height:26px; background-color:#f66; color:#fff; font-weight:bold; font-size:12px;padding-left:4px; }"+
                "#php-error .php-more { width:20px;  height:20px; position:absolute; top:2px; right:24px; line-height:20px; text-align:center; cursor:pointer; border:1px solid #f00; background-color:#fee; color:#333; }"+
                "#php-error .php-close{ width:20px;  height:20px; position:absolute; top:2px; right:2px;  line-height:20px; text-align:center; cursor:pointer; border:1px solid #f00; background-color:#fee; color:#333; }"+
                "#php-error .php-desc { width:636px; position:relative; background-color:#fee;padding-left:4px;}"+
                "#php-error .php-content{ display:none;}"+
                "#php-error textarea{ width:634px;height:400px;overflow:auto;padding:2px;}"+
            "</style>";
        var printStr  =
            "<div id='php-error'>"+
                "<div class='php-title'>Error in AJAX request"+
                    "<div class='php-more'>&raquo;</div>"+
                    "<div class='php-close'>X</div>"+
                "</div>"+
                "<div class='php-desc'>";
            printStr += "<b>XMLHttpRequest exchange</b>: ";
        switch (xmlEr.readyState) {
            case 0:
                readyStDesc = "not initialize";
                break;
            case 1:
                readyStDesc = "open";
                break;
            case 2:
                readyStDesc = "data transfer";
                break;
            case 3:
                readyStDesc = "loading";
                break;
            case 4:
                readyStDesc = "finish";
                break;
            default:
                return "uncknown state";
        }
        printStr += readyStDesc+" ("+xmlEr.readyState+")";
        printStr += "<br/>\n";

        if (exObj!=false) {
            printStr += "exception was catch: "+except.toString();
            printStr += "<br/>\n";
        }
        printStr += "<b>HTTP status</b>: "+xmlEr.status +" - "+xmlEr.statusText;
        printStr += "<br/>\n";
        printStr += "<b>Response text</b> (<small><a href='#' class='php-more2'>show more information &raquo;</a></small>):";
        printStr += "</div>\n";
        printStr += "<div class='php-content'><textarea>"+ xmlEr.responseText+"</textarea></div>";
        printStr += "</div>" ;
        $(document.body).append(printCss);
        $(document.body).append(printStr);
        $('#php-error .php-more').hover(
            function(){
                $(this).css('background-color','#fff')
            },
            function(){
                $(this).css('background-color','#fee')
            });
        $('#php-error .php-more').click(function(){
            $('#php-error .php-content').slideToggle();
        });
        $('#php-error .php-more2').click(function(){
            $('#php-error .php-content').slideToggle();
            return false;
        });

        $('#php-error .php-close').click(function(){
            $('#php-error').fadeOut('fast',function(){$('#php-error').remove()})
        });

        $('#php-error .php-close').hover(
            function(){
                $(this).css('background-color','#fff')
            },
            function(){
                $(this).css('background-color','#fee')
            });
    },
    complete:function(XMLHttpRequest, textStatus) {
        return true;
    },
    addMessage:function(data) {
        var message        = data.msg      || "";
        var callBackFunc   = data.callback || "defaultCallBack";
        var callBackParams = data.params   || {};
        php.messages[callBackFunc](message, callBackParams);
    },
    addError:function(data) {
        var message        = data.msg      || "";
        var callBackFunc   = data.callback || "defaultCallBack";
        var callBackParams = data.params   || {};
        php.errors[callBackFunc](message, callBackParams);
    },
    addData:function(data) {
        var callBackFunc   = data.callback || "defaultCallBack";
        php.data[callBackFunc](data.k, data.v);
    },
    evalScript:function(data) {
        var func = data.foo || '';
        eval(func);
    },
    data : {
        defaultCallBack : function (key, value){
            alert("Server response: " + key + " = " + value);
        }
    },
    messages : {
        defaultCallBack : function (msg, params){
            alert("Server response message: " + msg);
        }
    },
    errors : {
        defaultCallBack : function (msg, params){
            alert("Server response error: " + msg);
        }
    }
};
})(jQuery);