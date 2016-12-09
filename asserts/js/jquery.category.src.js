/**
 * 使用方法：
 *
 * require(['jquery.category'], function () {
        $('.dynamic-brick-category').category({
            selectClass: 'form-control input-sm',
            inputNames: 'category1 category2 category3',
            inputGlobalName: 'cat[]',
            ajaxUrl: "{:U('BrickAjax/brick_category')}",
            data: null,
            pleaseSelectText: '[全部]',
            initValue: 0,
            onSelect: function (id) {
                alert(id);
            }
        });
    });
 */

(function ($, window, document, undefined) {
    var $window = $(window);

    $.fn.category = function (options) {

        var opts = {
                // select的class名称
                selectClass: '',
                // select的name和id，多级使用空格分隔
                inputNames: '',
                // select的所有数组名称
                inputGlobalName: '',
                // ajax请求url
                ajaxUrl: '',
                // data发送到请求链接的数据
                data: null,
                // 请选择提示框
                pleaseSelectText: '[Please select]',
                // 初始化值
                initValue: 0,
                // 回调函数
                onSelect: null
            },
            $this = $(this);

        $.extend(opts, options);

        if (!opts.ajaxUrl) {
            alert('empty options : ajaxUrl');
            return;
        }

        var appendSelect = function (dataList, level) {
            var inputNames = opts.inputNames.split(' ');
            var inputName = '';
            if (inputNames.length > level) {
                inputName = inputNames[level];
            } else {
                inputName = opts.inputGlobalName;
            }
            if (dataList.length > 0) {
                var $select = $('<select data-level="' + level + '" name="' + inputName + '" id="' + inputName + '" class="' + opts.selectClass + '"></select>');
                $select.append('<option value="-1">' + opts.pleaseSelectText + '</option>');
                for (var i = 0; i < dataList.length; i++) {
                    var selected = dataList[i].selected;
                    $select.append('<option value="' + dataList[i].value + '"' + (selected ? ' selected="selected"' : '') + '>' + dataList[i].title + '</option>');
                }
                $this.append($select);
                $select.on('change', function () {
                    if (opts.onSelect) {
                        opts.onSelect($(this).val());
                    }
                    loadLevel($(this).val(), level + 1);
                });
            }
        };

        var loadLevel = function (pid, level) {
            var $removeSelects = [];
            $this.children('select').each(function (i, o) {
                var lev = parseInt($(o).attr('data-level'));
                if (lev >= level) {
                    $removeSelects.push(o);
                }
            });
            var data = opts.data;
            if (!data) {
                data = {};
            }
            data.pid = pid;

            $.post(opts.ajaxUrl, data, function (data) {
                for (var i = 0; i < $removeSelects.length; i++) {
                    $($removeSelects[i]).remove();
                }
                if (data.status) {
                    appendSelect(data.list, level);
                } else {
                    alert('error ajax data');
                }
            });
        };

        opts.initValue = parseInt(opts.initValue);
        if (opts.initValue > 0) {
            opts.data.init_value = opts.initValue;
            opts.data.pid = 0;
            $.post(opts.ajaxUrl, opts.data, function (data) {
                delete opts.data.init_value;
                if (data.status && data.list) {
                    for (var i = 0; i < data.list.length; i++) {
                        appendSelect(data.list[i], i + 1);
                    }
                } else {
                    alert('error ajax data');
                }
            });
        } else {
            loadLevel(0, 0);
        }

        return this;
    };


})(jQuery, window, document);