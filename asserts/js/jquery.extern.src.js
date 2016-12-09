/*------------------------------------------
 * jquery extern
 -------------------------------------------*/
define(['jquery'], function ($) {

    Array.prototype.unique = function () {
        var a = {};
        var len = this.length;
        for (var i = 0; i < len; i++) {
            if (typeof a[this[i]] == "undefined")
                a[this[i]] = 1;
        }
        this.length = 0;
        for (var i in a)
            this[this.length] = i;
        return this;
    };

    $.extend({
        // include css files
        // $.includeCSS('system/css/jquery-ui');
        // $.includeCSS(['system/css/xxx','system/css/xxx']);
        includeCSSFiles: [],
        includeCSS: function (file, basePath) {
            var files = typeof file == "string" ? [file] : file;
            basePath = basePath ? basePath : TPX.PATH_ASSERTS + '/';
            for (var i = 0; i < files.length; i++) {

                var name = files[i].replace(/^\s|\s$/g, "");
                var fileref = document.createElement("link");
                var link = basePath + name + TPX.SUFFIX_CSS;

                var flag = true;
                for (var j = 0; j < $.includeCSSFiles.length; j++) {
                    if (link == $.includeCSSFiles[j]) {
                        flag = false;
                    }
                }
                if (flag) {
                    if ($("link[href='" + link + "']").length > 0 || $("link[href='" + link + "']").length > 0) {
                        flag = false;
                    }
                }

                if (flag) {
                    $.includeCSSFiles.push(link);
                    fileref.setAttribute("rel", "stylesheet");
                    fileref.setAttribute("type", "text/css");
                    fileref.setAttribute("href", link);
                    document.getElementsByTagName("head")[0].appendChild(fileref);
                }

            }
        },
        // include js files
        // $.includeJS('system/js/jquery-ui');
        // $.includeJS(['system/js/xxx','system/js/xxx']);
        includeJSFiles: [],
        includeJS: function (file, basePath) {
            var files = typeof file == "string" ? [file] : file;
            basePath = basePath ? basePath : TPX.PATH_ASSERTS;
            for (var i = 0; i < files.length; i++) {
                var name = files[i].replace(/^\s|\s$/g, "");
                var tag = "script";
                var attr = " language='javascript' type='text/javascript' ";
                var url = basePath + name + TPX.SUFFIX_JS;
                var link = "src='" + url + "'";

                var flag = true;
                for (var j = 0; j < $.includeJSFiles.length; j++) {
                    if (link == $.includeJSFiles[j]) {
                        flag = false;
                    }
                }
                if (flag) {
                    if ($(tag + "[src='" + url + "']").length > 0 || $(tag + "[src='" + url + "']").length > 0) {
                        flag = false;
                    }
                }

                if (flag) {
                    $.includeJSFiles.push(link);
                    $('body').append("<" + tag + attr + link + " onload='alert(1);'></" + tag + ">");
                }
            }
        },
        getRootWindow: function () {
            var w = window;
            while (w.self != w.parent) {
                w = w.parent;
            }
            return w;
        },
        urlencode: function (str) {
            var ret = "";
            str += "";
            var strSpecial = "!\"#$%&'()*+,/:;<=>?[]^`{|}~%";
            for (var i = 0; i < str.length; i++) {
                var chr = str.charAt(i);
                var c = str.charCodeAt(i).toString(16);
                if (chr == " ") {
                    ret += "+";
                } else if (strSpecial.indexOf(chr) != -1) {
                    ret += "%" + c.toString(16);
                } else {
                    ret += chr;
                }
            }
            return ret;
        },
        urldecode: function (zipStr) {
            var uzipStr = "";
            for (var i = 0; i < zipStr.length; i++) {
                var chr = zipStr.charAt(i);
                if (chr == "+") {
                    uzipStr += " ";
                } else if (chr == "%") {
                    var asc = zipStr.substring(i + 1, i + 3);
                    if (parseInt("0x" + asc) > 0x7f) {
                        uzipStr += decodeURI("%" + asc.toString() + zipStr.substring(i + 3, i + 9).toString());
                        i += 8;
                    } else {
                        uzipStr += ShengUtils.AsciiToString(parseInt("0x" + asc));
                        i += 2;
                    }
                } else {
                    uzipStr += chr;
                }
            }
            return uzipStr;
        },
        getUrlAnchor: function () {
            var url = window.location.href;
            var pos = url.indexOf('#');
            if (pos > 0) {
                url = url.substring(pos + 1);
                return url;
            }
            return '';
        },
        redirect: function (url) {
            window.location.href = url;
        },
        defaultFormCallback: function (data, custom_callback) {
            // $this->success('messages')   => {"info":"messages","status":1,"url":""}
            // $this->error('messages')     => {"info":"messages","status":0,"url":""}
            // $this->redirect('url')       => forbidden
            if (data) {
                if ('number' == (typeof data.status)) {

                    if (0 == data.status) {
                        // error
                        if (data.url) {
                            $.dialog({
                                lock: true,
                                title: ': (',
                                max: false,
                                min: false,
                                fixed: true,
                                icon: 'error.gif',
                                content: data.info,
                                close: function () {
                                    if (data.url) {
                                        if ('[reload]' == data.url) {
                                            window.location.reload();
                                        } else if ('[reload-root]' == data.url) {
                                            $.getRootWindow().location.reload();
                                        } else {
                                            $.redirect(data.url);
                                        }
                                    }
                                },
                                ok: function () {
                                    return true;
                                }
                            });
                        } else {
                            $.dialog.tips(data.info, 2, 'error.gif');
                        }

                        if ($('#auto-click-on-error').length) {
                            $('#auto-click-on-error').click();
                        }

                    } else if (1 == data.status) {
                        // success
                        if (data.info) {
                            if (data.url) {
                                $.dialog({
                                    lock: true,
                                    title: ': )',
                                    max: false,
                                    min: false,
                                    fixed: true,
                                    icon: 'success.gif',
                                    content: data.info,
                                    close: function () {
                                        if (data.url) {
                                            if ('[reload]' == data.url) {
                                                window.location.reload();
                                            } else if ('[reload-root]' == data.url) {
                                                $.getRootWindow().location.reload();
                                            } else {
                                                $.redirect(data.url);
                                            }
                                        }
                                    },
                                    ok: function () {
                                        return true;
                                    }
                                });
                            } else {
                                $.dialog.tips(data.info, 2, 'success.gif');
                            }
                        } else {
                            if (data.url) {
                                if ('[reload]' == data.url) {
                                    window.location.reload();
                                } else if ('[reload-root]' == data.url) {
                                    $.getRootWindow().location.reload();
                                } else {
                                    $.redirect(data.url);
                                }
                            }
                        }
                    }
                } else {
                    if (custom_callback) {
                        custom_callback(data);
                    } else {
                        alert("ERROR: Unrecognized data! \n==\n" + data + "\n==");
                    }
                }
            } else {
                alert('ERROR: Response Data Empty!');
            }
        },
        urlBuild: function (controller, action, params) {
            controller = controller ? controller : 'index';
            action = action ? action : 'index';
            params = params ? params : {};

            var url = [];

            url.push(TPX.PATH_ROOT);
            url.push('/');

            if (!TPX.REWRITE) {
                url.push('?s=/');
            }

            url.push(controller);
            url.push('/');
            url.push(action);
            url.push('/');

            for (var v in params) {
                url.push($.urlencode(v));
                url.push('/');
                url.push($.urlencode(params[v]));
                url.push('/');
            }

            return url.join('');
        }
    });

    // form : class [ tpx-ajaxsubmit ]

    $(function () {
        var modules = ['jquery'];
        if ($('form.tpx-ajaxsubmit').length > 0 || $('body').hasClass('tpx-use-dialog')) {
            modules.push('lhgdialog.base');
            modules.push('lhgdialog.lang');
        }
        require(modules, function () {
            // lhgdialog load condition:
            //      <body> has class tpx-use-dialog
            //      there is a ajaxsubmit form

            $('form.tpx-ajaxsubmit').unbind('submit');
            $('form.tpx-ajaxsubmit').on('submit', function (e) {


                if (e) {
                    e.preventDefault();
                }

                if (TPX.UEDITOR) {
                    for (var i = 0; i < TPX.UEDITOR.length; i++) {
                        TPX.UEDITOR[i].sync();
                    }
                }

                $('.fuelux .pillbox').each(function (i, o) {
                    var id = $(o).attr('id');
                    var pills = $('#' + id).pillbox('items');
                    var tags = [];
                    for (var i = 0; i < pills.length; i++) {
                        tags.push(pills[i].value);
                    }
                    $('input[name=' + id + ']').val(tags.join(','));
                });

                var data = $(this).serializeArray();
                var callback = null;
                if ($(this).attr('callback')) {
                    callback = eval($(this).attr('callback'));
                } else {
                    callback = $.defaultFormCallback;
                }

                var waiting = $.dialog.tips(lhgdialog_lang.LOADING, 10, 'loading.gif');
                var time = setTimeout(function () {
                    if (waiting) {
                        waiting.close();
                        waiting = null;
                    }
                    $.dialog.alert(lhgdialog_lang.TIMEOUT);
                }, 30000);
                var callback_wrap = function (data) {
                    if (waiting) {
                        waiting.close();
                        waiting = null;
                    }
                    clearTimeout(time);
                    callback(data);
                };
                if ($(this).attr("method") == "post") {
                    $.post($(this).attr("action"), data, callback_wrap);
                } else {
                    $.get($(this).attr("action"), data, callback_wrap);
                }
                return false;
            });

        });
    });

});
