(function(){var e=editor,k=$G("preview"),f=$G("preitem"),h=templates,g,d=function(b){var c=h[b-1];g=c;for(var a=f.children,e=0,d;d=a[e++];)domUtils.setStyles(d,{"background-color":"",border:"white 1px solid"});domUtils.setStyles(f.childNodes[b-1],{"background-color":"lemonChiffon",border:"#ccc 1px solid"});k.innerHTML=c.preHtml?c.preHtml:""};dialog.onok=function(){$G("issave").checked||e.execCommand("cleardoc");e.execCommand("template",{html:g&&g.html})};(function(){for(var b="",c=0,a;a=h[c++];)b+=
'<div class="preitem" onclick="pre('+c+')"><img src="images/'+a.pre+'" '+(a.title?"alt="+a.title+" title="+a.title+"":"")+"></div>";f.innerHTML=b})();window.pre=d;d(2)})();