var __platform = (function () {

    var platform = {
        win: false,
        mac: false,
        xll: false,
        is_pc: false,
        is_phone: false
    };

    var p = navigator.platform;
    platform.win = p.indexOf("Win") == 0;
    platform.mac = p.indexOf("Mac") == 0;
    platform.x11 = (p == "X11") || (p.indexOf("Linux") == 0);

    if (p.indexOf("Android") > 0 || p.indexOf("iPhone") > 0 || p.indexOf("SymbianOS") > 0 || p.indexOf("Windows Phone") > 0 || p.indexOf("iPod") > 0 || p.indexOf("iPad") > 0) {
        platform.is_phone = true;
    }
    if (platform.win || platform.mac || platform.xll) {
        platform.is_pc = true;
        platform.is_phone = false;
    }
    return platform;
})();