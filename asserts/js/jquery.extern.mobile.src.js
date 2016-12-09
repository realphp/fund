/*------------------------------------------
 * jquery extern
 -------------------------------------------*/

Array.prototype.unique = function() {
    var a = {};
    var len = this.length;
    for ( var i = 0; i < len; i++) {
        if (typeof a[this[i]] == "undefined")
            a[this[i]] = 1;
    }
    this.length = 0;
    for ( var i in a)
        this[this.length] = i;
    return this;
};

$.extend({
    // include css files
    // $.includeCSS('system/css/jquery-ui');
    // $.includeCSS(['system/css/xxx','system/css/xxx']);
    includeCSSFiles:[],
    includeCSS: function(file,basePath){
        var files = typeof file == "string" ? [file] : file;
        basePath = basePath ? basePath : TPX.PATH_ASSERTS;
        for (var i = 0; i < files.length; i++){

            var name = files[i].replace(/^\s|\s$/g, "");
            var fileref=document.createElement("link");
            var link =  basePath + name + TPX.SUFFIX_CSS ;

            var flag=true;
            for(var j=0;j<$.includeCSSFiles.length;j++){
                if(link==$.includeCSSFiles[j]){
                    flag=false;
                }
            }
            if(flag){
                if ($("link[href='" + link + "']").length > 0 || $("link[href='" + link + "']").length > 0){
                    flag=false;
                }
            }

            if(flag){
                $.includeCSSFiles.push(link);
                fileref.setAttribute("rel", "stylesheet");
                fileref.setAttribute("type", "text/css") ;
                fileref.setAttribute("href", link );
                document.getElementsByTagName("head")[0].appendChild(fileref);
            }

        }
    },
    // include js files
    // $.includeJS('system/js/jquery-ui');
    // $.includeJS(['system/js/xxx','system/js/xxx']);
    includeJSFiles:[],
    includeJS:function(file,basePath){
        var files = typeof file == "string" ? [file] : file;
        basePath = basePath ? basePath : TPX.PATH_ASSERTS;
        for (var i = 0; i < files.length; i++){
            var name = files[i].replace(/^\s|\s$/g, "");
            var tag = "script";
            var attr = " language='javascript' type='text/javascript' ";
            var url= basePath + name + TPX.SUFFIX_JS;
            var link = "src='" + url + "'";

            var flag=true;
            for(var j=0;j<$.includeJSFiles.length;j++){
                if(link==$.includeJSFiles[j]){
                    flag=false;
                }
            }
            if(flag){
                if ($(tag + "[src='" + url + "']").length > 0 || $(tag + "[src='" + url + "']").length > 0){
                    flag=false;
                }
            }

            if(flag){
                $.includeJSFiles.push(link);
                $('body').append("<" + tag + attr + link + "></" + tag + ">");
            }
        }
    },
    getRootWindow:function(){
        var w=window;
        while(w.self!=w.parent){
            w=w.parent;
        }
        return w;
    },
    urlencode:function(str){
        var ret="";
        str+="";
        var strSpecial="!\"#$%&'()*+,/:;<=>?[]^`{|}~%";
        for(var i=0;i<str.length;i++){
            var chr = str.charAt(i);
            var c=str.charCodeAt(i).toString(16);
            if(chr==" ") {
                ret+="+";
            }else if(strSpecial.indexOf(chr)!=-1){
                ret+="%"+c.toString(16);
            }else{
                ret+=chr;
            }
        }
        return ret;
    },
    urldecode:function(zipStr){
        var uzipStr="";
        for(var i=0;i<zipStr.length;i++){
            var chr = zipStr.charAt(i);
            if(chr == "+"){
                uzipStr+=" ";
            }else if(chr=="%"){
                var asc = zipStr.substring(i+1,i+3);
                if(parseInt("0x"+asc)>0x7f){
                    uzipStr+=decodeURI("%"+asc.toString()+zipStr.substring(i+3,i+9).toString());
                    i+=8;
                }else{
                    uzipStr+=ShengUtils.AsciiToString(parseInt("0x"+asc));
                    i+=2;
                }
            }else{
                uzipStr+= chr;
            }
        }
        return uzipStr;
    },
    getUrlAnchor: function(){
        var url = window.location.href;
        var pos = url.indexOf('#');
        if(pos>0){
            url = url.substring(pos+1);
            return url;
        }
        return '';
    },
    redirect:function(url){
        window.location.href=url;
    },
    defaultFormCallback:function(data, custom_callback){
        // $this->success('messages')   => {"info":"messages","status":1,"url":""}
        // $this->error('messages')     => {"info":"messages","status":0,"url":""}
        // $this->redirect('url')       => forbidden
        if(data){

            if('number' == (typeof data.status)){

                if( 0 == data.status ){
                    // error
                    alert(data.info);
                    if(data.url){
                        if('[reload]'==data.url){
                            window.location.reload();
                        }else{
                            $.redirect(data.url);
                        }
                    }
                    if($('#auto-click-on-error').length){
                        $('#auto-click-on-error').click();
                    }

                }else if( 1 == data.status){
                    // success
                    if ( data.info ){
                        alert(data.info);
                    }
                    if(data.url){
                        if('[reload]'==data.url){
                            window.location.reload();
                        }else{
                            $.redirect(data.url);
                        }
                    }
                }
            }else{
                if(custom_callback){
                    custom_callback(data);
                }else{
                    alert("ERROR: Unrecognized data! \n==\n"+data+"\n==");
                }
            }
        }else{
            alert('ERROR: Response Data Empty!');
        }
    }
});

// form : class [ tpx-ajaxsubmit ]

$(function(){
    if($('form.tpx-ajaxsubmit').length>0){

        $('form.tpx-ajaxsubmit').submit(function(){

            var me = this;
            var data=$(this).serializeArray();
            var callback=null;
            if($(this).attr('callback')){
                callback=eval($(this).attr('callback'));
            }else{
                callback= $.defaultFormCallback;
            }

            $(me).find('[type=submit]').prop('disabled',true);

            if( $('#submit-loading-box').length == 0 ) {
                var content = [
                    '<div id="submit-loading-box" class="modal" tabindex="-1" role="dialog" aria-hidden="true">',
                        '<div class="modal-dialog modal-sm" style="width:200px;margin:0 auto;margin-top:', ($(window).height()/2-100) ,'px;">',
                            '<div class="modal-content text-center" style="padding:10px 0;">',
                                '<img src="'+TPX.PATH_ASSERTS+'/image/loading.gif" /><br />正在加载...',
                            '</div>',
                        '</div>',
                    '</div>'].join('');
                $('body').append(content);
            }
            $('#submit-loading-box').modal('show');

            var time=setTimeout(function(){ $('#submit-loading-box').modal('hide'); },30000);
            var callback_wrap = function(data){

                $('#submit-loading-box').modal('hide');

                callback(data);
                clearTimeout(time);
                $(me).find('[type=submit]').prop('disabled',false);
            };
            if($(this).attr("method")=="post"){
                $.post($(this).attr("action"),data,callback_wrap);
            }else{
                $.get($(this).attr("action"),data,callback_wrap);
            }
            return false;
        });

    }
});