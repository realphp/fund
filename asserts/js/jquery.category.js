(function(e,g,m,n){e(g);e.fn.category=function(g){var a={selectClass:"",inputNames:"",inputGlobalName:"",ajaxUrl:"",data:null,pleaseSelectText:"[Please select]",initValue:0,onSelect:null},h=e(this);e.extend(a,g);if(a.ajaxUrl){var l=function(c,d){var f=a.inputNames.split(" "),b="",b=f.length>d?f[d]:a.inputGlobalName;if(0<c.length){f=e('<select data-level="'+d+'" name="'+b+'" id="'+b+'" class="'+a.selectClass+'"></select>');f.append('<option value="-1">'+a.pleaseSelectText+"</option>");for(b=0;b<c.length;b++)f.append('<option value="'+
c[b].value+'"'+(c[b].selected?' selected="selected"':"")+">"+c[b].title+"</option>");h.append(f);f.on("change",function(){if(a.onSelect)a.onSelect(e(this).val());k(e(this).val(),d+1)})}},k=function(c,d){var f=[];h.children("select").each(function(a,b){parseInt(e(b).attr("data-level"))>=d&&f.push(b)});var b=a.data;b||(b={});b.pid=c;e.post(a.ajaxUrl,b,function(a){for(var b=0;b<f.length;b++)e(f[b]).remove();a.status?l(a.list,d):alert("error ajax data")})};a.initValue=parseInt(a.initValue);0<a.initValue?
(a.data.init_value=a.initValue,a.data.pid=0,e.post(a.ajaxUrl,a.data,function(c){delete a.data.init_value;if(c.status&&c.list)for(var d=0;d<c.list.length;d++)l(c.list[d],d+1);else alert("error ajax data")})):k(0,0);return this}alert("empty options : ajaxUrl")}})(jQuery,window,document);