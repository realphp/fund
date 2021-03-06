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
            

    <form class="form-horizontal tpx-ajaxsubmit" role="form" action="<?php echo U(CONTROLLER_NAME.'/'.ACTION_NAME);?>" method="post">

        <div class="form-group">
            <label class="col-sm-2 control-label">首页公司介绍</label>
            <div class="col-sm-9">
                <script id="home_about" name="home_about" type="text/plain">
                            <?php echo ($home_about); ?>
                        </script>
                <script type="text/javascript">
                    require(["ueditor"],function(){
                        var ue = UE.getEditor('home_about') ;
                        if(TPX.UEDITOR){
                            TPX.UEDITOR.push(ue);
                        }
                    });
                </script>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Logo</label>
            <div class="col-sm-9">
                <table border="0" style="table-layout:fixed">
                    <tr>
                        <td>
                            <span style="display:inline-block;padding:3px;border:1px solid #CCC;">
                                <img src="<?php echo ($image_logo); ?>" id="image_logo-preview" style="height:150px;min-width:50px;max-width:400px;" />
                            </span>
                        </td>
                        <td width="20">
                            <input type="hidden" name="image_logo" id="image_logo" value="<?php echo (t_html($image_logo)); ?>" />
                        </td>
                        <td width="120">
                            <div id="image_logo-box"></div>
                        </td>
                    </tr>
                </table>
                <script type="text/javascript">
                    require(["upload_button"],function(){
                        $("#image_logo-box").UploadButton({
                            value_holder   : "#image_logo",
                            preview_holder : "#image_logo-preview",
                            width 	    : 24,
                            height 	    : 24,
                            postURL     : "<?php echo U('System/uploadhandle?action=uploadbutton&type=image');?>",
                            background  : "http://<?php echo ($_SERVER['HTTP_HOST']); ?>/asserts/upload_button/upload_24x24.png",
                            acceptExt   : ".png",
                            showLoading : true,
                            showAlert   : false
                        });
                    });
                </script>
                <div class="help-block">尺寸150x50，PNG格式</div>
            </div>
        </div>



        <div class="form-group">
            <label class="col-sm-2 control-label">二维码</label>
            <div class="col-sm-9">
                <table border="0" style="table-layout:fixed">
                    <tr>
                        <td>
                            <span style="display:inline-block;padding:3px;border:1px solid #CCC;">
                                <img src="<?php echo ($image_qr); ?>" id="image_qr-preview" style="height:150px;min-width:50px;max-width:400px;" />
                            </span>
                        </td>
                        <td width="20">
                            <input type="hidden" name="image_qr" id="image_qr" value="<?php echo (t_html($image_qr)); ?>" />
                        </td>
                        <td width="120">
                            <div id="image_qr-box"></div>
                        </td>
                    </tr>
                </table>
                <script type="text/javascript">
                    require(["upload_button"],function(){
                        $("#image_qr-box").UploadButton({
                            value_holder   : "#image_qr",
                            preview_holder : "#image_qr-preview",
                            width 	    : 24,
                            height 	    : 24,
                            postURL     : "<?php echo U('System/uploadhandle?action=uploadbutton&type=image');?>",
                            background  : "http://<?php echo ($_SERVER['HTTP_HOST']); ?>/asserts/upload_button/upload_24x24.png",
                            acceptExt   : ".png",
                            showLoading : true,
                            showAlert   : false
                        });
                    });
                </script>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">色调</label>
            <div class="col-sm-9">
                <select name="theme_color"
                        class="form-control"
                        style="width:auto;">
                    <option value="red" <?php if($theme_color == 'red'): ?>selected<?php endif; ?>>红色系</option>
                    <option value="blue" <?php if($theme_color == 'blue'): ?>selected<?php endif; ?>>蓝色系</option>
                    <option value="green" <?php if($theme_color == 'green'): ?>selected<?php endif; ?>>绿色系</option>
                    <option value="orange" <?php if($theme_color == 'orange'): ?>selected<?php endif; ?>>橙色系</option>
                </select>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary"><?php echo (L("submit")); ?></button>
            </div>
        </div>

    </form>


        </div>
    
</div>
<nav class="footer navbar navbar-inverse" role="navigation">
    <?php echo (L("admin_copyright")); ?>
</nav>
<?php }else{ ?>


    <form class="form-horizontal tpx-ajaxsubmit" role="form" action="<?php echo U(CONTROLLER_NAME.'/'.ACTION_NAME);?>" method="post">

        <div class="form-group">
            <label class="col-sm-2 control-label">首页公司介绍</label>
            <div class="col-sm-9">
                <script id="home_about" name="home_about" type="text/plain">
                            <?php echo ($home_about); ?>
                        </script>
                <script type="text/javascript">
                    require(["ueditor"],function(){
                        var ue = UE.getEditor('home_about') ;
                        if(TPX.UEDITOR){
                            TPX.UEDITOR.push(ue);
                        }
                    });
                </script>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Logo</label>
            <div class="col-sm-9">
                <table border="0" style="table-layout:fixed">
                    <tr>
                        <td>
                            <span style="display:inline-block;padding:3px;border:1px solid #CCC;">
                                <img src="<?php echo ($image_logo); ?>" id="image_logo-preview" style="height:150px;min-width:50px;max-width:400px;" />
                            </span>
                        </td>
                        <td width="20">
                            <input type="hidden" name="image_logo" id="image_logo" value="<?php echo (t_html($image_logo)); ?>" />
                        </td>
                        <td width="120">
                            <div id="image_logo-box"></div>
                        </td>
                    </tr>
                </table>
                <script type="text/javascript">
                    require(["upload_button"],function(){
                        $("#image_logo-box").UploadButton({
                            value_holder   : "#image_logo",
                            preview_holder : "#image_logo-preview",
                            width 	    : 24,
                            height 	    : 24,
                            postURL     : "<?php echo U('System/uploadhandle?action=uploadbutton&type=image');?>",
                            background  : "http://<?php echo ($_SERVER['HTTP_HOST']); ?>/asserts/upload_button/upload_24x24.png",
                            acceptExt   : ".png",
                            showLoading : true,
                            showAlert   : false
                        });
                    });
                </script>
                <div class="help-block">尺寸150x50，PNG格式</div>
            </div>
        </div>



        <div class="form-group">
            <label class="col-sm-2 control-label">二维码</label>
            <div class="col-sm-9">
                <table border="0" style="table-layout:fixed">
                    <tr>
                        <td>
                            <span style="display:inline-block;padding:3px;border:1px solid #CCC;">
                                <img src="<?php echo ($image_qr); ?>" id="image_qr-preview" style="height:150px;min-width:50px;max-width:400px;" />
                            </span>
                        </td>
                        <td width="20">
                            <input type="hidden" name="image_qr" id="image_qr" value="<?php echo (t_html($image_qr)); ?>" />
                        </td>
                        <td width="120">
                            <div id="image_qr-box"></div>
                        </td>
                    </tr>
                </table>
                <script type="text/javascript">
                    require(["upload_button"],function(){
                        $("#image_qr-box").UploadButton({
                            value_holder   : "#image_qr",
                            preview_holder : "#image_qr-preview",
                            width 	    : 24,
                            height 	    : 24,
                            postURL     : "<?php echo U('System/uploadhandle?action=uploadbutton&type=image');?>",
                            background  : "http://<?php echo ($_SERVER['HTTP_HOST']); ?>/asserts/upload_button/upload_24x24.png",
                            acceptExt   : ".png",
                            showLoading : true,
                            showAlert   : false
                        });
                    });
                </script>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">色调</label>
            <div class="col-sm-9">
                <select name="theme_color"
                        class="form-control"
                        style="width:auto;">
                    <option value="red" <?php if($theme_color == 'red'): ?>selected<?php endif; ?>>红色系</option>
                    <option value="blue" <?php if($theme_color == 'blue'): ?>selected<?php endif; ?>>蓝色系</option>
                    <option value="green" <?php if($theme_color == 'green'): ?>selected<?php endif; ?>>绿色系</option>
                    <option value="orange" <?php if($theme_color == 'orange'): ?>selected<?php endif; ?>>橙色系</option>
                </select>
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary"><?php echo (L("submit")); ?></button>
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