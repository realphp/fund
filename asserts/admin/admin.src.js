require(['jquery', 'bootstrap', 'jquery.extern', 'lhgdialog.lang', 'lhgdialog.base'], function () {
    $(function () {

        $('#frame-menu .m-1').on('click', function () {
            if (!$(this).next().is(':visible')) {
                $('#frame-menu .m-1').next().slideUp();
                $(this).next().slideDown();
            }
            return false;
        });
        $('#frame-menu .m-2').on('click', function () {
            $(this).next().slideDown();
            return false;
        });

        if ($('#btn-module-cms-list').length) {

            var func_module_set = function (enable, obj) {
                var waiting = $.dialog.tips(lhgdialog_lang.LOADING, 10, 'loading.gif');
                var name = $(obj).text();
                var url = '?s=' + TPX.PATH_ROOT + '/helper/module_enable';
                $.get(url, {module: name, enable: enable}, function (data) {
                    waiting.close();
                    $('#btn-module-cms-list').click();
                });
            };
            var func_cms_set = function (enable, obj) {
                var waiting = $.dialog.tips(lhgdialog_lang.LOADING, 10, 'loading.gif');
                var name = $(obj).text();
                var url = '?s=' + TPX.PATH_ROOT + '/helper/cms_enable';
                $.get(url, {cms: name, enable: enable}, function (data) {
                    waiting.close();
                    $('#btn-module-cms-list').click();
                });
            };
            var func_extend_set = function (enable, obj) {
                var waiting = $.dialog.tips(lhgdialog_lang.LOADING, 10, 'loading.gif');
                var name = $(obj).text();
                var url = '?s=' + TPX.PATH_ROOT + '/helper/extend_enable';
                $.get(url, {extend: name, enable: enable}, function (data) {
                    waiting.close();
                    $('#btn-module-cms-list').click();
                });
            };
            var func_framework_set = function (enable, obj) {
                var waiting = $.dialog.tips(lhgdialog_lang.LOADING, 10, 'loading.gif');
                var url = '?s=' + TPX.PATH_ROOT + '/helper/framework_enable';
                $.get(url, {enable: enable}, function (data) {
                    waiting.close();
                    $('#btn-module-cms-list').click();
                });
            };


            var func_module_cms_list = function () {
                var url = $(this).attr('data-url');
                var waiting = $.dialog.tips(lhgdialog_lang.LOADING, 10, 'loading.gif');
                $.post(url, {}, function (data) {
                    waiting.close();
                    if (!data.error) {
                        var box = $('#box-module-list');
                        box.html('');
                        for (var i = 0; i < data.modules.length; i++) {
                            var cls = 'btn-default';
                            if (data.modules[i].enable) {
                                cls = 'btn-primary';
                            }
                            box.append('<a href="#" class="btn btn-xs ' + cls + '">' + data.modules[i].name + '</a>');
                        }
                        box.children('.btn-default').on('click', function () {
                            func_module_set(1, this);
                            return false;
                        });
                        box.children('.btn-primary').on('click', function () {
                            func_module_set(0, this);
                            return false;
                        });

                        box = $('#box-cms-list');
                        box.html('');
                        for (var i = 0; i < data.cmses.length; i++) {
                            var cls = 'btn-default';
                            if (data.cmses[i].enable) {
                                cls = 'btn-primary';
                            }
                            box.append('<a href="#" class="btn btn-xs ' + cls + '">' + data.cmses[i].name + '</a>');
                        }
                        box.children('.btn-default').on('click', function () {
                            func_cms_set(1, this);
                            return false;
                        });
                        box.children('.btn-primary').on('click', function () {
                            func_cms_set(0, this);
                            return false;
                        });

                        box = $('#box-extends-list');
                        box.html('');
                        for (var i = 0; i < data['extends'].length; i++) {
                            var cls = 'btn-default';
                            if (data['extends'][i].enable) {
                                cls = 'btn-primary';
                            }
                            box.append('<a href="#" class="btn btn-xs ' + cls + '">' + data['extends'][i].name + '</a>');
                        }
                        box.children('.btn-default').on('click', function () {
                            func_extend_set(1, this);
                            return false;
                        });
                        box.children('.btn-primary').on('click', function () {
                            func_extend_set(0, this);
                            return false;
                        });


                        box = $('#box-framework');
                        box.html('');
                        var cls = 'btn-default';
                        if (data.framework) {
                            cls = 'btn-primary';
                        }
                        box.append('<a href="#" class="btn btn-xs ' + cls + '">Framework</a>');

                        box.children('.btn-default').on('click', function () {
                            func_framework_set(1, this);
                            return false;
                        });
                        box.children('.btn-primary').on('click', function () {
                            func_framework_set(0, this);
                            return false;
                        });

                    }
                });
                return false;
            };

            $('#btn-module-cms-list').on('click', func_module_cms_list);
            $('#btn-module-cms-list').click();

        }


    });


    /// 布局响应开始
    var admin_resize = function () {
        if ($('#frame-content').height() >= $(window).height()) {
            $('#frame-menu').css({
                height: $(window).height() - 55 + 'px'
            });
        } else {
            $('#frame-menu').css({
                height: $(window).height() - 91 + 'px'
            });
        }
        $('#frame-content').css({
            minHeight: $(window).height() - 91 + 'px'
        });

    };
    $(window).on('resize', admin_resize);
    admin_resize();
    /// 布局响应结束

    /// 异步弹出框开始
    $(document).on('click', '.command-dialog-page', function () {
        var url = $(this).attr('data-href');
        $.dialog({content: "url:" + url, height: $(window).height() - 50, width: 800});
        return false;
    });
    /// 异步弹出框结束

    /// 异步请求开始
    $(document).on('click', '.command-ajax-request', function () {
        var url = $(this).attr('data-href');
        var data = $(this).attr('data-data');
        var waiting = $.dialog.tips(lhgdialog_lang.LOADING, 10, 'loading.gif');
        $.post(url, data, function (data) {
            waiting.close();
            $.defaultFormCallback(data);
        });
        return false;
    });
    /// 异步请求结束


    /// 提示框开始
    $(document).on('mouseover', '[data-toggle="tooltip"]', function () {
        $(this).tooltip('show');
    });
    /// 提示框结束


    /// 升级代码开始
    var upgrade_func = function () {
        var upgrade_func_waiting = null;
        var request = function (action) {
            $.post('?s=/system/upgrade/action/' + action, {}, function (data) {
                if (data.status == 1) {
                    if (data.info == 'ok') {
                        upgrade_func_waiting && upgrade_func_waiting.close();
                        $.dialog.alert('升级完成', function () {
                            $.redirect('?s=/login/out');
                        });
                    } else {
                        upgrade_func_waiting.content(data.info);
                        setTimeout(function () {
                            request('running');
                        }, 10);
                    }
                } else {
                    upgrade_func_waiting && upgrade_func_waiting.close();
                    $.dialog.alert(data.info);
                }
            });
        };
        upgrade_func_waiting = $.dialog.tips('正在初始化', 10000000, 'loading.gif');
        request('init');
    };
    $(document).on('click', '.command-upgrade', function () {
        if (window.confirm('升级可能会覆盖您修改的模板代码，确认？')) {
            upgrade_func();
        }
        return false;
    });
    /// 升级代码结束

});

function admin_grid_delete(url) {
    var ids = [];
    grid.find('input[name=select]:checked').each(function (i, o) {
        var id = parseInt($(o).val());
        if (id) {
            ids.push(id);
        }
    });
    if (ids.length) {
        $.post(url, {ids: ids.join(',')}, function (data) {
            if (data.status && data.info && data.info == 'OK' && data.status == 1) {
                grid.bootgrid('reload');
            } else {
                $.defaultFormCallback(data);
            }
        });
    }
    return false;
}

function admin_grid_delete_one(url, id) {
    $.post(url, {ids: id}, function (data) {
        if (data.status && data.info && data.info == 'OK' && data.status == 1) {
            grid.bootgrid('reload');
        } else {
            $.defaultFormCallback(data);
        }
    });
    return false;
}