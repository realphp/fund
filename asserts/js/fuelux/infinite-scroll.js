(function(a){"function"===typeof define&&define.amd?define(["jquery","fuelux/loader"],a):a(jQuery)})(function(a){var h=a.fn.infinitescroll,f=function(d,b){this.$element=a(d);this.$element.addClass("infinitescroll");this.options=a.extend({},a.fn.infinitescroll.defaults,b);this.curScrollTop=this.$element.scrollTop();this.curPercentage=this.getPercentage();this.fetchingData=!1;this.$element.on("scroll.fu.infinitescroll",a.proxy(this.onScroll,this));this.onScroll()};f.prototype={constructor:f,destroy:function(){this.$element.remove();
this.$element.empty();return this.$element[0].outerHTML},disable:function(){this.$element.off("scroll.fu.infinitescroll")},enable:function(){this.$element.on("scroll.fu.infinitescroll",a.proxy(this.onScroll,this))},end:function(d){var b=a('<div class="infinitescroll-end"></div>');d?b.append(d):b.append("---------");this.$element.append(b);this.disable()},getPercentage:function(){var a="border-box"===this.$element.css("box-sizing")?this.$element.outerHeight():this.$element.height(),b=this.$element.get(0).scrollHeight;
return b>a?a/(b-this.curScrollTop)*100:0},fetchData:function(d){var b=a('<div class="infinitescroll-load"></div>'),e=this,c,k=function(){var d={percentage:e.curPercentage,scrollTop:e.curScrollTop},c=a('<div class="loader"></div>');b.append(c);c.loader();e.options.dataSource&&e.options.dataSource(d,function(a){b.remove();a.content&&e.$element.append(a.content);a.end&&(a=!0!==a.end?a.end:void 0,e.end(a));e.fetchingData=!1})};this.fetchingData=!0;this.$element.append(b);this.options.hybrid&&!0!==d?(c=
a('<button type="button" class="btn btn-primary"></button>'),"object"===typeof this.options.hybrid?c.append(this.options.hybrid.label):c.append('<span class="glyphicon glyphicon-repeat"></span>'),c.on("click.fu.infinitescroll",function(){c.remove();k()}),b.append(c)):k()},onScroll:function(a){this.curScrollTop=this.$element.scrollTop();this.curPercentage=this.getPercentage();!this.fetchingData&&this.curPercentage>=this.options.percentage&&this.fetchData()}};a.fn.infinitescroll=function(d){var b=Array.prototype.slice.call(arguments,
1),e,c=this.each(function(){var c=a(this),g=c.data("fu.infinitescroll"),h="object"===typeof d&&d;g||c.data("fu.infinitescroll",g=new f(this,h));"string"===typeof d&&(e=g[d].apply(g,b))});return void 0===e?c:e};a.fn.infinitescroll.defaults={dataSource:null,hybrid:!1,percentage:95};a.fn.infinitescroll.Constructor=f;a.fn.infinitescroll.noConflict=function(){a.fn.infinitescroll=h;return this}});