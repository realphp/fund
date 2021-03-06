<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>系统发生错误</title>
    <style type="text/css">
        ::selection{ background-color: #E13300; color: white; }
        ::moz-selection{ background-color: #E13300; color: white; }
        ::webkit-selection{ background-color: #E13300; color: white; }
        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, "微软雅黑", sans-serif;
            color: #4F5155;
        }
        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }
        h1 {
            color: #E00;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }
        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }
        #container {
            width:800px;
            margin: 10px auto;
            border: 1px solid #D0D0D0;
            -webkit-box-shadow: 0 0 8px #D0D0D0;
        }
        .content {
            margin: 15px 15px 20px 15px;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1><?php echo strip_tags($e['message']);?></h1>
        <div class="content">
            <?php if(isset($e['file'])) {?>
                <div class="info">
                    <div class="title">
                        <h3>错误位置</h3>
                    </div>
                    <div class="text">
                        <p>FILE: <?php echo $e['file'] ;?> &#12288;LINE: <?php echo $e['line'];?></p>
                    </div>
                </div>
            <?php }?>
            <?php if(isset($e['trace'])) {?>
                <div class="info">
                    <div class="title">
                        <h3>TRACE</h3>
                    </div>
                    <div class="text">
                        <p><?php echo nl2br($e['trace']);?></p>
                    </div>
                </div>
            <?php }?>
            <?php if(!isset($e['file']) && !isset($e['trace'])) {?>
                该页面不存在或者访问时出现错误，请稍后再试 :(
            <?php } ?>
            <h3>您可以尝试以下操作：</h3>
            <p>1.检查您输入的网址拼写是否正确。</p>
            <p>2.进入<a href="/">首页</a>，浏览更多精彩内容。</p>
            <p>3.使用站内搜索，查找您要的内容。</p>
        </div>
    </div>
</body>
</html>