<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>提示信息</title>
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
            color: #444;
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
            width:500px;
            min-height:200px;
            margin: 10px auto;
            border: 1px solid #D0D0D0;
            -webkit-box-shadow: 0 0 8px #D0D0D0;
        }
        .content {
            margin: 12px 15px 12px 15px;
        }
    </style>
</head>
<body>
    <div id="container">
        <?php if(isset($message)) {?>
            <h1>^_^ <?php echo($message); ?></h1>
        <?php }else{?>
            <h1>T_T <?php echo($error); ?></h1>
        <?php }?>
        <div class="content">
            页面即将 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> （剩余<b id="wait"><?php echo($waitSecond); ?></b>秒...）
        </div>
    </div>
    <script type="text/javascript">
    (function(){
    var wait = document.getElementById('wait'), href = document.getElementById('href').href;
    var interval = setInterval(function(){
        var time = --wait.innerHTML;
        if(time <= 0) {
            location.href = href;
            clearInterval(interval);
        };
    }, 1000);
    })();
    </script>
</body>
</html>