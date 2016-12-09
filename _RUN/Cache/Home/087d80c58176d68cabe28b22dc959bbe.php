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
                    <h3>关于捐赠</h3>
                    <em></em>
                    <h4><a href="<?php echo U('Donate/index');?>" class="active2">我要捐赠</a></h4>
                </div>

                <div class="left-donate">
    <a href="<?php echo U('/Donate');?>" class="org-btn">我要捐款</a>
    <a href="#" class="org-btn">我要报名</a>
</div>

            </div>

            <div class="col-md-10 about-desc">
                <h2>关于捐赠</h2>
                <hr>
                <div>
                    <p class="MsoNormal">
                        <span style="line-height:2;font-family:Microsoft YaHei;font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp; 我们鼓励每个人参与壹基金的公益事业，相信每个人都有能力影响和改变现状。</span><span
                            style="font-size:14px;"><br>
</span><span style="line-height:2;font-family:Microsoft YaHei;font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp; 您可以通过以下方式一次性支持壹基金公益行动，捐赠金额由您自主选择。我们推荐您使用财付通、支付宝、银联在线、</span><span
                            style="line-height:2;font-family:Microsoft YaHei;font-size:14px;">PayPal</span><span
                            style="line-height:2;font-family:Microsoft YaHei;font-size:14px;">等即时在线支付渠道，体验便捷高效安全的捐赠方式；当然，您也可以通过银行汇款、电话捐赠、银联易办事终端、拉卡拉或办理招商银行壹基金爱心卡等方式参与我们的行动。</span><span></span> <span
                            style="font-size:14px;"><br>
</span><span style="line-height:2;font-family:Microsoft YaHei;font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp; 请相信您的行动所能带来的力量，和我们壹起践行“尽我所能，人人公益”。我们将通过每月《壹家人快讯》汇报阶段性工作成果，帮助您深入了解您的行动为他人所带来的改变。</span><span></span>
                    </p>

                </div>


                <div>
                    <p>
                        <span style="font-size:14px;"><br></span>
                        <span style="line-height:2;font-family:Microsoft YaHei;font-size:16px;color:#F39700">人民币捐款账户</span>
                        <span style="font-size:14px;"><br></span>
                        <span style="line-height:2;font-family:Microsoft YaHei;font-size:14px;">开户单位：苏州史永翔管理顾问有限公司</span>
                        <span style="font-size:14px;"><br></span>
                        <span style="line-height:2;font-family:Microsoft YaHei;font-size:14px;">银行：中国银行总行营业部</span>
                        <span style="font-size:14px;"><br></span>
                        <span style="line-height:2;font-family:Microsoft YaHei;font-size:14px;">人民币账号：755917671010888</span>
                    </p>

                </div>

            </div>
        </div>
    </div>


    <footer>
    <div class="container">
        <p class="footerBtn">
            <a href="/">首页</a>|<a
                href="<?php echo U('/About');?>">关于我们</a>|<a
                href="<?php echo U('/About/welfare');?>">公益行动</a>|<a
                href="<?php echo U('/News');?>">最新资讯</a>|<a
                href="<?php echo U('/Partner');?>">公益伙伴</a>|<a
                href="<?php echo U('/Donate');?>">关于捐赠</a></p>
        <p class="footerInfo">粤ICP备12029167号 永翔公益基金会</p>
    </div>

</footer>
    \

<script src="/asserts/res/all.src.js?<?php echo (STATIC_RES_HASH); ?>"></script>
<?php echo tpx_config_get('code_counter_position',0)?tpx_config_get('code_counter',''):''; ?>


</body>
</html>