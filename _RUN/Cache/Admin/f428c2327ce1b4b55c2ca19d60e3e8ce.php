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
            

    <?php if(is_array($nodes)): foreach($nodes as $k=>$n): if($n["name"] == 'Admin'): if(is_array($n["_child"])): foreach($n["_child"] as $kk=>$nn): ?><div class="panel panel-default">
                    <div class="panel-heading">
                        <?php if(($n["status"] == 1) AND ($nn["status"] == 1)): ?><b><?php echo ($nn["title"]); ?></b>
                        <?php else: ?>
                            <b class="text-disable"><?php echo ($nn["title"]); ?></b><?php endif; ?>
                        <?php if(access_permit('nodehandle')): ?><a href="<?php echo U('Administrator/nodehandle?action=edit&id='.$nn['id']);?>"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="<?php echo U('Administrator/nodehandle?action=delete&ids='.$nn['id']);?>"><span class="glyphicon glyphicon-trash"></span></a>
                            <a class="pull-right" href="<?php echo U('Administrator/nodehandle?action=add&pid='.$nn['id']);?>"><span class="glyphicon glyphicon-plus"></span></a><?php endif; ?>
                    </div>
                    <div class="panel-body" style="line-height:2em;">
                        <?php if(is_array($nn["_child"])): foreach($nn["_child"] as $kkk=>$nnn): ?><div class="pull-left" style="padding-right:1em;">
                                <?php if(($n["status"] == 1) AND ($nn["status"] == 1) AND ($nnn["status"] == 1)): ?><span><?php echo ($nnn["title"]); ?></span>
                                <?php else: ?>
                                    <span class="text-disable"><?php echo ($nnn["title"]); ?></span><?php endif; ?>
                                <?php if(access_permit('nodehandle')): ?><a href="<?php echo U('Administrator/nodehandle?action=edit&id='.$nnn['id']);?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="<?php echo U('Administrator/nodehandle?action=delete&ids='.$nnn['id']);?>"><span class="glyphicon glyphicon-trash"></span></a><?php endif; ?>
                            </div><?php endforeach; endif; ?>
                    </div>
                </div><?php endforeach; endif; endif; endforeach; endif; ?>
    <?php if(access_permit('nodehandle')): ?><a href="<?php echo U('Administrator/nodehandle?action=add&pid='.$n['id']);?>"><span class="glyphicon glyphicon-plus"></span></a><?php endif; ?>




        </div>
    
</div>
<nav class="footer navbar navbar-inverse" role="navigation">
    <?php echo (L("admin_copyright")); ?>
</nav>
<?php }else{ ?>


    <?php if(is_array($nodes)): foreach($nodes as $k=>$n): if($n["name"] == 'Admin'): if(is_array($n["_child"])): foreach($n["_child"] as $kk=>$nn): ?><div class="panel panel-default">
                    <div class="panel-heading">
                        <?php if(($n["status"] == 1) AND ($nn["status"] == 1)): ?><b><?php echo ($nn["title"]); ?></b>
                        <?php else: ?>
                            <b class="text-disable"><?php echo ($nn["title"]); ?></b><?php endif; ?>
                        <?php if(access_permit('nodehandle')): ?><a href="<?php echo U('Administrator/nodehandle?action=edit&id='.$nn['id']);?>"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="<?php echo U('Administrator/nodehandle?action=delete&ids='.$nn['id']);?>"><span class="glyphicon glyphicon-trash"></span></a>
                            <a class="pull-right" href="<?php echo U('Administrator/nodehandle?action=add&pid='.$nn['id']);?>"><span class="glyphicon glyphicon-plus"></span></a><?php endif; ?>
                    </div>
                    <div class="panel-body" style="line-height:2em;">
                        <?php if(is_array($nn["_child"])): foreach($nn["_child"] as $kkk=>$nnn): ?><div class="pull-left" style="padding-right:1em;">
                                <?php if(($n["status"] == 1) AND ($nn["status"] == 1) AND ($nnn["status"] == 1)): ?><span><?php echo ($nnn["title"]); ?></span>
                                <?php else: ?>
                                    <span class="text-disable"><?php echo ($nnn["title"]); ?></span><?php endif; ?>
                                <?php if(access_permit('nodehandle')): ?><a href="<?php echo U('Administrator/nodehandle?action=edit&id='.$nnn['id']);?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="<?php echo U('Administrator/nodehandle?action=delete&ids='.$nnn['id']);?>"><span class="glyphicon glyphicon-trash"></span></a><?php endif; ?>
                            </div><?php endforeach; endif; ?>
                    </div>
                </div><?php endforeach; endif; endif; endforeach; endif; ?>
    <?php if(access_permit('nodehandle')): ?><a href="<?php echo U('Administrator/nodehandle?action=add&pid='.$n['id']);?>"><span class="glyphicon glyphicon-plus"></span></a><?php endif; ?>




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