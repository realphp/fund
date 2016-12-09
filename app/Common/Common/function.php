<?php
use Org\Util\String;
use Think\Storage;

/**
 * 列出本地目录的文件
 *
 * @param string $filename
 * @param string $pattern
 * @return Array
 */
function list_file($filename, $pattern = '*')
{
    if (strpos($pattern, '|') !== false) {
        $patterns = explode('|', $pattern);
    } else {
        $patterns [0] = $pattern;
    }
    $i = 0;
    $dir = array();
    if (is_dir($filename)) {
        $filename = rtrim($filename, '/') . '/';
    }
    foreach ($patterns as $pattern) {
        $list = glob($filename . $pattern);
        if ($list !== false) {
            foreach ($list as $file) {
                $dir [$i] ['filename'] = basename($file);
                $dir [$i] ['path'] = dirname($file);
                $dir [$i] ['pathname'] = realpath($file);
                $dir [$i] ['owner'] = fileowner($file);
                $dir [$i] ['perms'] = substr(base_convert(fileperms($file), 10, 8), -4);
                $dir [$i] ['atime'] = fileatime($file);
                $dir [$i] ['ctime'] = filectime($file);
                $dir [$i] ['mtime'] = filemtime($file);
                $dir [$i] ['size'] = filesize($file);
                $dir [$i] ['type'] = filetype($file);
                $dir [$i] ['ext'] = is_file($file) ? strtolower(substr(strrchr(basename($file), '.'), 1)) : '';
                $dir [$i] ['isDir'] = is_dir($file);
                $dir [$i] ['isFile'] = is_file($file);
                $dir [$i] ['isLink'] = is_link($file);
                $dir [$i] ['isReadable'] = is_readable($file);
                $dir [$i] ['isWritable'] = is_writable($file);
                $i++;
            }
        }
    }
    $cmp_func = create_function('$a,$b', '
		if( ($a["isDir"] && $b["isDir"]) || (!$a["isDir"] && !$b["isDir"]) ){
			return  $a["filename"]>$b["filename"]?1:-1;
		}else{
			if($a["isDir"]){
				return -1;
			}else if($b["isDir"]){
				return 1;
			}
			if($a["filename"]  ==  $b["filename"])  return  0;
			return  $a["filename"]>$b["filename"]?-1:1;
		}
		');
    usort($dir, $cmp_func);
    return $dir;
}

/**
 * 删除文件夹
 *
 * @param $dir
 * @return bool
 */
function tpx_rm_dir($dir, $remove_self = true)
{
    if (is_dir($dir)) {
        $dh = opendir($dir);
        while (($file = readdir($dh)) !== false) {
            if ($file != "." && $file != "..") {
                $fullpath = rtrim($dir, '/') . '/' . $file;
                if (is_dir($fullpath)) {
                    tpx_rm_dir($fullpath, true);
                } else {
                    @unlink($fullpath);
                }
            }
        }
        closedir($dh);

        if ($remove_self) {
            @rmdir($dir);
        }
    } else {
        @unlink($dir);
    }
    return true;
}

/**
 * 复制文件夹
 * @param $src : 必须给出，不能为空
 * @param $dst : 必须给出，不能为空
 * @param $replace_ext : 如果文件存在需要添加的后缀名
 */
function tpx_copy_dir($src, $dst, $replace_ext = null)
{
    $src = rtrim($src, '/') . '/';
    $dst = rtrim($dst, '/') . '/';
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . $file)) {
                tpx_copy_dir($src . $file . '/', $dst . $file . '/', $replace_ext);
            } else {
                if (null !== $replace_ext && file_exists($dst . $file)) {
                    //echo 'bk: ' . $dst . $file . ' -> ' . $dst . $file . $replace_ext . "\n";
                    @rename($dst . $file, $dst . $file . $replace_ext);
                }
                //echo 'cp: ' . $src . $file . ' -> ' . $dst . $file . "\n";
                @copy($src . $file, $dst . $file);
            }
        }
    }
    @closedir($dir);
}

/**
 * 所有用到密码的不可逆加密方式
 *
 * @param string $password
 * @param string $password_salt
 * @return string
 */
function encrypt_password($password, $password_salt)
{
    return md5(md5($password) . md5($password_salt));
}

/**
 * 移除HTML
 *
 * @param unknown $str
 * @param string $img_text
 * @return mixed
 */
function remove_html($str, $img_text = '')
{
    $str = preg_replace('/<img([^>]+)>/i', $img_text, $str);
    $str = preg_replace('/<[^>]+>/', '', $str);
    return $str;
}

/**
 * 将byte自动转换为友好的大小显示单位
 *
 * @param number $bytes
 * @param string $unit
 * @param number $decimals
 * @return string
 */
function byte_format($bytes, $decimals = 2)
{
    $size = sprintf("%u", $bytes);
    if ($size == 0) {
        return ("0 Bytes");
    }
    $units = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $units[$i];
}

/**
 * 将文件大小转换为字节
 * @param $size_str
 */
function formated_size_to_bytes($size_str)
{
    $size_str = strtolower($size_str);
    $unit = preg_replace('/[^a-z]/', '', $size_str);
    $value = floatval(preg_replace('/[^0-9.]/', '', $size_str));

    $units = array('b' => 0, 'kb' => 1, 'mb' => 2, 'gb' => 3, 'tb' => 4, 'k' => 1, 'm' => 2, 'g' => 3, 't' => 4);
    $exponent = isset($units[$unit]) ? $units[$unit] : 0;

    return ($value * pow(1024, $exponent));
}

/**
 * 获取文件后缀
 * @param $pathname
 * @return string
 */
function file_ext($pathname)
{
    $ext = strtolower(pathinfo($pathname, PATHINFO_EXTENSION));
    return $ext;
}

/**
 * 获取一个不存在的临时文件名，
 * 不包含路径
 *
 * @param string $ext
 * @return string
 */
function upload_temp_file_get($ext = '')
{
    if ('' !== $ext) {
        $ext = '.' . $ext;
    }
    $tmpdir = upload_temp_dir_get();
    do {
        $file = time() . '_' . String::randString(4) . '_' . mt_rand(1000, 9999) . $ext;
    } while (file_exists($tmpdir . $file));
    return $file;
}

/**
 * 移除一个临时文件，只需提供文件名
 * 通常这个文件名由upload_temp_file_get返回
 *
 * @param string $file
 */
function upload_temp_file_remove($file)
{
    $tmpdir = upload_temp_dir_get();
    if (strpos($file, '/') === false) {
        file_exists($tmpdir . $file) && @unlink($tmpdir . $file);
    }
}

/**
 * 获取上传所用到的临时目录，要保证该目录可写
 *
 * @return string
 */
function upload_temp_dir_get()
{
    static $dir = null;
    if (null === $dir) {
        $dir = C('UPLOAD_TEMP_DIR');
        if (substr($dir, 0, 2) == './') {
            $dir = substr($dir, 2);
        }
    }
    return $dir;
}

/**
 * 判断一个文件路径（包括文件名）是不是位于上传临时目录
 *
 * @param string $tmpfile
 * @return boolean
 */
function is_upload_temp_file($tmpfile)
{
    $reg = '/^' . preg_quote(upload_temp_dir_get(), '/') . '\\d+_[a-z]{4}_\\d+\\.[a-z0-9]+$/i';
    return preg_match($reg, $tmpfile) && file_exists($tmpfile);
}

/**
 * 将一个位于上传临时文件中的文件转存到Storage中
 * 返回转存后的文件路径
 *
 * @param string $dir
 * @param string $tmpfile
 * @return string
 */
function upload_tempfile_save_storage($dir = 'subfd', $tmpfile = '')
{
    $newfile = '';
    if (is_upload_temp_file($tmpfile)) {
        $ext = strtolower(pathinfo($tmpfile, PATHINFO_EXTENSION));
        do {
            $newfile = date('Ym/d/') . (time() % 86400) . '_' . String::randString(4) . '_' . mt_rand(1000, 9999) . '.' . $ext;
        } while (Storage::has('data/' . $dir . '/' . $newfile));
        $file_content = file_get_contents($tmpfile);
        $file_size = filesize($tmpfile);
        Storage::put('data/' . $dir . '/' . $newfile, $file_content);
        @unlink($tmpfile);
        $m = D('DataFiles');
        $m->create(array(
            'uptime' => time(),
            'filesize' => $file_size,
            'dir' => $dir,
            'path' => $newfile
        ));
        $m->add();
    }
    return $newfile;
}

/**
 * 将内容存到临时文件中，返回转存后的文件路径
 *
 * @param string $ext
 * @param string $content
 * @return string
 */
function save_tempfile_content($ext = null, $content = null)
{
    $newfile = '';
    if ($ext && $content) {
        $newfile = upload_temp_dir_get() . upload_temp_file_get($ext);
        if (!file_put_contents($newfile, $content)) {
            $newfile = '';
        }
    }
    return $newfile;
}

/**
 * 将内容存到Storage中，返回转存后的文件路径
 *
 * @param string $dir
 * @param string $ext
 * @param string $content
 * @return string
 */
function save_storage_content($dir = 'subfd', $ext = null, $content = null)
{
    $newfile = '';
    if ($ext && $content) {
        do {
            $newfile = date('Ym/d/') . (time() % 86400) . '_' . String::randString(4) . '_' . mt_rand(1000, 9999) . '.' . $ext;
        } while (Storage::has('data/' . $dir . '/' . $newfile));
        Storage::put('data/' . $dir . '/' . $newfile, $content);
        $m = D('DataFiles');
        $m->create(array(
            'uptime' => time(),
            'filesize' => strlen($content),
            'dir' => $dir,
            'path' => $newfile
        ));
        $m->add();
    }
    return $newfile;
}

/**
 * 安全删除位于Storage中的文件
 *
 * @param string $file
 */
function safe_delete_storage_file($file)
{
    $reg = '/^data\\/([a-z]+)\\/(\\d+\\/\\d+\\/[a-z0-9_]+\\.[a-z0-9]+)$/i';
    preg_match($reg, $file, $match);
    if (isset ($match [1]) && isset ($match [2])) {
        D('DataFiles')->where(array(
            'dir' => $match [1],
            'path' => $match [2]
        ))->delete();
        if (Storage::has($file)) {
            Storage::unlink($file);
        }
    }
}

/**
 * 根据dir和path查找信息
 * @param $dir
 * @param $path
 */
function query_storage_file($dir, $path)
{
    $one = D('DataFiles')->where(array(
        'dir' => $dir,
        'path' => $path
    ))->find();
    if (!empty($one)) {
        return $one;
    }
    return null;
}

/**
 * 根据文件的路径查找信息
 * @param $fullpath
 * @return mixed|null
 */
function query_storage_file_by_fullpath($fullpath)
{
    $reg = '/^data\\/([a-z]+)\\/(\\d+\\/\\d+\\/[a-z0-9_]+\\.[a-z0-9]+)$/i';
    preg_match($reg, $fullpath, $match);
    if (isset ($match [1]) && isset ($match [2])) {
        return query_storage_file($match [1], $match [2]);
    }
    return null;
}


/**
 * 强制下载
 *
 * @param string $filename
 */
function force_download_content($filename, $content)
{
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Transfer-Encoding: binary");
    header("Content-Disposition: attachment; filename=$filename");
    echo $content;
    exit ();
}

/**
 * 将未格式化的文本进行HTML格式化
 *
 * @param string $text
 * @param boolean $htmlspecialchars
 * @return string
 */
function text2html($text, $htmlspecialchars = true)
{
    if ($htmlspecialchars) {
        $text = htmlspecialchars($text);
    }
    $text = str_replace("\n", '</p><p>', $text);
    return '<p>' . $text . '</p>';
}

/**
 * 将使用text2html格式化的文本进行反HTML格式化
 *
 * @param string $text
 * @return string
 */
function html2text($str)
{
    return str_replace(array(
        '</p>',
        '<p>'
    ), array(
        "\n",
        ''
    ), $str);
}

/*
 * @param string $str @param string $start @param string $length @param string $charset
 */
function msubstr($str, $start = 0, $length = 1, $charset = "utf-8")
{
    if (function_exists("mb_substr")) {
        return mb_substr($str, $start, $length, $charset);
    } else if (function_exists('iconv_substr')) {
        return iconv_substr($str, $start, $length, $charset);
    }
    $re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re [$charset], $str, $match);
    $slice = join("", array_slice($match [0], $start, $length));
    return $slice;
}

/**
 * msstrlen
 *
 * @param string $str
 * @param string $charset
 */
function msstrlen(&$str, $charset = 'utf-8')
{
    $re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re [$charset], $str, $match);
    return count($match [0]);
}

/**
 * 解析资源文本
 *
 * @param string $content
 * @param string $res_url
 * @return string
 */
function parse_res_url($content, $prefix_data = '', $prefix_asserts = '')
{
    $content = preg_replace('/(src|href)="(data\\/.*?)"/i', '\\1="' . $prefix_data . '\\2"', $content);
    $content = preg_replace('/(src|href)="(asserts\\/.*?)"/i', '\\1="' . $prefix_asserts . '\\2"', $content);
    return $content;
}

/**
 * 获取配置，如果为空返回默认值
 * @param $name
 * @param null $default
 * @return mixed|null|string
 */
function tpx_config_get($name, $default = null)
{
    $v = tpx_config($name);
    if (!$v) {
        $v = $default;
    }
    return $v;
}

/**
 * 获取或设置配置项
 *
 * @param string $name
 * @param string $value
 */
function tpx_config($name, $value = null)
{
    if (null !== $value) {
        $m = D('Config');
        $one = $m->where(array('name' => $name))->find();
        if (empty($one)) {
            $m->add(array(
                'name' => $name,
                'val' => $value
            ));
        } else {
            $m->where(array('name' => $name))->save(array(
                'val' => $value
            ));
        }
        S('tpx/config/' . $name, null);
        return $value;
    } else {
        $value = S('tpx/config/' . $name);
        if (false === $value) {
            $d = D('Config')->where(array(
                'name' => $name
            ))->find();
            if (!empty ($d)) {
                S('tpx/config/' . $name, $d ['val']);
                return $d ['val'];
            }
        }
        return $value;
    }
}

/**
 * 对数组按照指定列进行排序
 *
 * @param array $arr
 * @param string $key
 * @param string $order
 */
function tpx_array_sort_by_key(&$arr, $key, $order = 'asc|desc')
{
    if ($order == 'desc') {
        $order = '>';
    } else {
        $order = '<';
    }
    $cmp_func = create_function('$a,$b', '
		if($a["' . $key . '"]  ==  $b["' . $key . '"])  return  0;
		return  $a["' . $key . '"]' . $order . '$b["' . $key . '"]?-1:1;
		');
    usort($arr, $cmp_func);
}

/**
 * 检测当前是否为手机访问
 *
 * @return boolean
 */
function tpx_is_mobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER ['HTTP_X_WAP_PROFILE'])) {
        return true;
    }

    // 此条摘自TPM智能切换模板引擎，适合TPM开发
    if (isset ($_SERVER ['HTTP_CLIENT']) && 'PhoneClient' == $_SERVER ['HTTP_CLIENT']) {
        return true;
    }

    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER ['HTTP_VIA'])) {
        return stristr($_SERVER ['HTTP_VIA'], 'wap') ? true : false;
    }
    // 判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER ['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER ['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER ['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER ['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER ['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER ['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER ['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

/**
 * 获取域名
 *
 * @return string
 */
function tpx_get_host()
{
    return isset ($_SERVER ['HTTP_HOST']) ? $_SERVER ['HTTP_HOST'] : '';
}

/**
 * 检测是否为爬虫
 *
 * @return boolean
 */
function tpx_is_spider()
{
    $agent = strtolower(isset ($_SERVER ['HTTP_USER_AGENT']) ? $_SERVER ['HTTP_USER_AGENT'] : '');
    if (!empty ($agent)) {
        $spiderSite = array(
            "TencentTraveler",
            "Baiduspider+",
            "BaiduGame",
            "Googlebot",
            "msnbot",
            "Sosospider+",
            "Sogou web spider",
            "ia_archiver",
            "Yahoo! Slurp",
            "YoudaoBot",
            "Yahoo Slurp",
            "MSNBot",
            "Java (Often spam bot)",
            "BaiDuSpider",
            "Voila",
            "Yandex bot",
            "BSpider",
            "twiceler",
            "Sogou Spider",
            "Speedy Spider",
            "Google AdSense",
            "Heritrix",
            "Python-urllib",
            "Alexa (IA Archiver)",
            "Ask",
            "Exabot",
            "Custo",
            "OutfoxBot/YodaoBot",
            "yacy",
            "SurveyBot",
            "legs",
            "lwp-trivial",
            "Nutch",
            "StackRambler",
            "The web archive (IA Archiver)",
            "Perl tool",
            "MJ12bot",
            "Netcraft",
            "MSIECrawler",
            "WGet tools",
            "larbin",
            "Fish search"
        );
        foreach ($spiderSite as $val) {
            $str = strtolower($val);
            if (strpos($agent, $str) !== false) {
                return true;
            }
        }
    } else {
        return false;
    }
}

/**
 * 判断是否含有某个模块
 * @param $module
 * @return bool
 */
function has_module($module)
{
    return file_exists('./app/Admin/Controller/Mod' . $module . 'Controller.class.php');
}

/**
 * 判断是否含有某个模块
 * @param $cms
 * @return bool
 */
function has_cms($cms)
{
    return file_exists('./app/Admin/Controller/Cms' . $cms . 'Controller.class.php');
}

/**
 * 自动检查并升级系统
 * 当新的补丁包更新之后需要执行自动更新
 */
function tpx_upgrade_check()
{
    if (file_exists('./_CFG/install.lock')) {
        $upgrade_lock = './_CFG/upgrade.lock';
        if (file_exists($upgrade_lock)) {
            @unlink($upgrade_lock);
            include './app/Common/Upgrade/upgrade.php';
        }
    }
}

/**
 * 获取Controller名称
 *
 * @param string $type
 */
function get_admin_controller($type = 'cms|mod|exportable|cat')
{
    static $db_tables = null;
    static $db_prefix = null;
    if (null == $db_tables) {
        $db_tables = \Think\Db::getInstance()->getTables();
        $db_prefix = C('DB_PREFIX');
    }
    $controllers = array();
    if (in_array($type, array(
        'cms',
        'mod',
        'cat',
        'exportable'
    ))) {
        foreach (list_file('app/Admin/Controller/', '*Controller.class.php') as $controler) {
            $controller_name = substr($controler ['filename'], 0, -20);
            if (!in_array($controller_name, array(
                'Admin',
                'Install',
                'Login',
                'Publish',
                'Cms',
                'Mod',
                'Cat'
            ))
            ) {
                $class = "\\Admin\\Controller\\${controller_name}Controller";

                $ins = new $class ();

                switch ($type) {
                    case 'exportable' :
                        $controllers [] = array(
                            'name' => $controller_name
                        );
                        break;
                    case 'cms' :
                        if (strpos(get_parent_class($ins), ucwords($type) . 'Controller') !== false) {

                            $total_count = '[TABLE NOT EXISTS]';
                            if (in_array($db_prefix . $ins->cms_table, $db_tables)) {
                                $one = M($ins->cms_table)->field('COUNT(*) as total')->find();
                                $total_count = $one ['total'];
                            }
                            $controllers [] = array(
                                'name' => substr($controller_name, strlen($type)),
                                'table' => $ins->cms_table,
                                'db_engine' => $ins->cms_db_engine,
                                'fields_cnt' => count($ins->cms_fields),
                                'record_cnt' => $total_count
                            );
                        }
                        break;
                    case 'mod' :
                        if (strpos(get_parent_class($ins), ucwords($type) . 'Controller') !== false) {
                            $controllers [] = array(
                                'name' => substr($controller_name, strlen($type))
                            );
                        }
                        break;
                }
            }
        }
    }
    return $controllers;
}

/**
 * 递归重组节点信息为多维数组
 *
 * @param array $node
 * @param number $pid
 */
function node_merge(&$node, $pid = 0, $id_name = 'id', $pid_name = 'pid', $child_name = '_child')
{
    $arr = array();

    foreach ($node as $v) {
        if ($v [$pid_name] == $pid) {
            $v [$child_name] = node_merge($node, $v [$id_name], $id_name, $pid_name, $child_name);
            $arr [] = $v;
        }
    }

    return $arr;
}

/**
 * 检测当前访问是否有权限
 *
 * @param string $action
 * @param string $controller
 * @param string $module
 * @param number $level
 * @return boolean
 */
function member_access_permit($action = null, $controller = null, $module = null, $level = 3)
{
    if (!defined('MEMBER_LOGINED_UID')) {
        return false;
    }
    static $access_list = null;
    if (null === $access_list) {
        C('RBAC_ROLE_TABLE', C('DB_PREFIX') . 'member_rbac_role');
        C('RBAC_USER_TABLE', C('DB_PREFIX') . 'member_rbac_role_user');
        C('RBAC_ACCESS_TABLE', C('DB_PREFIX') . 'member_rbac_access');
        C('RBAC_NODE_TABLE', C('DB_PREFIX') . 'member_rbac_node');
        $access_list = \Org\Util\Rbac::getAccessList(MEMBER_LOGINED_UID);
    }
    if (null == $module) {
        $module = MODULE_NAME;
    }
    if (null == $controller) {
        $controller = CONTROLLER_NAME;
    }
    if (null == $action) {
        $action = ACTION_NAME;
    }
    switch ($level) {
        case 1 :
            return !empty ($access_list [strtoupper($module)]);
        case 2 :
            return !empty ($access_list [strtoupper($module)] [strtoupper($controller)]);
        case 3 :
            return !empty ($access_list [strtoupper($module)] [strtoupper($controller)] [strtoupper($action)]);
    }
}

/**
 * 检测用户是否具有改权限码
 *
 * @param $code
 * @param null $uid
 * @return bool
 */
function member_has_authority($code, $uid = null)
{
    if (null === $uid) {
        if (defined('MEMBER_LOGINED_UID')) {
            $uid = MEMBER_LOGINED_UID;
        } else {
            $uid = 0;
        }
    }

    $one = D('MemberAuthority')->where(array('uid' => $uid, 'code' => $code))->find();
    return !empty($one);
}

/**
 * 设置全局配置到文件
 *
 * @param $key
 * @param $value
 */
function tpx_sys_config_set($key, $value)
{
    $file = './_CFG/config.php';
    $cfg = array();
    if (file_exists($file)) {
        $cfg = (include $file);
    }
    $item = explode('.', $key);
    switch (count($item)) {
        case 1:
            $cfg[$item[0]] = $value;
            break;
        case 1:
            $cfg[$item[0]][$item[1]] = $value;
            break;
    }
    file_put_contents('./_CFG/config.php', "<?php\nreturn " . var_export($cfg, true) . ";");
}

/**
 * 获取全局配置
 *
 * @param $key
 * @return null
 */
function tpx_sys_config_get($key)
{
    $file = './_CFG/config.php';
    $cfg = array();
    if (file_exists($file)) {
        $cfg = (include $file);
    }
    return isset($cfg[$key]) ? $cfg[$key] : null;
}

/**
 * 一些方便模板调用的函数
 */
function t_date($time)
{
    return date('Y-m-d', $time);
}

function t_datetime($time)
{
    return date('Y-m-d H:i:s', $time);
}

function t_remove_html($content)
{
    return remove_html($content);
}

function t_zh_cut($content, $length = 100)
{
    return String::msubstr($content, 0, $length);
}

function t_html($content)
{
    return htmlspecialchars($content);
}

function t_text2html($content)
{
    return text2html($content);
}