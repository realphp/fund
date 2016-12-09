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
            
    <button onclick="clean_file_check(this);"><?php echo (L("clean_file_check")); ?></button>
    <button id="clean_file_xs_btn" style="display:none;" onclick="clean_file_xs();">删除选中文件</button>

        </div>
        <div id="page-content">
            

    <script type="text/javascript">
    $(function(){
        $('.ids-all').on('change',function(){
            $('.ids').prop('checked', $(this).is(':checked'));
        });
    });
    function clean_file_xs(){
        var ids = [];
        $('.ids').each(function(i,o){
           if($(o).is(':checked')){
               ids.push($(o).val());
           }
        });
        if(!ids.length){
            $.dialog.alert('请选择要删除的文件');
            return;
        }
        $.post("<?php echo U('System/clean?action=file_delete_xs');?>",{ids:ids.join(',')},function(data){
            if(data.ok){
                for(var i =0; i<ids.length; i++){
                    $('.row-'+ids[i]).slideUp();
                }
            }else{
                $.dialog.alert(data.data);
            }
        });
    }
    function clean_file_x(id){
        $.post("<?php echo U('System/clean?action=file_delete_xs');?>",{ids:id},function(data){
            if(data.ok){
                $('.row-'+id).slideUp();
            }else{
                $.dialog.alert(data.data);
            }
        });
    }
    function clean_file_check(o){
        $(o).prop('disabled',true);
        var old_text = $(o).html();
        $(o).html('<?php echo (L("clean_file_checking")); ?>');
        $('#clean_file_xs_btn').hide();
        $('#table-body').html('<tr><td colspan="4" style="text-align:center;">Loading...</td></tr>');
        $.post("<?php echo U('System/clean?action=file');?>",{},function(data){
            if(data.ok){
                var tables = data.data;
                if(tables.length>0){
                    var check_x_i = 0;
                    var check_x = function(){
                        if(check_x_i<tables.length){
                            var table = tables[check_x_i++];
                            $(o).html('<?php echo (L("clean_file_check_x")); ?>'+table+'...');
                            $.post("<?php echo U('System/clean?action=file_find_res');?>",{table:table},function(data){
                                if(data.ok){
                                    setTimeout(check_x,1000);
                                }else{
                                    $.dialog.alert(data.data);
                                    $(o).html(old_text);
                                    $(o).prop('disabled',false);
                                }
                            });
                        }else{
                            $.post("<?php echo U('System/clean?action=file_filter_res');?>",{},function(data){
                                if(data.ok){
                                    if(data.data.length>0){
                                        var files = data.data;
                                        $('#table-body').html('');
                                        $('#clean_file_xs_btn').show();
                                        for(var i=0; i<files.length; ++i){
                                            $('#table-body').append(
                                                    '<tr class="row-'+files[i].id+'"> ' +
                                                            ' <td><input type="checkbox" class="ids" value="'+files[i].id+'" /> '+files[i].id+'</td> ' +
                                                            ' <td>'+files[i].uptime+'</td> ' +
                                                            ' <td>'+files[i].name+'</td> ' +
                                                            ' <td> ' +
                                                                ' <a href="/data/'+files[i].name+'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
                                                                ' <a href="javascript:void(0);" onclick="clean_file_x('+files[i].id+')"><span class="glyphicon glyphicon-remove"></span></a> ' +
                                                            ' </td> ' +
                                                    ' </tr>');
                                        }
                                    }else{
                                        $.dialog.alert('没有需要清除的文件');
                                    }
                                }else{
                                    $.dialog.alert(data.data);
                                }
                                $(o).html(old_text);
                                $(o).prop('disabled',false);
                            });
                        }
                    };
                    check_x();
                }else{
                    $(o).html(old_text);
                    $(o).prop('disabled',false);
                }
            }else{
                $.dialog.alert(data.data);
                $(o).html(old_text);
                $(o).prop('disabled',false);
            }
        });
    }
    </script>

    <table class="table table-striped">
        <thead>
        <tr>
            <th><input type="checkbox" class="ids-all" /> ID</th>
            <th><?php echo (L("uptime")); ?></th>
            <th><?php echo (L("name")); ?></th>
            <th><?php echo (L("operation")); ?></th>
        </tr>
        </thead>
        <tbody id="table-body">
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


    <script type="text/javascript">
    $(function(){
        $('.ids-all').on('change',function(){
            $('.ids').prop('checked', $(this).is(':checked'));
        });
    });
    function clean_file_xs(){
        var ids = [];
        $('.ids').each(function(i,o){
           if($(o).is(':checked')){
               ids.push($(o).val());
           }
        });
        if(!ids.length){
            $.dialog.alert('请选择要删除的文件');
            return;
        }
        $.post("<?php echo U('System/clean?action=file_delete_xs');?>",{ids:ids.join(',')},function(data){
            if(data.ok){
                for(var i =0; i<ids.length; i++){
                    $('.row-'+ids[i]).slideUp();
                }
            }else{
                $.dialog.alert(data.data);
            }
        });
    }
    function clean_file_x(id){
        $.post("<?php echo U('System/clean?action=file_delete_xs');?>",{ids:id},function(data){
            if(data.ok){
                $('.row-'+id).slideUp();
            }else{
                $.dialog.alert(data.data);
            }
        });
    }
    function clean_file_check(o){
        $(o).prop('disabled',true);
        var old_text = $(o).html();
        $(o).html('<?php echo (L("clean_file_checking")); ?>');
        $('#clean_file_xs_btn').hide();
        $('#table-body').html('<tr><td colspan="4" style="text-align:center;">Loading...</td></tr>');
        $.post("<?php echo U('System/clean?action=file');?>",{},function(data){
            if(data.ok){
                var tables = data.data;
                if(tables.length>0){
                    var check_x_i = 0;
                    var check_x = function(){
                        if(check_x_i<tables.length){
                            var table = tables[check_x_i++];
                            $(o).html('<?php echo (L("clean_file_check_x")); ?>'+table+'...');
                            $.post("<?php echo U('System/clean?action=file_find_res');?>",{table:table},function(data){
                                if(data.ok){
                                    setTimeout(check_x,1000);
                                }else{
                                    $.dialog.alert(data.data);
                                    $(o).html(old_text);
                                    $(o).prop('disabled',false);
                                }
                            });
                        }else{
                            $.post("<?php echo U('System/clean?action=file_filter_res');?>",{},function(data){
                                if(data.ok){
                                    if(data.data.length>0){
                                        var files = data.data;
                                        $('#table-body').html('');
                                        $('#clean_file_xs_btn').show();
                                        for(var i=0; i<files.length; ++i){
                                            $('#table-body').append(
                                                    '<tr class="row-'+files[i].id+'"> ' +
                                                            ' <td><input type="checkbox" class="ids" value="'+files[i].id+'" /> '+files[i].id+'</td> ' +
                                                            ' <td>'+files[i].uptime+'</td> ' +
                                                            ' <td>'+files[i].name+'</td> ' +
                                                            ' <td> ' +
                                                                ' <a href="/data/'+files[i].name+'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;' +
                                                                ' <a href="javascript:void(0);" onclick="clean_file_x('+files[i].id+')"><span class="glyphicon glyphicon-remove"></span></a> ' +
                                                            ' </td> ' +
                                                    ' </tr>');
                                        }
                                    }else{
                                        $.dialog.alert('没有需要清除的文件');
                                    }
                                }else{
                                    $.dialog.alert(data.data);
                                }
                                $(o).html(old_text);
                                $(o).prop('disabled',false);
                            });
                        }
                    };
                    check_x();
                }else{
                    $(o).html(old_text);
                    $(o).prop('disabled',false);
                }
            }else{
                $.dialog.alert(data.data);
                $(o).html(old_text);
                $(o).prop('disabled',false);
            }
        });
    }
    </script>

    <table class="table table-striped">
        <thead>
        <tr>
            <th><input type="checkbox" class="ids-all" /> ID</th>
            <th><?php echo (L("uptime")); ?></th>
            <th><?php echo (L("name")); ?></th>
            <th><?php echo (L("operation")); ?></th>
        </tr>
        </thead>
        <tbody id="table-body">
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