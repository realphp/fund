define(["jquery.base64"],function(){var f=function(d,e){var c=document.getElementsByTagName("head")[0],a=document.createElement("script");a.type="text/javascript";a.src=d;a.onload=a.onreadystatechange=function(){this.readyState&&"loaded"!==this.readyState&&"complete"!==this.readyState||(e&&e(),a.onload=a.onreadystatechange=null,c&&a.parentNode&&c.removeChild(a))};c.insertBefore(a,c.firstChild)};window.BMap=window.BMap||{};BMap.Convertor={};BMap.Convertor.translate=function(d,e,c){var a="cbk_"+Math.round(1E4*
Math.random());f("http://api.map.baidu.com/ag/coord/convert?from="+e+"&to=4&x="+d.lng+"&y="+d.lat+"&callback=BMap.Convertor."+a);BMap.Convertor[a]=function(b){delete BMap.Convertor[a];b.x=$.base64.decode(b.x);b.y=$.base64.decode(b.y);b=new BMap.Point(b.x,b.y);c&&c(b)}}});