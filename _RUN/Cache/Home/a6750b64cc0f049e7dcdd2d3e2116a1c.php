<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <script>(function(w){w.onerror=function(n,o,r){var i=encodeURIComponent;(new Image).src="/?s=watcher/js&error="+i(n)+"&file="+i(o)+"&line="+i(r)+"&url="+i(w.location.href)+'&agent='+i(navigator.userAgent)}})(window);</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="keywords" content="<?php echo ($page_keywords); ?>" />
    <meta name="description" content="<?php echo ($page_description); ?>" />
    <meta name="generator" content="Co.MZ V<?php echo (APP_VERSION); ?>" />
    <meta name="author" content="Co.MZ TecMZ" />
    <meta name="copyright" content="2015 TecMZ Inc." />
    <link rel="icon" href="/asserts/res/fav.ico?<?php echo (STATIC_RES_HASH); ?>" type="image/x-icon" />
    <link rel="shortcut icon" href="/asserts/res/fav.ico?<?php echo (STATIC_RES_HASH); ?>" type="image/x-icon" />
    <title><?php echo ($page_title); ?></title>
    <link rel="stylesheet" type="text/css" href="/asserts/bootstrap/css/bootstrap.yeti.min.css?<?php echo (STATIC_RES_HASH); ?>" />
    <!--<link rel="stylesheet" type="text/css" href="/asserts/res/style-<?php echo tpx_config_get('theme_color','xxx'); ?>.css?<?php echo (STATIC_RES_HASH); ?>" />-->
    <link rel="stylesheet" type="text/css" href="/asserts/css/style.css?<?php echo (STATIC_RES_HASH); ?>" />
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
            UEDITOR:[],
            REWRITE: <?php if(C('URL_MODEL')==2){echo 'true';}else{echo 'false';} ?>
        };
        var require = {
            baseUrl : '/asserts/js'
        };
    </script>
    <script src="/asserts/js/require.src.js?<?php echo (STATIC_RES_HASH); ?>"></script>
    <?php echo tpx_config_get('code_counter_position',0)?'':tpx_config_get('code_counter',''); ?>
</head>
<body>


    <header>
    <div class="container header-nav">
        <nav class="navbar" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#menu-main">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Brand</a>
                </div>
                <div class="collapse navbar-collapse" id="menu-main">
                    <ul class="nav navbar-nav">
                        <li><a href="/"  <?php if(CONTROLLER_NAME == 'Index'): ?>class="active"<?php endif; ?> >首页</a></li>
                        <li><a href="<?php echo U('/About');?>"  <?php if(CONTROLLER_NAME == 'About' and ACTION_NAME != 'welfare'): ?>class="active"<?php endif; ?>>关于我们</a></li>
                        <li><a href="<?php echo U('/About/welfare');?>"  <?php if(CONTROLLER_NAME == 'About' and ACTION_NAME == 'welfare' ): ?>class="active"<?php endif; ?> >公益行动</a></li>
                        <li><a href="<?php echo U('/News');?>" <?php if(CONTROLLER_NAME == 'News' or CONTROLLER_NAME == 'Album' or CONTROLLER_NAME == 'Articles' ): ?>class="active"<?php endif; ?> >最新资讯</a></li>
                        <li><a href="<?php echo U('/Partner');?>"  <?php if(CONTROLLER_NAME == 'Partner'): ?>class="active"<?php endif; ?>  >公益伙伴</a></li>
                        <li><a href="<?php echo U('/Donate');?>" <?php if(CONTROLLER_NAME == 'Donate'): ?>class="active"<?php endif; ?> >关于捐赠</a></li>
                    </ul>
                </div>
            </div><!-- /.container-fluid -->
        </nav>
    </div>

</header>

    <div class="container">
        <div class="row">
            <div class="col-md-2 about-left" style="padding:0px;">
                <div class="about-title">
                    <h3>关于我们</h3>
                    <em></em>
                    <h4><a href="<?php echo U('/News');?>" class="active2">新闻动态</a></h4>
                    <h4><a href="<?php echo U('/Article/contact');?>">我们在行动</a></h4>
                    <h4><a href="<?php echo U('/Article/contact');?>">相册</a></h4>
                </div>
                <div class="left-donate">
    <a href="<?php echo U('/Donate');?>" class="org-btn">我要捐款</a>
    <a href="#" class="org-btn">我要报名</a>
</div>
            </div>

            <div class="col-md-10 about-desc">
                <h2>联系我们</h2>
                <hr>

                <div class="box-page-main">
                    <h1>
                        <?php echo ($data_news["title"]); ?>
                    </h1>
                    <div class="attr">
                        发布时间：<?php echo (date('Y-m-d H:i',$data_news["posttime"])); ?>
                    </div>
                    <div class="main">
                        <?php echo ($data_news["content"]); ?>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <footer>
    <div class="container">
        <p class="footerBtn">
            <a href="/">首页</a>|<a
                href="/index.php?g=home&amp;m=page&amp;a=index&amp;id=38">关于我们</a>|<a
                href="/index.php?g=home&amp;m=article&amp;a=index&amp;id=43">公益行动</a>|<a
                href="/index.php?m=info&amp;a=index&amp;id=48&amp;year=2016">最新资讯</a>|<a
                href="/index.php?g=home&amp;m=partner&amp;a=index&amp;id=51">公益伙伴</a>|<a
                href="/index.php?g=home&amp;m=page&amp;a=index&amp;id=55">关于捐赠</a></p>
        <p class="footerInfo">粤ICP备12029167号 永翔公益基金会</p>
    </div>

</footer>
    \

<script src="/asserts/res/all.src.js?<?php echo (STATIC_RES_HASH); ?>"></script>
<?php echo tpx_config_get('code_counter_position',0)?tpx_config_get('code_counter',''):''; ?>


</body>
</html>