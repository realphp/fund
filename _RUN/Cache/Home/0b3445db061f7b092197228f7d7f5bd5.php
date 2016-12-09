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

    <div id="box-slide">

        <?php $slides = D('Slide','Service')->all(); ?>
        <div class="container">
            <div id="box-slide-carousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php foreach($slides as $i=>&$v){ ?>
                    <li data-target="#box-slide-carousel" data-slide-to="<?php echo ($i); ?>"
                    <?php if($i == 0): ?>class="active"<?php endif; ?>
                    ></li>
                    <?php } ?>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <?php foreach($slides as $i=>&$v){ ?>
                    <div class="item <?php if( $i == 0 ): ?>active<?php endif; ?>">
                    <?php if($v['url']): ?><a href="<?php echo ($v["url"]); ?>" target="_blank"><?php endif; ?>
                    <?php if($i==0){ ?>
                    <img src="/<?php echo ($v["image"]); ?>" alt="<?php echo (htmlspecialchars($v["title"])); ?>"/>
                    <?php }else{ ?>
                    <img src="/<?php echo ($v["image"]); ?>" alt="<?php echo (htmlspecialchars($v["title"])); ?>"/>
                    <?php } ?>
                    <div class="carousel-caption">
                        <?php echo (htmlspecialchars($v["title"])); ?>
                    </div>
                    <?php if($v['url']): ?></a><?php endif; ?>
                </div>
                <?php } ?>
            </div>
            <a class="left carousel-control" href="#box-slide-carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#box-slide-carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    </div>


    <div class="container content">
        <div class="row">
            <div class="col-md-9" style="padding: 0px;">
                <div class="col-md-6" style="padding: 5px;">
                    <div class="panel">
                        <h2>新闻动态</h2>
                        <div class="newCon">
                            <div class="newCon_pic c"><a href="<?php echo U('/News/'.$news[0]['id']);?>">
                                <img src="<?php echo ($news[0]['cover']); ?>" alt="<?php echo ($news[0]['title']); ?>" title="<?php echo ($news[0]['title']); ?>"
                                     width="104" height="78"></a>
                                <div class="newCon_pic_info"><strong><a
                                        href="<?php echo U('/News/'.$news[0]['id']);?>"><?php echo ($news[0]['title']); ?></a></strong>
                                    <p><?php echo ($news[0]['description']); ?><a
                                            href="<?php echo U('/News/'.$news[0]['id']);?>">[ 详情 ]</a></p>
                                </div>
                            </div>
                            <ul class="newList" style="padding-bottom:8px;">
                                <?php if(is_array($news)): $i = 0; $__LIST__ = array_slice($news,2,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="c"><a
                                            href="<?php echo U('/News/'.$v['id']);?>"><?php echo ($vo["title"]); ?></a><span> <?php echo (date('Y-m-d',$vo["posttime"])); ?></span>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                            <div class="boxMore">
                                <a href="<?php echo U('/News');?>" class="more">浏览更多</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="padding: 5px;">
                    <div class="panel">
                        <h2>视频</h2>
                        <div class="newCon">
                                <embed src="http://yuntv.letv.com/bcloud.swf" allowFullScreen="true" quality="high" align="middle" allowScriptAccess="always" width="100%" height="200px" flashvars="uu=822b97073d&vu=6ea21e2819&auto_play=1&gpcflag=1&width=640&height=360&lang=zh_CN" type="application/x-shockwave-flash"></embed>
                                <br> <br> <br> <br>
                                <div class="boxMore">

                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3" style="padding: 5px;">
                <div class="panel">
                    <h2>相册</h2>
                    <div class="photo">
                        <a href="<?php echo U('/Album');?>"><img src="http://www.onefoundation.cn/Uploads/201604/57173ba74ce71.jpg" alt=""></a>

                    </div>
                    <div class="donate">
                        <a href="<?php echo U('/Donate');?>" class="org-btn">我要捐款</a>
                        <a href="#" class="org-btn">我要报名</a>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-md-12" style="padding: 5px;">
            <div class="panel">
                <h2>我们在行动</h2>

                <div class="boxbox">
                    <div class="picbox">
                        <ul class="piclist mainlist">
                            <?php if(is_array($articles)): foreach($articles as $key=>$v): ?><li><a href="<?php echo U('/Articles/'.$v['id']);?>" target="_blank"><img
                                        src="<?php echo ($v["cover"]); ?>" width="220"
                                        height="105"/></a></li><?php endforeach; endif; ?>

                        </ul>
                        <ul class="piclist swaplist"></ul>
                    </div>
                    <div class="og_prev"></div>
                    <div class="og_next"></div>
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


<script src="/asserts/res/all.src.js?<?php echo (STATIC_RES_HASH); ?>"></script>
<?php echo tpx_config_get('code_counter_position',0)?tpx_config_get('code_counter',''):''; ?>


    <script src="/asserts/js/jquery-2.0.0.min.js"></script>
    <script src="/asserts/js/juheweb.js"></script>

</body>
</html>