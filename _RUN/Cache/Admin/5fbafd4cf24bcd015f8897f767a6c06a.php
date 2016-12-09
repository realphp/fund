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
            

    <div class="container">
        <div class="header">
            <h3>&nbsp;</h3>
        </div>

        <div class="well" style="max-width:300px;margin:0 auto;">

            <form class="tpx-ajaxsubmit" role="form" action="<?php echo U('Login/submit');?>" method="post">

                <div class="row">
                    <div class="col-xs-12">
                        <h3><?php echo (L("please_login")); ?></h3>
                    </div>
                    <div class="col-xs-12">
                        &nbsp;
                    </div>
                    <div class="col-xs-12">
                        <input name="username" type="text" class="form-control input-md"
                               placeholder="<?php echo (L("username")); ?>" required="required" value="" autofocus="autofocus"/>
                    </div>
                    <div class="col-xs-12">
                        &nbsp;
                    </div>
                    <div class="col-xs-12">
                        <input name="password" type="password" class="form-control input-md"
                               placeholder="<?php echo (L("password")); ?>" required="required" value=""/>
                    </div>
                    <div class="col-xs-12">
                        &nbsp;
                    </div>
                    <div class="col-xs-6">
                        <input name="verify" type="text" class="form-control input-md"
                               placeholder="<?php echo (L("verify")); ?>" required="required" value=""/>
                    </div>
                    <div class="col-xs-6">
                        <img id="auto-click-on-error" src="<?php echo U('Login/verify');?>&<?php echo time(); ?>"
                             style="width:100%;height:39px;cursor:pointer;"
                             onclick="this.src='<?php echo U('Login/verify');?>&'+Math.random()"/>
                    </div>
                    <div class="col-xs-12">
                        &nbsp;
                    </div>
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-md btn-block"><?php echo (L("login")); ?></button>
                    </div>
                </div>
            </form>


        </div>
    </div>

        </div>
    
</div>
<nav class="footer navbar navbar-inverse" role="navigation">
    <?php echo (L("admin_copyright")); ?>
</nav>
<?php }else{ ?>


    <div class="container">
        <div class="header">
            <h3>&nbsp;</h3>
        </div>

        <div class="well" style="max-width:300px;margin:0 auto;">

            <form class="tpx-ajaxsubmit" role="form" action="<?php echo U('Login/submit');?>" method="post">

                <div class="row">
                    <div class="col-xs-12">
                        <h3><?php echo (L("please_login")); ?></h3>
                    </div>
                    <div class="col-xs-12">
                        &nbsp;
                    </div>
                    <div class="col-xs-12">
                        <input name="username" type="text" class="form-control input-md"
                               placeholder="<?php echo (L("username")); ?>" required="required" value="" autofocus="autofocus"/>
                    </div>
                    <div class="col-xs-12">
                        &nbsp;
                    </div>
                    <div class="col-xs-12">
                        <input name="password" type="password" class="form-control input-md"
                               placeholder="<?php echo (L("password")); ?>" required="required" value=""/>
                    </div>
                    <div class="col-xs-12">
                        &nbsp;
                    </div>
                    <div class="col-xs-6">
                        <input name="verify" type="text" class="form-control input-md"
                               placeholder="<?php echo (L("verify")); ?>" required="required" value=""/>
                    </div>
                    <div class="col-xs-6">
                        <img id="auto-click-on-error" src="<?php echo U('Login/verify');?>&<?php echo time(); ?>"
                             style="width:100%;height:39px;cursor:pointer;"
                             onclick="this.src='<?php echo U('Login/verify');?>&'+Math.random()"/>
                    </div>
                    <div class="col-xs-12">
                        &nbsp;
                    </div>
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-md btn-block"><?php echo (L("login")); ?></button>
                    </div>
                </div>
            </form>


        </div>
    </div>

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