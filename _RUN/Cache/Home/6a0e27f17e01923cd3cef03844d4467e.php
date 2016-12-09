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
                        <li><a href="#">首页</a></li>
                        <li><a href="<?php echo U('/About/index');?>">关于我们</a></li>
                        <li><a href="#">公益行动</a></li>
                        <li><a href="#">最新资讯</a></li>
                        <li><a href="#">公益伙伴</a></li>
                        <li><a href="#">关于捐赠</a></li>
                    </ul>
                </div>
            </div><!-- /.container-fluid -->
        </nav>
    </div>

</header>


    <div class="container">
        <div class="row">
            <div class="col-md-3">

                <div class="box-mod-list">
                    <h2>
                        产品分类
                    </h2>

                    <div class="list">
                        <?php foreach(D('Product','Service')->catlist() as $v){ ?>
                        <div class="item item-block">
                            <a href="<?php echo U('/Product/page?cat='.$v['id']);?>"><?php echo (htmlspecialchars($v["catname"])); ?></a>
                        </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
            <div class="col-md-9">


                <div class="box-product-list">
                    <h1>
                        <?php if($cat_data): ?><a href="<?php echo U('/Product');?>">全部产品</a> &gt; <?php echo ($data_title); ?>
                        <?php else: ?>
                            全部产品<?php endif; ?>
                    </h1>
                    <div class="main">
                        <div class="row">
                            <?php if(is_array($data_list)): foreach($data_list as $key=>$v): ?><div class="col-md-3 col-xs-6">
                                    <div class="item">
                                        <a class="cover" href="<?php echo U('/Product/'.$v['id']);?>">
                                            <img src="/<?php echo ($v["cover"]); ?>" alt="<?php echo (htmlspecialchars($v["title"])); ?>" />
                                        </a>
                                        <a class="title" href="<?php echo U('/Product/'.$v['id']);?>"><?php echo (htmlspecialchars($v["title"])); ?></a>
                                    </div>
                                </div><?php endforeach; endif; ?>
                        </div>
                    </div>
                    <div class="page-bar">
                        <?php echo ($data_page); ?>
                    </div>
                </div>


            </div>


        </div>

    </div>


    <footer>
    <div class="container">
        <div>
            公司地址：<?php echo tpx_config_get('contact_address','[公司地址]'); ?>
        </div>
        <div class="copyright">
            <?php echo tpx_config_get('basic_copyright','&copy; Co.MZ企业系统 2015 All Rights Reserved. <a href="http://www.tecmz.com" target="_blank">Powered by Co.MZ</a>'); ?>
        </div>
    </div>
</footer>



<script src="/asserts/res/all.src.js?<?php echo (STATIC_RES_HASH); ?>"></script>
<?php echo tpx_config_get('code_counter_position',0)?tpx_config_get('code_counter',''):''; ?>


</body>
</html>