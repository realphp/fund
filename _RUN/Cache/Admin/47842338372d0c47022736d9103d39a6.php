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
            

    <table id="table-grid" class="table table-hover">
        <thead>
        <tr>
            <?php if(is_array($fields)): foreach($fields as $k=>$v): if($v): if(strpos($v['rules'],'searchable')!==false): ?><th data-column-id="<?php echo ($k); ?>" data-sortable="true">
                            <?php echo ($v["title"]); ?>
                        </th>
                        <?php else: ?>
                        <th data-column-id="<?php echo ($k); ?>" data-sortable="false">
                            <?php echo ($v["title"]); ?>
                        </th><?php endif; ?>
                    <?php else: ?>
                    <th data-column-id="<?php echo ($k); ?>" data-order="desc" data-type="numeric" data-identifier="true">
                        <?php echo (strtoupper($k)); ?>
                    </th><?php endif; endforeach; endif; ?>
            <?php if(access_permit('cmshandle')): ?><th data-column-id="commands" data-formatter="commands" data-sortable="false"><?php echo (L("operation")); ?></th><?php endif; ?>
        </tr>
        </thead>
    </table>

    <script type="text/html" id="table-grid-buttons">
        <div class="btn-group">
            <?php if(access_permit('cmshandle')): if($cfg_addable): ?><a href="#" data-href="<?php echo U(CONTROLLER_NAME.'/cmshandle?action=add&page=-page-');?>" class="btn btn-default btn-xs command-add"><span class="glyphicon glyphicon-plus"></span><?php echo (L("add")); ?></a><?php endif; ?>
                <?php if($cfg_deletable): ?><a href="#" data-href="<?php echo U(CONTROLLER_NAME.'/cmshandle?action=delete&page=-page-');?>" class="btn btn-default btn-xs command-delete-all"><span class="glyphicon glyphicon-trash"></span><?php echo (L("delete")); ?></a><?php endif; endif; ?>
        </div>
    </script>

    <script type="text/html" id="table-grid-row-operation">
        <?php if(!empty($cfg_record_operation_extra_tpl)): echo ($cfg_record_operation_extra_tpl); endif; ?>
        <?php if(!$cfg_all_field_readonly): ?><a href='#' class='command-edit' title='<?php echo (L("edit")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-pencil'></span></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href='#' class='command-view' title='<?php echo (L("view")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-eye-open'></span></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href='#' class='command-delete' title='<?php echo (L("delete")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-remove'></span></a>
            <?php else: ?>
            <a href='#' class='command-edit' title='<?php echo (L("edit")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-eye-open'></span></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href='#' class='command-delete' title='<?php echo (L("delete")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-remove'></span></a><?php endif; ?>
    </script>

    <script type="text/javascript">
        require(['jquery', 'jquery.extern', 'jquery.bootgrid'],function(){
            var initialized = false;
            var buttons = $('#table-grid-buttons').html();
            var operation = $('#table-grid-row-operation').html();
            var func_delete = function( ids ) {
                $.post("<?php echo U(CONTROLLER_NAME.'/cmshandle?action=delete');?>", {ids: ids}, function (data) {
                    if (data.status && data.info && data.info == 'OK' && data.status == 1) {
                        grid.bootgrid('reload');
                    } else {
                        $.defaultFormCallback(data);
                    }
                });
            };
            var grid = $("#table-grid").bootgrid({
                ajax: true,
                selection: true,
                multiSelect: true,
                rowSelect: true,
                templates: {
                    header: '<div id="{{ctx.id}}" class="{{css.header}}"><div class="row"><div class="col-sm-12 actionBar"><p class="{{css.search}}"></p><p class="{{css.actions}}"></p><div class="pull-left">' + buttons + '</div></div></div></div>'
                },
                labels: {
                    all: "<?php echo (L("all")); ?>",
                    infos: "<?php echo (L("table_infos")); ?>",
                    loading: "<?php echo (L("loading")); ?>",
                    noResults: "<?php echo (L("no_results")); ?>",
                    refresh: "<?php echo (L("refresh")); ?>",
                    search: "<?php echo (L("search")); ?>"
                },
                url: "<?php echo U(CONTROLLER_NAME.'/cmslist');?>",
                formatters: {
                    commands: function(col, row){
                        return operation.replace(/-row-id-/g,row[this.identifier]);
                    }
                }
            });
            grid.on("loaded.rs.jquery.bootgrid", function(){

                // 编辑
                grid.find(".command-edit").on("click", function(e){
                    var url = "<?php echo U(CONTROLLER_NAME.'/cmshandle?action=edit&id=-id-&page=-page-');?>";
                    var u = window.location.href;
                    var pos = u.indexOf('#');
                    var page = 1;
                    if (pos > 0) {
                        var current = u.substring(pos + 1);
                        if (parseInt(current)) {
                            page = parseInt(current);
                        }
                    }
                    url = url.replace('-page-',page).replace('-id-', $(this).data("row-id"));
                    $.redirect(url);
                    return false;
                });
                // 查看
                grid.find(".command-view").on("click", function(e){
                    var url = "<?php echo U(CONTROLLER_NAME.'/photolist&id=-id-');?>";
                    var u = window.location.href;
                    var pos = u.indexOf('#');
                    var page = 1;
                    if (pos > 0) {
                        var current = u.substring(pos + 1);
                        if (parseInt(current)) {
                            page = parseInt(current);
                        }
                    }
                    url = url.replace('-page-',page).replace('-id-', $(this).data("row-id"));
                    $.redirect(url);
                    return false;
                });

                // 删除
                grid.find('.command-delete').on('click', function () {
                    if(confirm('<?php echo (L("delete")); ?>?')) {
                        var id = $(this).data("row-id");
                        func_delete(id);
                    }
                    return false;
                });

                // Ajax窗口打开
                grid.find('.command-dialog-page').on('click', function () {
                    var url = $(this).attr('data-href');
                    var title = $(this).attr('data-title');
                    if(!title){
                        title = '';
                    }
                    var popup_dialog = $.dialog({title:title,content: "url:" + url, width: 800,lock:true});
                    return false;
                });

                if(!initialized){
                    initialized = true;
                    // 添加
                    $('.command-add').on('click',function(){
                        var url = $(this).attr('data-href');
                        var u = window.location.href;
                        var pos = u.indexOf('#');
                        var page = 1;
                        if (pos > 0) {
                            var current = u.substring(pos + 1);
                            if (parseInt(current)) {
                                page = parseInt(current);
                            }
                        }
                        $.redirect(url.replace('-page-', page));
                        return false;
                    });
                    // 批量删除
                    $('.command-delete-all').on('click', function(){
                        var ids = [];
                        grid.find('input[name=select]:checked').each(function (i, o) {
                            var id = parseInt($(o).val());
                            if (id) {
                                ids.push(id);
                            }
                        });
                        if (ids.length) {
                            func_delete( ids.join(',') );
                        }
                        return false;

                    });
                }

            });
        });

    </script>


        </div>
    
</div>
<nav class="footer navbar navbar-inverse" role="navigation">
    <?php echo (L("admin_copyright")); ?>
</nav>
<?php }else{ ?>


    <table id="table-grid" class="table table-hover">
        <thead>
        <tr>
            <?php if(is_array($fields)): foreach($fields as $k=>$v): if($v): if(strpos($v['rules'],'searchable')!==false): ?><th data-column-id="<?php echo ($k); ?>" data-sortable="true">
                            <?php echo ($v["title"]); ?>
                        </th>
                        <?php else: ?>
                        <th data-column-id="<?php echo ($k); ?>" data-sortable="false">
                            <?php echo ($v["title"]); ?>
                        </th><?php endif; ?>
                    <?php else: ?>
                    <th data-column-id="<?php echo ($k); ?>" data-order="desc" data-type="numeric" data-identifier="true">
                        <?php echo (strtoupper($k)); ?>
                    </th><?php endif; endforeach; endif; ?>
            <?php if(access_permit('cmshandle')): ?><th data-column-id="commands" data-formatter="commands" data-sortable="false"><?php echo (L("operation")); ?></th><?php endif; ?>
        </tr>
        </thead>
    </table>

    <script type="text/html" id="table-grid-buttons">
        <div class="btn-group">
            <?php if(access_permit('cmshandle')): if($cfg_addable): ?><a href="#" data-href="<?php echo U(CONTROLLER_NAME.'/cmshandle?action=add&page=-page-');?>" class="btn btn-default btn-xs command-add"><span class="glyphicon glyphicon-plus"></span><?php echo (L("add")); ?></a><?php endif; ?>
                <?php if($cfg_deletable): ?><a href="#" data-href="<?php echo U(CONTROLLER_NAME.'/cmshandle?action=delete&page=-page-');?>" class="btn btn-default btn-xs command-delete-all"><span class="glyphicon glyphicon-trash"></span><?php echo (L("delete")); ?></a><?php endif; endif; ?>
        </div>
    </script>

    <script type="text/html" id="table-grid-row-operation">
        <?php if(!empty($cfg_record_operation_extra_tpl)): echo ($cfg_record_operation_extra_tpl); endif; ?>
        <?php if(!$cfg_all_field_readonly): ?><a href='#' class='command-edit' title='<?php echo (L("edit")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-pencil'></span></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href='#' class='command-view' title='<?php echo (L("view")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-eye-open'></span></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href='#' class='command-delete' title='<?php echo (L("delete")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-remove'></span></a>
            <?php else: ?>
            <a href='#' class='command-edit' title='<?php echo (L("edit")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-eye-open'></span></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href='#' class='command-delete' title='<?php echo (L("delete")); ?>' data-toggle="tooltip" data-placement="top" data-row-id='-row-id-'><span class='glyphicon glyphicon-remove'></span></a><?php endif; ?>
    </script>

    <script type="text/javascript">
        require(['jquery', 'jquery.extern', 'jquery.bootgrid'],function(){
            var initialized = false;
            var buttons = $('#table-grid-buttons').html();
            var operation = $('#table-grid-row-operation').html();
            var func_delete = function( ids ) {
                $.post("<?php echo U(CONTROLLER_NAME.'/cmshandle?action=delete');?>", {ids: ids}, function (data) {
                    if (data.status && data.info && data.info == 'OK' && data.status == 1) {
                        grid.bootgrid('reload');
                    } else {
                        $.defaultFormCallback(data);
                    }
                });
            };
            var grid = $("#table-grid").bootgrid({
                ajax: true,
                selection: true,
                multiSelect: true,
                rowSelect: true,
                templates: {
                    header: '<div id="{{ctx.id}}" class="{{css.header}}"><div class="row"><div class="col-sm-12 actionBar"><p class="{{css.search}}"></p><p class="{{css.actions}}"></p><div class="pull-left">' + buttons + '</div></div></div></div>'
                },
                labels: {
                    all: "<?php echo (L("all")); ?>",
                    infos: "<?php echo (L("table_infos")); ?>",
                    loading: "<?php echo (L("loading")); ?>",
                    noResults: "<?php echo (L("no_results")); ?>",
                    refresh: "<?php echo (L("refresh")); ?>",
                    search: "<?php echo (L("search")); ?>"
                },
                url: "<?php echo U(CONTROLLER_NAME.'/cmslist');?>",
                formatters: {
                    commands: function(col, row){
                        return operation.replace(/-row-id-/g,row[this.identifier]);
                    }
                }
            });
            grid.on("loaded.rs.jquery.bootgrid", function(){

                // 编辑
                grid.find(".command-edit").on("click", function(e){
                    var url = "<?php echo U(CONTROLLER_NAME.'/cmshandle?action=edit&id=-id-&page=-page-');?>";
                    var u = window.location.href;
                    var pos = u.indexOf('#');
                    var page = 1;
                    if (pos > 0) {
                        var current = u.substring(pos + 1);
                        if (parseInt(current)) {
                            page = parseInt(current);
                        }
                    }
                    url = url.replace('-page-',page).replace('-id-', $(this).data("row-id"));
                    $.redirect(url);
                    return false;
                });
                // 查看
                grid.find(".command-view").on("click", function(e){
                    var url = "<?php echo U(CONTROLLER_NAME.'/photolist&id=-id-');?>";
                    var u = window.location.href;
                    var pos = u.indexOf('#');
                    var page = 1;
                    if (pos > 0) {
                        var current = u.substring(pos + 1);
                        if (parseInt(current)) {
                            page = parseInt(current);
                        }
                    }
                    url = url.replace('-page-',page).replace('-id-', $(this).data("row-id"));
                    $.redirect(url);
                    return false;
                });

                // 删除
                grid.find('.command-delete').on('click', function () {
                    if(confirm('<?php echo (L("delete")); ?>?')) {
                        var id = $(this).data("row-id");
                        func_delete(id);
                    }
                    return false;
                });

                // Ajax窗口打开
                grid.find('.command-dialog-page').on('click', function () {
                    var url = $(this).attr('data-href');
                    var title = $(this).attr('data-title');
                    if(!title){
                        title = '';
                    }
                    var popup_dialog = $.dialog({title:title,content: "url:" + url, width: 800,lock:true});
                    return false;
                });

                if(!initialized){
                    initialized = true;
                    // 添加
                    $('.command-add').on('click',function(){
                        var url = $(this).attr('data-href');
                        var u = window.location.href;
                        var pos = u.indexOf('#');
                        var page = 1;
                        if (pos > 0) {
                            var current = u.substring(pos + 1);
                            if (parseInt(current)) {
                                page = parseInt(current);
                            }
                        }
                        $.redirect(url.replace('-page-', page));
                        return false;
                    });
                    // 批量删除
                    $('.command-delete-all').on('click', function(){
                        var ids = [];
                        grid.find('input[name=select]:checked').each(function (i, o) {
                            var id = parseInt($(o).val());
                            if (id) {
                                ids.push(id);
                            }
                        });
                        if (ids.length) {
                            func_delete( ids.join(',') );
                        }
                        return false;

                    });
                }

            });
        });

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