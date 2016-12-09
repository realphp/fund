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
            
    <a href="<?php echo U('System/security?action=generate');?>" role="button"><?php echo (L("finger_generate")); ?></a>

        </div>
        <div id="page-content">
            

    <div class="row">
        <div class="col-md-12">
            <div style="padding:0 0 1em 0;">

            </div>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th><?php echo (L("name")); ?></th>
            <?php if(is_founder()): ?><th><?php echo (L("operation")); ?></th><?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($finger_files)): foreach($finger_files as $key=>$v): ?><tr>
                <td><b>[<?php echo (date('Y-m-d H:i:s',$v["ctime"])); ?>]</b> <?php echo ($v["filename"]); ?></td>
                <td>
                    <a href="<?php echo U('System/security?action=check&file='.md5($v['filename']));?>" title="<?php echo (L("finger_check")); ?>"><span class="glyphicon glyphicon-refresh"></span></a>&nbsp;&nbsp;
                    <a href="<?php echo U('System/security?action=delete&file='.md5($v['filename']));?>" title="<?php echo (L("delete")); ?>"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>

    <script type="text/javascript">
        function admin_mod_build(mod){
            var url = "<?php echo U('Mod-controller-/build');?>";
            url = url.replace('-controller-',mod);
            $.post(url,{},$.defaultFormCallback);
        }
    </script>


        </div>
    
</div>
<nav class="footer navbar navbar-inverse" role="navigation">
    <?php echo (L("admin_copyright")); ?>
</nav>
<?php }else{ ?>


    <div class="row">
        <div class="col-md-12">
            <div style="padding:0 0 1em 0;">

            </div>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th><?php echo (L("name")); ?></th>
            <?php if(is_founder()): ?><th><?php echo (L("operation")); ?></th><?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($finger_files)): foreach($finger_files as $key=>$v): ?><tr>
                <td><b>[<?php echo (date('Y-m-d H:i:s',$v["ctime"])); ?>]</b> <?php echo ($v["filename"]); ?></td>
                <td>
                    <a href="<?php echo U('System/security?action=check&file='.md5($v['filename']));?>" title="<?php echo (L("finger_check")); ?>"><span class="glyphicon glyphicon-refresh"></span></a>&nbsp;&nbsp;
                    <a href="<?php echo U('System/security?action=delete&file='.md5($v['filename']));?>" title="<?php echo (L("delete")); ?>"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>

    <script type="text/javascript">
        function admin_mod_build(mod){
            var url = "<?php echo U('Mod-controller-/build');?>";
            url = url.replace('-controller-',mod);
            $.post(url,{},$.defaultFormCallback);
        }
    </script>


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