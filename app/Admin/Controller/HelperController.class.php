<?php

namespace Admin\Controller;

use \Think\Controller;

class HelperController extends Controller
{
    private static $inits = array(

        '_CFG/config.default.php',
        '_CFG/db.default.php',
        '_CFG/global.php',
        '_CFG/upgrade.lock',

        '_RUN/index.html',
        'data/index.html',
        'app/Admin/index.html',
        'app/Common/index.html',

        '_TP',
        'asserts',

        'robots.txt',

        'app/Admin/Behaviors',
        'app/Admin/Class',
        'app/Admin/Common',
        'app/Admin/Conf',
        'app/Admin/Lang',
        'app/Admin/Model',

        'app/Admin/Controller/AdminController.class.php',
        'app/Admin/Controller/AdministratorController.class.php',
        'app/Admin/Controller/CmsController.class.php',
        'app/Admin/Controller/DatabaseController.class.php',
        'app/Admin/Controller/EmptyController.class.php',
        'app/Admin/Controller/HelperController.class.php',
        'app/Admin/Controller/IndexController.class.php',
        'app/Admin/Controller/InstallController.class.php',
        'app/Admin/Controller/LoginController.class.php',
        'app/Admin/Controller/ModController.class.php',
        'app/Admin/Controller/SystemController.class.php',
        'app/Admin/Controller/index.html',

        'app/Admin/View/default/Administrator/',
        'app/Admin/View/default/Cms/',
        'app/Admin/View/default/Database',
        'app/Admin/View/default/Install/',
        'app/Admin/View/default/Login/',
        'app/Admin/View/default/Public/',
        'app/Admin/View/default/System/',
        'app/Admin/View/default/index.html',

        'app/Admin/Widget/',

        'app/Admin/Common/',

        'app/Admin/Home/',

        'app/Common/Common/',
        'app/Common/Conf/',
        'app/Common/Cron/',
        'app/Common/Custom/*.php',
        'app/Common/Extends/*.php',
        'app/Common/Font/',
        'app/Common/Service/TagPoolService.php',
        'app/Common/Service/SmsService.php',
        'app/Common/Service/CategoryService.php',
        'app/Common/Upgrade/',
        'app/Common/View/',

    );

    private static $modules = array(
        'Member' => array(
            'app/Admin/Controller/ModMemberController.class.php',
            'app/Admin/View/default/ModMember/',
            'app/Common/Service/MemberService.class.php',
        ),
        'MemberUpload' => array(
            'app/Admin/Controller/ModMemberUploadController.class.php',
            'app/Admin/View/default/ModMemberUpload/',
        ),
        'MemberRbac' => array(
            'app/Admin/Controller/ModMemberRbacController.class.php',
            'app/Admin/View/default/ModMemberRbac/',
            'app/Admin/Lang/zh-cn/modmemberrbac.php',
        ),
        'MemberAuthority' => array(
            'app/Admin/Controller/ModMemberAuthorityController.class.php',
            'app/Admin/View/default/ModMemberAuthority/',
        ),
        'Wechat' => array(
            'app/Admin/Controller/ModWechatController.class.php',
            'app/Admin/View/default/ModWechat/',
        ),
        'Article' => array(
            'app/Admin/Controller/ModArticleController.class.php',
            'app/Admin/View/default/ModArticle/',
            'app/Common/Service/ArticleService.class.php',
        ),
        'Config' => array(
            'app/Admin/Controller/ModConfigController.class.php',
            'app/Admin/View/default/ModConfig/',
        ),
        'Mail' => array(
            'app/Admin/Controller/ModMailController.class.php',
            'app/Admin/View/default/ModMail/',
            'app/Common/Service/MailService.class.php',
        ),
        'Sms' => array(
            'app/Admin/Controller/ModSmsController.class.php',
            'app/Admin/View/default/ModSms/',
            'app/Common/Service/SmsService.class.php',
            'app/Common/Extends/Sms/',
        ),
        'ChinaDistrict' => array(
            'app/Admin/Controller/ModChinaDistrictController.class.php',
            'app/Admin/View/default/ModChinaDistrict/',
            'app/Admin/Data/ModChinaDistrict/',
            'app/Common/Service/ChinaDistrictService.class.php',
        ),
        'WX' => array(
            'app/Admin/Controller/CmsWxAccountController.class.php',
            'app/Admin/Controller/ModWxModuleController.class.php',
            'app/Admin/View/default/ModWxModule/',
            'app/Admin/View/default/CmsWxAccount/',
            'app/Common/Service/WechatService.class.php',
            'app/Common/ModWxModule/',
            'app/Common/Common/wx.php',
            'app/WxModule/',
            'app/Home/Controller/WxController.class.php',
        )
    );
    private static $cmses = array(
        'Guestbook' => array(
            'app/Admin/Controller/CmsGuestbookController.class.php',
        ),
        'Partner' => array(
            'app/Admin/Controller/CmsPartnerController.class.php',
            'app/Common/Service/PartnerService.class.php',
        ),
        'SinglePage' => array(
            'app/Admin/Controller/CmsSinglePageController.class.php',
            'app/Common/Service/SinglePageService.class.php',
        ),
        'WechatServer' => array(
            'app/Admin/Controller/CmsWechatServerController.class.php',
        ),
        'MemberLog' => array(
            'app/Admin/Controller/CmsMemberLogController.class.php',
        ),
        'MemberExtraInfo' => array(
            'app/Admin/Controller/CmsMemberExtraInfoController.class.php',
        ),
    );
    private static $extends = array(
        'PHPExcel' => array(
            'app/Common/Extends/PHPExcel/',
        ),
        'tcpdf' => array(
            'app/Common/Extends/tcpdf/',
        ),
        'ThinkOauth' => array(
            'app/Common/Extends/ThinkOauth/',
        ),
    );


    private function _git($command)
    {
        if (!preg_match('/php-project-\\d+\\.com/', HTTP_HOST)) {
            return null;
        }
        $cmd = "/usr/bin/git " . $command . " 2>&1";
        return shell_exec("export DYLD_LIBRARY_PATH=/usr/lib/; $cmd");
    }

    public function framework_enable($enable = 1)
    {
        $enable = intval($enable);
        foreach (self::$inits as &$f) {
            if ($enable) {
                $this->_git('add ' . $f);
            } else {
                $this->_git('rm -rf --cached ' . $f);
            }
        }
    }

    public function module_enable($module, $enable = 1)
    {
        $enable = intval($enable);
        if (isset(self::$modules[$module])) {
            foreach (self::$modules[$module] as &$f) {
                if ($enable) {
                    $this->_git('add ' . $f);
                } else {
                    $this->_git('rm -rf --cached ' . $f);
                }
            }
        }
    }

    public function extend_enable($extend, $enable = 1)
    {
        $enable = intval($enable);
        if (isset(self::$extends[$extend])) {
            foreach (self::$extends[$extend] as &$f) {
                if ($enable) {
                    $this->_git('add ' . $f);
                } else {
                    $this->_git('rm -rf --cached ' . $f);
                }
            }
        }
    }

    public function cms_enable($cms, $enable = 1)
    {
        $enable = intval($enable);
        if (isset(self::$cmses[$cms])) {
            foreach (self::$cmses[$cms] as &$f) {
                if ($enable) {
                    echo $this->_git('add ' . $f);
                } else {
                    echo $this->_git('rm -rf --cached ' . $f);
                }
            }
        }
    }

    public function module_cms_list()
    {
        $modules = array();
        foreach (self::$modules as $m => &$f) {
            $mod = array('name' => $m, 'enable' => false);
            if ($this->_git('ls-files ' . $f[0])) {
                $mod['enable'] = true;
            }
            $modules[] = $mod;
        }
        $cmses = array();
        foreach (self::$cmses as $m => &$f) {
            $cms = array('name' => $m, 'enable' => false);
            if ($this->_git('ls-files ' . $f[0])) {
                $cms['enable'] = true;
            }
            $cmses[] = $cms;
        }
        $extends = array();
        foreach (self::$extends as $m => &$f) {
            $extend = array('name' => $m, 'enable' => false);
            if ($this->_git('ls-files ' . $f[0])) {
                $extend['enable'] = true;
            }
            $extends[] = $extend;
        }
        $framework = false;
        if ($this->_git('ls-files ' . self::$inits[0])) {
            $framework = true;
        }
        $this->ajaxReturn(array(
            'error' => 0,
            'msg' => 'OK',
            'framework' => $framework,
            'modules' => $modules,
            'cmses' => $cmses,
            'extends' => $extends
        ));
    }


    public function debug_on()
    {
        if (!file_exists($file = './_CFG/debug.lock')) {
            @file_put_contents($file, 'lock');
        }
        $this->success('操作成功', '[reload]');
    }

    public function debug_off()
    {
        if (file_exists($file = './_CFG/debug.lock')) {
            @unlink($file);
        }
        $this->success('操作成功', '[reload]');
    }

    public function reportlog()
    {

        if (!function_exists('curl_init')) {
            $this->error('不支持Curl库，不能发送');
        }
        $log_count = 0;
        $posts = array();
        foreach (list_file(LOG_PATH) as $f) {
            if ($f ['isDir']) {
                foreach (list_file($f ['pathname'] . '/', '*.log') as $ff) {
                    if ($ff ['isFile']) {
                        $log_count += 1;
                        $posts ['log_file_' . $log_count] = '@' . $ff ['pathname'];
                        $posts ['log_dir_' . $log_count] = $f['filename'];
                    }
                }
            }
        }

        $posts['app_domain'] = HTTP_HOST;
        $posts['app_name'] = APP_NAME;
        $posts['app_version'] = APP_VERSION;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://dog.tecmz.com/receive/reportlog");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response && ($response = @json_decode($response, true))) {
            if (isset($response['code']) && $response['code'] == 200 && isset($response['msg']) && 'OK' == $response['msg']) {
                $this->success($log_count . '个日志文件已经发送成功，感谢您的支持');
            }
            $this->error('发送日志失败，CODE:' . $response['code'] . '，MSG:' . $response['msg']);
        }
        $this->error('发送日志失败，远程返回数据为空');
    }

    public function packsrc()
    {
        $files = $this->_packsrc_recursion('./asserts/');
        $this->success('Compress for ' . count($files) . ' file(s)');
    }

    private function _packsrc_recursion($dir)
    {
        $returns = array();
        $ignore_file = array('jquery-2.0.0.src.js');
        foreach (list_file($dir) as $f) {
            if ($f ['isDir']) {
                $returns = array_merge($returns, $this->_packsrc_recursion($f ['pathname'] . '/'));
            } else if ($f ['isFile']) {
                if (substr($f ['filename'], -8) == '.src.css') {
                    $pack_path = substr($f ['pathname'], 0, -8) . '.css';
                    if (!file_exists($pack_path) || filemtime($pack_path) < filemtime($f ['pathname'])) {
                        $this->_pack_css($f ['pathname'], $pack_path);
                        $returns[] = $pack_path;
                    }
                } else if (substr($f ['filename'], -7) == '.src.js') {
                    $pack_path = substr($f ['pathname'], 0, -7) . '.js';
                    if (!file_exists($pack_path) || filemtime($pack_path) < filemtime($f ['pathname'])) {
                        if (in_array($f['filename'], $ignore_file)) {
                            @copy($f ['pathname'], $pack_path);
                        } else {
                            $this->_pack_js($f ['pathname'], $pack_path);
                        }
                        $returns[] = $pack_path;
                    }
                } else if (substr($f ['filename'], -3) == '.js' && substr($f ['filename'], -7) != '.src.js') {
                    // 不存在src文件
                    if (!file_exists($src_path = substr($f ['pathname'], 0, -3) . '.src.js')) {
                        @copy($f ['pathname'], $src_path);
                        $returns[] = "copy $f[pathname] -> $src_path";
                    }
                }
            }
        }
        return $returns;
    }

    private function  _pack_css($srcpath, $descpath)
    {
        $content = file_get_contents($srcpath);
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*' . '/!', '', $content);
        $content = str_replace(array(
            "\r\n",
            "\r",
            "\n",
            "\t",
            '  ',
            '    ',
            '    '
        ), '', $content);
        $content = str_replace(array(
            " 0px",
            " 0em",
            ' 0pt'
        ), ' 0', $content);
        $content = preg_replace('/ *; *' . '/', ';', $content);
        $content = preg_replace('/ *: *' . '/', ':', $content);
        $content = preg_replace('/ *\\} *' . '/', '}', $content);
        $content = preg_replace('/ *\\{ *' . '/', '{', $content);
        $content = preg_replace('/; *\\}/', '}', $content);
        file_put_contents($descpath, $content);
    }

    private function _pack_js($src, $des)
    {
        $url = 'http://tool.lu/js/ajax.html';
        import('Common.Extends.Snoopy');
        $snoopy = new \Snoopy();
        $snoopy->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)";
        $snoopy->referer = $url;

        $post = array();
        $post['operate'] = 'uglify';
        $post['code'] = file_get_contents($src);
        $t1 = microtime(true);

        if ($snoopy->submit($url, $post)) {
            $json = @json_decode($snoopy->getResults(), true);
            if (!empty($json['text'])) {
                $t2 = microtime(true);
                file_put_contents($des, $json['text']);
            }
        } else {
            $t2 = microtime(true);
        }

        $time = sprintf('%.4f', ($t2 - $t1));
        return $src . " -&gt; " . $des . " cost " . $time . ' s';
    }
}