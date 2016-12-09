(function(b){"function"===typeof define&&define.amd?define(["jquery"],b):b(jQuery)})(function(b){var h=b.fn.spinbox,f=function(a,c){this.$element=b(a);this.$element.find(".btn").on("click",function(a){a.preventDefault()});this.options=b.extend({},b.fn.spinbox.defaults,c);this.$input=this.$element.find(".spinbox-input");this.$element.on("focusin.fu.spinbox",this.$input,b.proxy(this.changeFlag,this));this.$element.on("focusout.fu.spinbox",this.$input,b.proxy(this.change,this));this.$element.on("keydown.fu.spinbox",
this.$input,b.proxy(this.keydown,this));this.$element.on("keyup.fu.spinbox",this.$input,b.proxy(this.keyup,this));this.bindMousewheelListeners();this.mousewheelTimeout={};this.options.hold?(this.$element.on("mousedown.fu.spinbox",".spinbox-up",b.proxy(function(){this.startSpin(!0)},this)),this.$element.on("mouseup.fu.spinbox",".spinbox-up, .spinbox-down",b.proxy(this.stopSpin,this)),this.$element.on("mouseout.fu.spinbox",".spinbox-up, .spinbox-down",b.proxy(this.stopSpin,this)),this.$element.on("mousedown.fu.spinbox",
".spinbox-down",b.proxy(function(){this.startSpin(!1)},this))):(this.$element.on("click.fu.spinbox",".spinbox-up",b.proxy(function(){this.step(!0)},this)),this.$element.on("click.fu.spinbox",".spinbox-down",b.proxy(function(){this.step(!1)},this)));this.switches={count:1,enabled:!0};this.switches.speed="medium"===this.options.speed?300:"fast"===this.options.speed?100:500;this.lastValue=this.options.value;this.render();this.options.disabled&&this.disable()};f.prototype={constructor:f,destroy:function(){this.$element.remove();
this.$element.find("input").each(function(){b(this).attr("value",b(this).val())});return this.$element[0].outerHTML},render:function(){var a=this.parseInput(this.$input.val()),c="";""!==a&&0===this.options.value?this.value(a):this.output(this.options.value);this.options.units.length&&b.each(this.options.units,function(a,b){b.length>c.length&&(c=b)})},output:function(a,b){a=(a+"").split(".").join(this.options.decimalMark);this.$input.val(a);return a},parseInput:function(a){return a=(a+"").split(this.options.decimalMark).join(".")},
change:function(){var a=this.parseInput(this.$input.val())||"";this.options.units.length||"."!==this.options.decimalMark?a=this.parseValueWithUnit(a):a/1?a=this.options.value=this.checkMaxMin(a/1):(a=this.checkMaxMin(a.replace(/[^0-9.-]/g,"")||""),this.options.value=a/1);this.output(a);this.changeFlag=!1;this.triggerChangedEvent()},changeFlag:function(){this.changeFlag=!0},stopSpin:function(){void 0!==this.switches.timeout&&(clearTimeout(this.switches.timeout),this.switches.count=1,this.triggerChangedEvent())},
triggerChangedEvent:function(){var a=this.value();a!==this.lastValue&&(this.lastValue=a,this.$element.trigger("changed.fu.spinbox",this.output(a,!1)))},startSpin:function(a){if(!this.options.disabled){var c=this.switches.count;1===c?(this.step(a),c=1):c=3>c?1.5:8>c?2.5:4;this.switches.timeout=setTimeout(b.proxy(function(){this.iterate(a)},this),this.switches.speed/c);this.switches.count++}},iterate:function(a){this.step(a);this.startSpin(a)},step:function(a){var b,d,e;this.changeFlag&&this.change();
d=this.options.value;e=a?this.options.max:this.options.min;(a?d<e:d>e)?(d+=(a?1:-1)*this.options.step,0!==this.options.step%1&&(b=(this.options.step+"").split(".")[1].length,b=Math.pow(10,b),d=Math.round(d*b)/b),(a?d>e:d<e)?this.value(e):this.value(d)):this.options.cycle&&this.value(a?this.options.min:this.options.max)},value:function(a){if(a||0===a){if(this.options.units.length||"."!==this.options.decimalMark)return this.output(this.parseValueWithUnit(a+(this.unit||""))),this;if(!isNaN(parseFloat(a))&&
isFinite(a))return this.options.value=a/1,this.output(a+(this.unit?this.unit:"")),this}else return this.changeFlag&&this.change(),this.unit?this.options.value+this.unit:this.output(this.options.value,!1)},isUnitLegal:function(a){var c;b.each(this.options.units,function(b,e){if(e.toLowerCase()===a.toLowerCase())return c=a.toLowerCase(),!1});return c},parseValueWithUnit:function(a){var b=a.replace(/[^a-zA-Z]/g,"");a=a.replace(/[^0-9.-]/g,"");b&&(b=this.isUnitLegal(b));this.options.value=this.checkMaxMin(a/
1);this.unit=b||void 0;return this.options.value+(b||"")},checkMaxMin:function(a){if(isNaN(parseFloat(a)))return a;a<=this.options.max&&a>=this.options.min||(a=a>=this.options.max?this.options.max:this.options.min);return a},disable:function(){this.options.disabled=!0;this.$element.addClass("disabled");this.$input.attr("disabled","");this.$element.find("button").addClass("disabled")},enable:function(){this.options.disabled=!1;this.$element.removeClass("disabled");this.$input.removeAttr("disabled");
this.$element.find("button").removeClass("disabled")},keydown:function(a){a=a.keyCode;38===a?this.step(!0):40===a&&this.step(!1)},keyup:function(a){a=a.keyCode;38!==a&&40!==a||this.triggerChangedEvent()},bindMousewheelListeners:function(){var a=this.$input.get(0);a.addEventListener?(a.addEventListener("mousewheel",b.proxy(this.mousewheelHandler,this),!1),a.addEventListener("DOMMouseScroll",b.proxy(this.mousewheelHandler,this),!1)):a.attachEvent("onmousewheel",b.proxy(this.mousewheelHandler,this))},
mousewheelHandler:function(a){if(!this.options.disabled){a=window.event||a;var b=Math.max(-1,Math.min(1,a.wheelDelta||-a.detail)),d=this;clearTimeout(this.mousewheelTimeout);this.mousewheelTimeout=setTimeout(function(){d.triggerChangedEvent()},300);0>b?this.step(!0):this.step(!1);a.preventDefault?a.preventDefault():a.returnValue=!1;return!1}}};b.fn.spinbox=function(a){var c=Array.prototype.slice.call(arguments,1),d,e=this.each(function(){var e=b(this),g=e.data("fu.spinbox"),h="object"===typeof a&&
a;g||e.data("fu.spinbox",g=new f(this,h));"string"===typeof a&&(d=g[a].apply(g,c))});return void 0===d?e:d};b.fn.spinbox.defaults={value:0,min:0,max:999,step:1,hold:!0,speed:"medium",disabled:!1,cycle:!1,units:[],decimalMark:"."};b.fn.spinbox.Constructor=f;b.fn.spinbox.noConflict=function(){b.fn.spinbox=h;return this};b(document).on("mousedown.fu.spinbox.data-api","[data-initialize=spinbox]",function(a){a=b(a.target).closest(".spinbox");a.data("fu.spinbox")||a.spinbox(a.data())});b(function(){b("[data-initialize=spinbox]").each(function(){var a=
b(this);a.data("fu.spinbox")||a.spinbox(a.data())})})});