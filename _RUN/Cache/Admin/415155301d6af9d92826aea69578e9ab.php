<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <script>(function(w){w.onerror=function(n,o,r){var i=encodeURIComponent;(new Image).src="/?s=watcher/js&error="+i(n)+"&file="+i(o)+"&line="+i(r)+"&url="+i(w.location.href)+'&agent='+i(navigator.userAgent)}})(window);</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo W('Frame/title');?> <?php echo (L("administrator")); ?></title>
    <link rel="stylesheet" type="text/css" href="/asserts/bootstrap/css/bootstrap.yeti.min.css?<?php echo (STATIC_RES_HASH); ?>" />
    <link rel="stylesheet" type="text/css" href="/asserts/admin/style.css?<?php echo (STATIC_RES_HASH); ?>" />
    <link rel="stylesheet" type="text/css" href="/asserts/css/jquery.bootgrid.min.css?<?php echo (STATIC_RES_HASH); ?>" />
    <link rel="stylesheet" type="text/css" href="/asserts/jquery-ui-1.11.2/jquery-ui.css?<?php echo (STATIC_RES_HASH); ?>" />
    <link rel="stylesheet" href="/asserts/bootstrap/css/font-awesome.css?<?php echo (STATIC_RES_HASH); ?>">
    <script src="/asserts/js/jquery-1.11.3.src.js?<?php echo (STATIC_RES_HASH); ?>"></script>
    <!--[if lt IE 9]>
        <script src="/asserts/bootstrap/js/html5shiv.min.js?<?php echo (STATIC_RES_HASH); ?>"></script>
        <script src="/asserts/bootstrap/js/respond.min.js?<?php echo (STATIC_RES_HASH); ?>"></script>
    <![endif]-->
    <script type="text/javascript">
        var TPX={
            PATH_ROOT : '',
            PATH_ASSERTS:'/asserts',
            SUFFIX_JS:'.src.js?<?php echo (STATIC_RES_HASH); ?>',
            SUFFIX_CSS:'.css?<?php echo (STATIC_RES_HASH); ?>',
            LANG:'<?php echo LANG_SET; ?>',
            UEDITOR:[]
        };
        var require = {
            baseUrl : '/asserts/js'
        };
    </script>
    <script src="/asserts/js/require.src.js?<?php echo (STATIC_RES_HASH); ?>"></script>
</head>

<body class="tpx-use-dialog fuelux">

<!--[if lt IE 8 ]>
    <script>alert('后台不支持IE8以下的浏览器');</script>
<![endif]-->


<?php if(!defined('ADMIN_EMPTY_FRAME')){ ?>

<nav class="header navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#frame-main-menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo U('System/info');?>"><span class="glyphicon glyphicon-th-large"></span> <?php echo (L("administrator")); ?></a>
        </div>
        <div class="collapse navbar-collapse" id="frame-main-menu">
            <div id="page-main-nav">
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/" target="_blank"><?php echo (L("front_home")); ?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo (L("welcome_login")); ?> <?php echo (session('admin_username')); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo U('System/profile');?>"><?php echo (L("profile")); ?></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo U('Login/out');?>"><?php echo (L("logout")); ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="frame-menu">
    <div class="top-btns">
        <a href="<?php echo U('System/info');?>" title="<?php echo (L("admin_home")); ?>" data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-home"></span></a>
        <a href="<?php echo U('System/profile');?>" title="<?php echo (L("profile")); ?>" data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-user"></span></a>
        <a href="<?php echo U('System/info');?>" title="<?php echo (L("admin_home")); ?>" data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-cog"></span></a>
        <a href="<?php echo U('Login/out');?>" title="<?php echo (L("logout")); ?>" data-toggle="tooltip" data-placement="bottom"><span class="icon-off"></span></a>
    </div>
    <?php echo W('Frame/menu');?>
</div>

<div id="frame-content">
    
        <div id="page-title-bar">
            <span class="title">
                <span class="glyphicon glyphicon-stop"></span>
                <?php echo W('Frame/title');?>
            </span>
            
            
        </div>
        <div id="page-content">
            

<?php if(!empty($id)): ?><form class="form-horizontal tpx-ajaxsubmit" role="form" action="<?php echo U(CONTROLLER_NAME.'/cmshandle?action=edit&id='.$id.'&page='.$page);?>" method="post">
<?php else: ?>
    <form class="form-horizontal tpx-ajaxsubmit" role="form" action="<?php echo U(CONTROLLER_NAME.'/cmshandle?action=add&page='.$page);?>" method="post"><?php endif; ?>

    <?php if(is_array($fields)): foreach($fields as $k=>$f): switch($f["type"]): case "baidu_map": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>_lng"
                               type="text"
                               class="form-control form-inline"
                               value="<?php echo (htmlspecialchars($f["value"]["lng"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                        />
                        <input name="<?php echo ($k); ?>_lat"
                               type="text"
                               class="form-control form-inline"
                               value="<?php echo (htmlspecialchars($f["value"]["lat"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                        />
                        <input name="<?php echo ($k); ?>_keywords" type="text" class="form-control" placeholder="输入地址直接定位" value="" />
                        <div id="<?php echo ($k); ?>-warp" style="width:100%;height:400px;border:1px solid #CCC;"></div>
                        <script type="text/javascript">
                            function baidu_map_init_<?php echo ($k); ?>() {

                                var setPoint = function(pt){
                                    $('input[name=<?php echo ($k); ?>_lng]').val(pt.lng);
                                    $('input[name=<?php echo ($k); ?>_lat]').val(pt.lat);
                                };

                                var getPoint = function(){
                                    return new BMap.Point($('input[name=<?php echo ($k); ?>_lng]').val(),$('input[name=<?php echo ($k); ?>_lat]').val());
                                };

                                var map = new BMap.Map("<?php echo ($k); ?>-warp");
                                map.centerAndZoom(getPoint(),15);
                                map.enableScrollWheelZoom();

                                var marker = new BMap.Marker(map.getCenter());
                                marker.enableDragging();
                                marker.addEventListener('dragend',function(e){
                                    setPoint(e.point);
                                });
                                map.addOverlay(marker);
                                map.addEventListener('click',function(e){
                                    setPoint(e.point);
                                    marker.setPosition(e.point);
                                });

                                var search = function(){
                                    map.centerAndZoom($('input[name=<?php echo ($k); ?>_keywords]').val(),15);
                                    marker.setPosition(map.getCenter());
                                    setPoint(map.getCenter());
                                };
                                var searchTimeout = null;
                                $('input[name=<?php echo ($k); ?>_keywords]').on('keyup',function(){
                                    if(searchTimeout){
                                        clearTimeout(searchTimeout);
                                        searchTimeout = null;
                                    }
                                    searchTimeout = setTimeout(search, 100);
                                });
                            }
                            require(['jquery.extern'], function () {
                                $.includeJS("api?v=2.0&ak=<?php echo ($f["key"]); ?>&callback=baidu_map_init_<?php echo ($k); ?>&",'http://api.map.baidu.com/');
                            });
                        </script>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "china_district": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>" type="hidden" value="<?php echo (htmlspecialchars($f["value"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <span id="<?php echo ($k); ?>-warp"></span>
                        <script type="text/javascript">
                            require(['jquery.category'], function () {
                                $('#<?php echo ($k); ?>-warp').category({
                                    selectClass: 'form-control input-sm form-inline',
                                    inputNames: '',
                                    inputGlobalName: '',
                                    ajaxUrl: "<?php echo U('System/china_district');?>",
                                    pleaseSelectText: '[请选择]',
                                    initValue: '<?php echo (htmlspecialchars($f["value"])); ?>',
                                    data: {select_level:'<?php echo ($f["select_level"]); ?>'},
                                    onSelect: function (id) {
                                        $('input[name=<?php echo ($k); ?>]').val(id);
                                    }
                                });
                            });
                        </script>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "cms_id": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                               type="text"
                               class="form-control input-inline"
                               placeholder=""
                               value="<?php echo (htmlspecialchars($f["value"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "member_uid": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                               type="text"
                               class="form-control input-inline"
                               placeholder=""
                               value="<?php echo (htmlspecialchars($f["value"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "tag": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <div class="pillbox" id="<?php echo ($k); ?>">
                            <ul class="clearfix pill-group">
                                <?php if(is_array($f['value'])): $i = 0; $__LIST__ = $f['value'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="btn btn-default pill" data-value="<?php echo ($v); ?>">
                                        <span><?php echo ($v); ?></span>
                                        <span class="glyphicon glyphicon-close">
                                            <span class="sr-only">Remove</span>
                                        </span>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                <li class="pillbox-input-wrap btn-group">
                                    <input type="text" class="form-control dropdown-toggle pillbox-add-item" placeholder="点击如下可用标签或输入" />
                                </li>
                            </ul>
                        </div>
                        <script>
                            require(['jquery.extern','fuelux/pillbox'],function(){
                                $.includeCSS('css/fuelux');
                                $('#<?php echo ($k); ?>').pillbox();
                                $('#<?php echo ($k); ?>-list .btn').on('click',function(){
                                    $('#<?php echo ($k); ?>').pillbox('addItems', -1, [{ text: $(this).text(), value:$(this).text(), attr: {}, data: {} }]);
                                    return false;
                                });
                            });
                        </script>
                        <div style="padding:10px 0;" id="<?php echo ($k); ?>-list">
                            <?php if(is_array($f['option'])): $i = 0; $__LIST__ = $f['option'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><button class="btn btn-default btn-sm"><?php echo ($v); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                        <input type="hidden" name="<?php echo ($k); ?>" value="" />
                    </div>
                </div><?php break;?>

            <?php case "text": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                                type="text"
                                class="form-control"
                                placeholder=""
                                value="<?php echo (htmlspecialchars($f["value"])); ?>"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "number": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                                type="text"
                                class="form-control"
                                placeholder=""
                                value="<?php echo (htmlspecialchars($f["value"])); ?>"
                                style="width:auto;"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "datetime": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                                type="text"
                                class="form-control"
                                placeholder=""
                                value="<?php echo (date('Y-m-d H:i:s',$f["value"])); ?>"
                                style="width:auto;"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                        <script type="text/javascript">
                            require(["jquery.extern"],function(){
                                $.includeCSS("jquery-ui-1.11.2/jquery-ui-timepicker-addon");
                            });
                            require(["jquery.ui.timepicker"],function(){
                                $( "input[name=<?php echo ($k); ?>]" ).datetimepicker({
                                    dateFormat:"yy-mm-dd",
                                    timeFormat:'HH:mm:ss'
                                });
                            });
                        </script>
                    </div>
                </div><?php break;?>

            <?php case "date": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                                type="text"
                                class="form-control"
                                placeholder=""
                                value="<?php echo (date('Y-m-d',$f["value"])); ?>"
                                style="width:auto;"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                        <script type="text/javascript">
                            require(["jquery.extern"],function(){
                                $.includeCSS("jquery-ui-1.11.2/jquery-ui-timepicker-addon");
                            });
                            require(["jquery.ui.timepicker"],function(){
                                $( "input[name=<?php echo ($k); ?>]" ).datepicker({
                                    dateFormat:"yy-mm-dd",
                                    timeFormat:''
                                });
                            });
                        </script>
                    </div>
                </div><?php break;?>

            <?php case "switch": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="<?php echo ($k); ?>" value="1"<?php if($f["value"] == 1): ?>checked="checked"<?php endif; ?>> <?php echo (L("switch_on")); ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="<?php echo ($k); ?>" value="0"<?php if($f["value"] == 0): ?>checked="checked"<?php endif; ?>> <?php echo (L("switch_off")); ?>
                        </label>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "bigtext": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <textarea name="<?php echo ($k); ?>"
                                    class="form-control"
                                    placeholder=""
                                    style="min-height:6em;"
                                    <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                    <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                                    ><?php echo (htmlspecialchars($f["value"])); ?></textarea>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "selectnumber": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <select name="<?php echo ($k); ?>"
                                    class="form-control"
                                    style="width:auto;"
                                    <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                    <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                                >
                            <?php if(is_array($f["option"])): foreach($f["option"] as $kk=>$vv): if($kk == $f['value']): ?><option value="<?php echo (htmlspecialchars($kk)); ?>" selected="selected"><?php echo ($vv); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo (htmlspecialchars($kk)); ?>"><?php echo ($vv); ?></option><?php endif; endforeach; endif; ?>
                        </select>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "selecttext": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <select name="<?php echo ($k); ?>"
                                class="form-control"
                                style="width:auto;"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                                >
                            <?php if(is_array($f["option"])): foreach($f["option"] as $kk=>$vv): if($kk == $f['value']): ?><option value="<?php echo (htmlspecialchars($kk)); ?>" selected="selected"><?php echo ($vv); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo (htmlspecialchars($kk)); ?>"><?php echo ($vv); ?></option><?php endif; endforeach; endif; ?>
                        </select>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "checkbox": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <?php if(in_array('inline',$f['rules'])): if(is_array($f["option"])): foreach($f["option"] as $kk=>$vv): ?><div class="checkbox" style="display:inline-block;padding-right:2em;">
                                    <label>
                                        <?php if(in_array($kk,$f['value'])): ?><input name="<?php echo ($k); ?>[]" type="checkbox" checked="checked" value="<?php echo (htmlspecialchars($kk)); ?>"> <?php echo ($vv); ?>
                                        <?php else: ?>
                                            <input name="<?php echo ($k); ?>[]" type="checkbox" value="<?php echo (htmlspecialchars($kk)); ?>"> <?php echo ($vv); endif; ?>
                                    </label>
                                </div><?php endforeach; endif; ?>
                        <?php else: ?>
                            <?php if(is_array($f["option"])): foreach($f["option"] as $kk=>$vv): ?><div class="checkbox">
                                    <label>
                                        <?php if(in_array($kk,$f['value'])): ?><input name="<?php echo ($k); ?>[]" type="checkbox" checked="checked" value="<?php echo (htmlspecialchars($kk)); ?>"> <?php echo ($vv); ?>
                                        <?php else: ?>
                                            <input name="<?php echo ($k); ?>[]" type="checkbox" value="<?php echo (htmlspecialchars($kk)); ?>"> <?php echo ($vv); endif; ?>
                                    </label>
                                </div><?php endforeach; endif; endif; ?>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "richtext": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <script id="<?php echo ($k); ?>" name="<?php echo ($k); ?>" type="text/plain">
                            <?php echo ($f["value"]); ?>
                        </script>
                        <script type="text/javascript">
                            require(["ueditor"],function(){
                                var ue = UE.getEditor('<?php echo ($k); ?>') ;
                                if(TPX.UEDITOR){
                                    TPX.UEDITOR.push(ue);
                                }
                            });
                        </script>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "imagefile": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">

                        <?php $imagefile_id = 'imagefile_'.mt_rand(100000,999999); ?>
                        <table border="0" style="table-layout:fixed">
                            <tr>
                                <td>
                                    <span style="display:inline-block;padding:3px;border:1px solid #CCC;">
                                        <img src="<?php echo ($f["value"]); ?>" id="<?php echo ($k); ?>-preview" style="height:150px;min-width:50px;max-width:400px;" />
                                    </span>
                                </td>
                                <td width="20">
                                    <input type="hidden" name="<?php echo ($k); ?>" id="<?php echo ($k); ?>" value="<?php echo (htmlspecialchars($f["value"])); ?>" />
                                </td>
                                <td width="120">
                                    <div id="<?php echo ($imagefile_id); ?>"></div>
                                </td>
                            </tr>
                        </table>
                        <script type="text/javascript">
                            require(["upload_button"],function(){
                                $("#<?php echo ($imagefile_id); ?>").UploadButton({
                                    value_holder   : "#<?php echo ($k); ?>",
                                    preview_holder : "#<?php echo ($k); ?>-preview",
                                    width 	    : 24,
                                    height 	    : 24,
                                    postURL     : "<?php echo U('System/uploadhandle?action=uploadbutton&type=image');?>",
                                    background  : "http://<?php echo ($_SERVER['HTTP_HOST']); ?>/asserts/upload_button/upload_24x24.png",
                                    acceptExt   : "<?php  $exts=$f['extension']; foreach($exts as $ik=>$iv) $exts[$ik]='.'.$iv; echo join(',',$exts); ?>",
                                    showLoading : true,
                                    showAlert   : false
                                });
                            });
                        </script>

                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "commonfile": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">

                        <?php $commonfile_id = 'commonfile_'.mt_rand(100000,999999); ?>
                        <table border="0" style="table-layout:fixed">
                            <tr>
                                <td>
                                    <input name="<?php echo ($k); ?>"
                                            id="<?php echo ($k); ?>"
                                            type="text"
                                            class="form-control"
                                            placeholder=""
                                            value="<?php echo (htmlspecialchars($f["value"])); ?>"
                                            <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                            <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                                </td>
                                <td>
                                    &nbsp;&nbsp;<a href="<?php echo ($f["value"]); ?>" id="<?php echo ($k); ?>-preview" target="_blank"
                                                <?php if(!$f['value']): ?>style="display:none;"<?php endif; ?>
                                        ><?php echo (L("view")); ?></a>&nbsp;&nbsp;
                                </td>
                                <td width="120">
                                    <div id="<?php echo ($commonfile_id); ?>"></div>
                                </td>
                            </tr>
                        </table>
                        <script type="text/javascript">
                            require(["upload_button"],function(){
                                $("#<?php echo ($commonfile_id); ?>").UploadButton({
                                    value_holder   : "#<?php echo ($k); ?>",
                                    preview_holder : "#<?php echo ($k); ?>-preview",
                                    width 	    : 24,
                                    height 	    : 24,
                                    postURL     : "<?php echo U('System/uploadhandle?action=uploadbutton&type=file');?>",
                                    background  : "http://<?php echo ($_SERVER['HTTP_HOST']); ?>/asserts/upload_button/upload_24x24.png",
                                    acceptExt   : "<?php $exts=$f['extension']; foreach($exts as $ik=>$iv) $exts[$ik]='.'.$iv; echo join(',',$exts); ?>",
                                    showLoading : true,
                                    showAlert   : false
                                });
                            });
                        </script>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "treeparent": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <select name="<?php echo ($k); ?>"
                                class="form-control"
                                style="width:auto;"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                        >
                        <option value="0">顶级分类</option>
                        <?php if(is_array($f["option"])): foreach($f["option"] as $key=>$vv): if($vv['id'] == $f['value']): ?><option value="<?php echo (htmlspecialchars($vv["id"])); ?>" selected="selected"><?php echo ($vv["title"]); ?></option>
                            <?php else: ?>
                                <option value="<?php echo (htmlspecialchars($vv["id"])); ?>"><?php echo ($vv["title"]); ?></option><?php endif; endforeach; endif; ?>
                        </select>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php default: ?>
                <p class="bg-danger">
                    Unknown field <b><?php echo ($f["type"]); ?></b>
                </p><?php endswitch; endforeach; endif; ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php if(!$cfg_all_field_readonly): ?><button type="submit" class="btn btn-primary"><?php echo (L("submit")); ?></button><?php endif; ?>
            <button type="button" class="btn btn-default" onclick="window.history.go(-1);"><?php echo (L("back")); ?></button>
        </div>
    </div>

</form>


        </div>
    
</div>
<nav class="footer navbar navbar-inverse" role="navigation">
    <?php echo (L("admin_copyright")); ?>
</nav>
<?php }else{ ?>


<?php if(!empty($id)): ?><form class="form-horizontal tpx-ajaxsubmit" role="form" action="<?php echo U(CONTROLLER_NAME.'/cmshandle?action=edit&id='.$id.'&page='.$page);?>" method="post">
<?php else: ?>
    <form class="form-horizontal tpx-ajaxsubmit" role="form" action="<?php echo U(CONTROLLER_NAME.'/cmshandle?action=add&page='.$page);?>" method="post"><?php endif; ?>

    <?php if(is_array($fields)): foreach($fields as $k=>$f): switch($f["type"]): case "baidu_map": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>_lng"
                               type="text"
                               class="form-control form-inline"
                               value="<?php echo (htmlspecialchars($f["value"]["lng"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                        />
                        <input name="<?php echo ($k); ?>_lat"
                               type="text"
                               class="form-control form-inline"
                               value="<?php echo (htmlspecialchars($f["value"]["lat"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                        />
                        <input name="<?php echo ($k); ?>_keywords" type="text" class="form-control" placeholder="输入地址直接定位" value="" />
                        <div id="<?php echo ($k); ?>-warp" style="width:100%;height:400px;border:1px solid #CCC;"></div>
                        <script type="text/javascript">
                            function baidu_map_init_<?php echo ($k); ?>() {

                                var setPoint = function(pt){
                                    $('input[name=<?php echo ($k); ?>_lng]').val(pt.lng);
                                    $('input[name=<?php echo ($k); ?>_lat]').val(pt.lat);
                                };

                                var getPoint = function(){
                                    return new BMap.Point($('input[name=<?php echo ($k); ?>_lng]').val(),$('input[name=<?php echo ($k); ?>_lat]').val());
                                };

                                var map = new BMap.Map("<?php echo ($k); ?>-warp");
                                map.centerAndZoom(getPoint(),15);
                                map.enableScrollWheelZoom();

                                var marker = new BMap.Marker(map.getCenter());
                                marker.enableDragging();
                                marker.addEventListener('dragend',function(e){
                                    setPoint(e.point);
                                });
                                map.addOverlay(marker);
                                map.addEventListener('click',function(e){
                                    setPoint(e.point);
                                    marker.setPosition(e.point);
                                });

                                var search = function(){
                                    map.centerAndZoom($('input[name=<?php echo ($k); ?>_keywords]').val(),15);
                                    marker.setPosition(map.getCenter());
                                    setPoint(map.getCenter());
                                };
                                var searchTimeout = null;
                                $('input[name=<?php echo ($k); ?>_keywords]').on('keyup',function(){
                                    if(searchTimeout){
                                        clearTimeout(searchTimeout);
                                        searchTimeout = null;
                                    }
                                    searchTimeout = setTimeout(search, 100);
                                });
                            }
                            require(['jquery.extern'], function () {
                                $.includeJS("api?v=2.0&ak=<?php echo ($f["key"]); ?>&callback=baidu_map_init_<?php echo ($k); ?>&",'http://api.map.baidu.com/');
                            });
                        </script>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "china_district": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>" type="hidden" value="<?php echo (htmlspecialchars($f["value"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <span id="<?php echo ($k); ?>-warp"></span>
                        <script type="text/javascript">
                            require(['jquery.category'], function () {
                                $('#<?php echo ($k); ?>-warp').category({
                                    selectClass: 'form-control input-sm form-inline',
                                    inputNames: '',
                                    inputGlobalName: '',
                                    ajaxUrl: "<?php echo U('System/china_district');?>",
                                    pleaseSelectText: '[请选择]',
                                    initValue: '<?php echo (htmlspecialchars($f["value"])); ?>',
                                    data: {select_level:'<?php echo ($f["select_level"]); ?>'},
                                    onSelect: function (id) {
                                        $('input[name=<?php echo ($k); ?>]').val(id);
                                    }
                                });
                            });
                        </script>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "cms_id": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                               type="text"
                               class="form-control input-inline"
                               placeholder=""
                               value="<?php echo (htmlspecialchars($f["value"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "member_uid": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                               type="text"
                               class="form-control input-inline"
                               placeholder=""
                               value="<?php echo (htmlspecialchars($f["value"])); ?>"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "tag": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <div class="pillbox" id="<?php echo ($k); ?>">
                            <ul class="clearfix pill-group">
                                <?php if(is_array($f['value'])): $i = 0; $__LIST__ = $f['value'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="btn btn-default pill" data-value="<?php echo ($v); ?>">
                                        <span><?php echo ($v); ?></span>
                                        <span class="glyphicon glyphicon-close">
                                            <span class="sr-only">Remove</span>
                                        </span>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                <li class="pillbox-input-wrap btn-group">
                                    <input type="text" class="form-control dropdown-toggle pillbox-add-item" placeholder="点击如下可用标签或输入" />
                                </li>
                            </ul>
                        </div>
                        <script>
                            require(['jquery.extern','fuelux/pillbox'],function(){
                                $.includeCSS('css/fuelux');
                                $('#<?php echo ($k); ?>').pillbox();
                                $('#<?php echo ($k); ?>-list .btn').on('click',function(){
                                    $('#<?php echo ($k); ?>').pillbox('addItems', -1, [{ text: $(this).text(), value:$(this).text(), attr: {}, data: {} }]);
                                    return false;
                                });
                            });
                        </script>
                        <div style="padding:10px 0;" id="<?php echo ($k); ?>-list">
                            <?php if(is_array($f['option'])): $i = 0; $__LIST__ = $f['option'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><button class="btn btn-default btn-sm"><?php echo ($v); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                        <input type="hidden" name="<?php echo ($k); ?>" value="" />
                    </div>
                </div><?php break;?>

            <?php case "text": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                                type="text"
                                class="form-control"
                                placeholder=""
                                value="<?php echo (htmlspecialchars($f["value"])); ?>"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "number": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                                type="text"
                                class="form-control"
                                placeholder=""
                                value="<?php echo (htmlspecialchars($f["value"])); ?>"
                                style="width:auto;"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "datetime": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                                type="text"
                                class="form-control"
                                placeholder=""
                                value="<?php echo (date('Y-m-d H:i:s',$f["value"])); ?>"
                                style="width:auto;"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                        <script type="text/javascript">
                            require(["jquery.extern"],function(){
                                $.includeCSS("jquery-ui-1.11.2/jquery-ui-timepicker-addon");
                            });
                            require(["jquery.ui.timepicker"],function(){
                                $( "input[name=<?php echo ($k); ?>]" ).datetimepicker({
                                    dateFormat:"yy-mm-dd",
                                    timeFormat:'HH:mm:ss'
                                });
                            });
                        </script>
                    </div>
                </div><?php break;?>

            <?php case "date": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <input name="<?php echo ($k); ?>"
                                type="text"
                                class="form-control"
                                placeholder=""
                                value="<?php echo (date('Y-m-d',$f["value"])); ?>"
                                style="width:auto;"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                        <script type="text/javascript">
                            require(["jquery.extern"],function(){
                                $.includeCSS("jquery-ui-1.11.2/jquery-ui-timepicker-addon");
                            });
                            require(["jquery.ui.timepicker"],function(){
                                $( "input[name=<?php echo ($k); ?>]" ).datepicker({
                                    dateFormat:"yy-mm-dd",
                                    timeFormat:''
                                });
                            });
                        </script>
                    </div>
                </div><?php break;?>

            <?php case "switch": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="<?php echo ($k); ?>" value="1"<?php if($f["value"] == 1): ?>checked="checked"<?php endif; ?>> <?php echo (L("switch_on")); ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="<?php echo ($k); ?>" value="0"<?php if($f["value"] == 0): ?>checked="checked"<?php endif; ?>> <?php echo (L("switch_off")); ?>
                        </label>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "bigtext": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <textarea name="<?php echo ($k); ?>"
                                    class="form-control"
                                    placeholder=""
                                    style="min-height:6em;"
                                    <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                    <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                                    ><?php echo (htmlspecialchars($f["value"])); ?></textarea>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "selectnumber": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <select name="<?php echo ($k); ?>"
                                    class="form-control"
                                    style="width:auto;"
                                    <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                    <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                                >
                            <?php if(is_array($f["option"])): foreach($f["option"] as $kk=>$vv): if($kk == $f['value']): ?><option value="<?php echo (htmlspecialchars($kk)); ?>" selected="selected"><?php echo ($vv); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo (htmlspecialchars($kk)); ?>"><?php echo ($vv); ?></option><?php endif; endforeach; endif; ?>
                        </select>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "selecttext": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <select name="<?php echo ($k); ?>"
                                class="form-control"
                                style="width:auto;"
                                <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                                >
                            <?php if(is_array($f["option"])): foreach($f["option"] as $kk=>$vv): if($kk == $f['value']): ?><option value="<?php echo (htmlspecialchars($kk)); ?>" selected="selected"><?php echo ($vv); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo (htmlspecialchars($kk)); ?>"><?php echo ($vv); ?></option><?php endif; endforeach; endif; ?>
                        </select>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "checkbox": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <?php if(in_array('inline',$f['rules'])): if(is_array($f["option"])): foreach($f["option"] as $kk=>$vv): ?><div class="checkbox" style="display:inline-block;padding-right:2em;">
                                    <label>
                                        <?php if(in_array($kk,$f['value'])): ?><input name="<?php echo ($k); ?>[]" type="checkbox" checked="checked" value="<?php echo (htmlspecialchars($kk)); ?>"> <?php echo ($vv); ?>
                                        <?php else: ?>
                                            <input name="<?php echo ($k); ?>[]" type="checkbox" value="<?php echo (htmlspecialchars($kk)); ?>"> <?php echo ($vv); endif; ?>
                                    </label>
                                </div><?php endforeach; endif; ?>
                        <?php else: ?>
                            <?php if(is_array($f["option"])): foreach($f["option"] as $kk=>$vv): ?><div class="checkbox">
                                    <label>
                                        <?php if(in_array($kk,$f['value'])): ?><input name="<?php echo ($k); ?>[]" type="checkbox" checked="checked" value="<?php echo (htmlspecialchars($kk)); ?>"> <?php echo ($vv); ?>
                                        <?php else: ?>
                                            <input name="<?php echo ($k); ?>[]" type="checkbox" value="<?php echo (htmlspecialchars($kk)); ?>"> <?php echo ($vv); endif; ?>
                                    </label>
                                </div><?php endforeach; endif; endif; ?>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "richtext": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <script id="<?php echo ($k); ?>" name="<?php echo ($k); ?>" type="text/plain">
                            <?php echo ($f["value"]); ?>
                        </script>
                        <script type="text/javascript">
                            require(["ueditor"],function(){
                                var ue = UE.getEditor('<?php echo ($k); ?>') ;
                                if(TPX.UEDITOR){
                                    TPX.UEDITOR.push(ue);
                                }
                            });
                        </script>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "imagefile": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">

                        <?php $imagefile_id = 'imagefile_'.mt_rand(100000,999999); ?>
                        <table border="0" style="table-layout:fixed">
                            <tr>
                                <td>
                                    <span style="display:inline-block;padding:3px;border:1px solid #CCC;">
                                        <img src="<?php echo ($f["value"]); ?>" id="<?php echo ($k); ?>-preview" style="height:150px;min-width:50px;max-width:400px;" />
                                    </span>
                                </td>
                                <td width="20">
                                    <input type="hidden" name="<?php echo ($k); ?>" id="<?php echo ($k); ?>" value="<?php echo (htmlspecialchars($f["value"])); ?>" />
                                </td>
                                <td width="120">
                                    <div id="<?php echo ($imagefile_id); ?>"></div>
                                </td>
                            </tr>
                        </table>
                        <script type="text/javascript">
                            require(["upload_button"],function(){
                                $("#<?php echo ($imagefile_id); ?>").UploadButton({
                                    value_holder   : "#<?php echo ($k); ?>",
                                    preview_holder : "#<?php echo ($k); ?>-preview",
                                    width 	    : 24,
                                    height 	    : 24,
                                    postURL     : "<?php echo U('System/uploadhandle?action=uploadbutton&type=image');?>",
                                    background  : "http://<?php echo ($_SERVER['HTTP_HOST']); ?>/asserts/upload_button/upload_24x24.png",
                                    acceptExt   : "<?php  $exts=$f['extension']; foreach($exts as $ik=>$iv) $exts[$ik]='.'.$iv; echo join(',',$exts); ?>",
                                    showLoading : true,
                                    showAlert   : false
                                });
                            });
                        </script>

                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "commonfile": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">

                        <?php $commonfile_id = 'commonfile_'.mt_rand(100000,999999); ?>
                        <table border="0" style="table-layout:fixed">
                            <tr>
                                <td>
                                    <input name="<?php echo ($k); ?>"
                                            id="<?php echo ($k); ?>"
                                            type="text"
                                            class="form-control"
                                            placeholder=""
                                            value="<?php echo (htmlspecialchars($f["value"])); ?>"
                                            <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                                            <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?> />
                                </td>
                                <td>
                                    &nbsp;&nbsp;<a href="<?php echo ($f["value"]); ?>" id="<?php echo ($k); ?>-preview" target="_blank"
                                                <?php if(!$f['value']): ?>style="display:none;"<?php endif; ?>
                                        ><?php echo (L("view")); ?></a>&nbsp;&nbsp;
                                </td>
                                <td width="120">
                                    <div id="<?php echo ($commonfile_id); ?>"></div>
                                </td>
                            </tr>
                        </table>
                        <script type="text/javascript">
                            require(["upload_button"],function(){
                                $("#<?php echo ($commonfile_id); ?>").UploadButton({
                                    value_holder   : "#<?php echo ($k); ?>",
                                    preview_holder : "#<?php echo ($k); ?>-preview",
                                    width 	    : 24,
                                    height 	    : 24,
                                    postURL     : "<?php echo U('System/uploadhandle?action=uploadbutton&type=file');?>",
                                    background  : "http://<?php echo ($_SERVER['HTTP_HOST']); ?>/asserts/upload_button/upload_24x24.png",
                                    acceptExt   : "<?php $exts=$f['extension']; foreach($exts as $ik=>$iv) $exts[$ik]='.'.$iv; echo join(',',$exts); ?>",
                                    showLoading : true,
                                    showAlert   : false
                                });
                            });
                        </script>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php case "treeparent": ?><div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo ($f["title"]); ?></label>
                    <div class="col-sm-9">
                        <select name="<?php echo ($k); ?>"
                                class="form-control"
                                style="width:auto;"
                        <?php if(in_array('readonly',$f['rules'])): ?>readonly="readonly"<?php endif; ?>
                        <?php if(in_array('required',$f['rules'])): ?>required="required"<?php endif; ?>
                        >
                        <option value="0">顶级分类</option>
                        <?php if(is_array($f["option"])): foreach($f["option"] as $key=>$vv): if($vv['id'] == $f['value']): ?><option value="<?php echo (htmlspecialchars($vv["id"])); ?>" selected="selected"><?php echo ($vv["title"]); ?></option>
                            <?php else: ?>
                                <option value="<?php echo (htmlspecialchars($vv["id"])); ?>"><?php echo ($vv["title"]); ?></option><?php endif; endforeach; endif; ?>
                        </select>
                        <div class="help-block"><?php echo (htmlspecialchars($f["description"])); ?></div>
                    </div>
                </div><?php break;?>

            <?php default: ?>
                <p class="bg-danger">
                    Unknown field <b><?php echo ($f["type"]); ?></b>
                </p><?php endswitch; endforeach; endif; ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php if(!$cfg_all_field_readonly): ?><button type="submit" class="btn btn-primary"><?php echo (L("submit")); ?></button><?php endif; ?>
            <button type="button" class="btn btn-default" onclick="window.history.go(-1);"><?php echo (L("back")); ?></button>
        </div>
    </div>

</form>


<?php } ?>

<script type="text/javascript">
var admin_ueditor_handle = "<?php echo U('System/uploadhandle');?>";
var admin_ueditor_lang =
/*<?php if(LANG_SET == 'zh-cn'): ?>*/
    'zh-cn'
/*<?php else: ?>*/
    'en'
    /*<?php endif; ?>*/
;
</script>
<script src="/asserts/admin/admin.src.js?<?php echo (STATIC_RES_HASH); ?>"></script>
</body>
</html>