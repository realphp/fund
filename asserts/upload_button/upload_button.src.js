/*
 Usage :
    $('#file-upload-button').UploadButton({
        value_holder   : '#??',
        preview_holder : '#??',
        width 	    : 256,
        height 	    : 256,
        postURL     : $.uri_build(),
        background  : 'http://www.xxx.xom/'+_osphp.root+'app/',
        acceptExt   : '.jpg,.png,.gif',
        showLoading : true,
        showAlert   : false,
        callback    : function(url){  }
    });
*/

var _T_UPLOAD_BUTTON_WAITING = {};
var _T_UPLOAD_BUTTON_CALLBACK = {};
(function ($) {
	$.fn.UploadButton = function (opt) {
		
		var 
		me = this,
		opt = $.extend({
            value_holder   : '',
            preview_holder : '',
			width 		: 	200,
			height 		: 	100,
			postURL     :   '/app/libs/upload_button/demo_upload.php',
			background  :   'http://images.cnblogs.com/cnblogs_com/dreamback/437546/o_ff6.png',
			acceptExt   :   '.pdf,.txt',
			showLoading :   false,
			showAlert   :   true,
            callback    :   null
		}, opt);	

		return this.each(function(){

			var obj = $(this),
			opts = opt,
			id = obj.attr('id');
			var upload_id = id;
            // remove all the - and other invalid variable chars
            upload_id = upload_id.replace(/-/g,'_');

            _T_UPLOAD_BUTTON_CALLBACK[upload_id]=opt.callback;

			if(!id){
				return;	
			}
			id = 'iframe-upload-button-' + id ;
			
			var uploadHtml = ['<iframe id="',
						   	id,
						   	'" scrolling="no" frameborder="0" style="width:',
							opts.width,'px;height:',opts.height,'px;"></iframe>'];		
			$(obj).html(uploadHtml.join(''));

            setTimeout(function(){

                var formHtml = ['<form enctype="multipart/form-data" action="',
                                opts.postURL,'" method="post" target="hideiframe">',
                                '<div style="width:',
                                opts.width,'px;height:',opts.height,'px;background:url(',
                                opts.background ,') no-repeat;position:relative;cursor:pointer;">',
                                '<input type="hidden" name="value_holder" value="',opts.value_holder,'" />',
                                '<input type="hidden" name="preview_holder" value="',opts.preview_holder,'" />',
                                '<input type="hidden" name="upload_id" value="',upload_id,'" />',
                                '<input type="hidden" name="show_alert" value="',(opt.showAlert?'1':'0'),'" />',
                                '<input type="file"   name="value_file" accept="',opts.acceptExt,'" style="width:',opts.width,'px;height:',
                                opts.height,'px;overflow:hidden;font-size: ',opts.height,
                                'px;position:absolute;right:0;top:0;cursor:pointer;opacity:0;filter:alpha(opacity=0);" />',
                                '</div>',
                                '</form>',
                                '<iframe name="hideiframe" scrolling="no" frameborder="0" style="width:1px;height:10px;"></iframe>'
                              ];

                obj = $("#"+id).get(0);
                if ( ! obj || ! obj.contentWindow ) {
                    return;
                }
                $(obj.contentWindow.document.head).html("<meta charset='utf-8'/>");
                var body = $(obj.contentWindow.document.body);
                body.css({
                    padding	: 0,
                    margin 	: 0
                });
                body.html(formHtml.join(''));
                var change_file_control_func = function(){
                    if(opt.showLoading){
                        $.dialog && (_T_UPLOAD_BUTTON_WAITING[upload_id] = $.dialog.tips(lhgdialog_lang.UPLOADING,60,'loading.gif'));
                    }
                    $(this).closest('form').submit();
                    $(this).replaceWith(['<input type="file"   name="value_file" accept="',
                                            opts.acceptExt,'" style="width:',
                                            opts.width,'px;height:',
                                            opts.height,'px;overflow:hidden;font-size: ',
                                            opts.height,'px;position:absolute;right:0;top:0;cursor:pointer;opacity:0;filter:alpha(opacity=0);" />'].join(''));
                    $('input[name=\'value_file\']',body).on('change',change_file_control_func);
                };
                $('input[name=\'value_file\']',body).on('change',change_file_control_func);

            },0);

		});
	};
}(jQuery));