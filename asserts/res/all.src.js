require(['jquery', 'jquery.extern', 'bootstrap'], function () {
    $(function () {
        $('.box-mod-category .item img').each(function (i, o) {
            $(o).height($(o).width());
        });
        $('.box-product-list .item img').each(function (i, o) {
            $(o).height($(o).width());
        });

    });
});