require(["jquery","bootstrap","jquery.extern","lhgdialog.lang","lhgdialog.base"],function(){$(function(){$("#frame-menu .m-1").on("click",function(){$(this).next().is(":visible")||($("#frame-menu .m-1").next().slideUp(),$(this).next().slideDown());return!1});$("#frame-menu .m-2").on("click",function(){$(this).next().slideDown();return!1});if($("#btn-module-cms-list").length){var a=function(a,e){var c=$.dialog.tips(lhgdialog_lang.LOADING,10,"loading.gif"),b=$(e).text();$.get("?s="+TPX.PATH_ROOT+"/helper/module_enable",
{module:b,enable:a},function(a){c.close();$("#btn-module-cms-list").click()})},e=function(a,e){var c=$.dialog.tips(lhgdialog_lang.LOADING,10,"loading.gif"),b=$(e).text();$.get("?s="+TPX.PATH_ROOT+"/helper/cms_enable",{cms:b,enable:a},function(a){c.close();$("#btn-module-cms-list").click()})},k=function(a,e){var c=$.dialog.tips(lhgdialog_lang.LOADING,10,"loading.gif"),b=$(e).text();$.get("?s="+TPX.PATH_ROOT+"/helper/extend_enable",{extend:b,enable:a},function(a){c.close();$("#btn-module-cms-list").click()})},
l=function(a,e){var c=$.dialog.tips(lhgdialog_lang.LOADING,10,"loading.gif");$.get("?s="+TPX.PATH_ROOT+"/helper/framework_enable",{enable:a},function(a){c.close();$("#btn-module-cms-list").click()})};$("#btn-module-cms-list").on("click",function(){var d=$(this).attr("data-url"),h=$.dialog.tips(lhgdialog_lang.LOADING,10,"loading.gif");$.post(d,{},function(c){h.close();if(!c.error){var b=$("#box-module-list");b.html("");for(var f=0;f<c.modules.length;f++){var g="btn-default";c.modules[f].enable&&(g=
"btn-primary");b.append('<a href="#" class="btn btn-xs '+g+'">'+c.modules[f].name+"</a>")}b.children(".btn-default").on("click",function(){a(1,this);return!1});b.children(".btn-primary").on("click",function(){a(0,this);return!1});b=$("#box-cms-list");b.html("");for(f=0;f<c.cmses.length;f++)g="btn-default",c.cmses[f].enable&&(g="btn-primary"),b.append('<a href="#" class="btn btn-xs '+g+'">'+c.cmses[f].name+"</a>");b.children(".btn-default").on("click",function(){e(1,this);return!1});b.children(".btn-primary").on("click",
function(){e(0,this);return!1});b=$("#box-extends-list");b.html("");for(f=0;f<c["extends"].length;f++)g="btn-default",c["extends"][f].enable&&(g="btn-primary"),b.append('<a href="#" class="btn btn-xs '+g+'">'+c["extends"][f].name+"</a>");b.children(".btn-default").on("click",function(){k(1,this);return!1});b.children(".btn-primary").on("click",function(){k(0,this);return!1});b=$("#box-framework");b.html("");g="btn-default";c.framework&&(g="btn-primary");b.append('<a href="#" class="btn btn-xs '+g+
'">Framework</a>');b.children(".btn-default").on("click",function(){l(1,this);return!1});b.children(".btn-primary").on("click",function(){l(0,this);return!1})}});return!1});$("#btn-module-cms-list").click()}});var h=function(){$("#frame-content").height()>=$(window).height()?$("#frame-menu").css({height:$(window).height()-55+"px"}):$("#frame-menu").css({height:$(window).height()-91+"px"});$("#frame-content").css({minHeight:$(window).height()-91+"px"})};$(window).on("resize",h);h();$(document).on("click",
".command-dialog-page",function(){var a=$(this).attr("data-href");$.dialog({content:"url:"+a,height:$(window).height()-50,width:800});return!1});$(document).on("click",".command-ajax-request",function(){var a=$(this).attr("data-href"),e=$(this).attr("data-data"),d=$.dialog.tips(lhgdialog_lang.LOADING,10,"loading.gif");$.post(a,e,function(a){d.close();$.defaultFormCallback(a)});return!1});$(document).on("mouseover",'[data-toggle="tooltip"]',function(){$(this).tooltip("show")});var d=function(){var a=
null,e=function(d){$.post("?s=/system/upgrade/action/"+d,{},function(d){1==d.status?"ok"==d.info?(a&&a.close(),$.dialog.alert("\u5347\u7ea7\u5b8c\u6210",function(){$.redirect("?s=/login/out")})):(a.content(d.info),setTimeout(function(){e("running")},10)):(a&&a.close(),$.dialog.alert(d.info))})},a=$.dialog.tips("\u6b63\u5728\u521d\u59cb\u5316",1E7,"loading.gif");e("init")};$(document).on("click",".command-upgrade",function(){window.confirm("\u5347\u7ea7\u53ef\u80fd\u4f1a\u8986\u76d6\u60a8\u4fee\u6539\u7684\u6a21\u677f\u4ee3\u7801\uff0c\u786e\u8ba4\uff1f")&&
d();return!1})});function admin_grid_delete(h){var d=[];grid.find("input[name=select]:checked").each(function(a,e){var h=parseInt($(e).val());h&&d.push(h)});d.length&&$.post(h,{ids:d.join(",")},function(a){a.status&&a.info&&"OK"==a.info&&1==a.status?grid.bootgrid("reload"):$.defaultFormCallback(a)});return!1}function admin_grid_delete_one(h,d){$.post(h,{ids:d},function(a){a.status&&a.info&&"OK"==a.info&&1==a.status?grid.bootgrid("reload"):$.defaultFormCallback(a)});return!1};