<?php

namespace Common\Service;

use Org\Util\String;
use Think\Storage;

class MemberService
{
    private $user = null;
    public $data = array();

    public function __construct()
    {
        $this->user = D('MemberUser');
    }

    /**
     * 根据UID初始化一个用户
     *
     * @param integer $uid
     * @return boolean 返回是否初始化成功
     */
    public function init($uid)
    {
        $this->data = array();
        $this->data ['member_user'] = $this->user->find($uid);
        if (empty ($this->data ['member_user'])) {
            $this->data = array();
            return false;
        }
        return true;
    }

    /**
     * 反初始化对象
     */
    public function deinit()
    {
        $this->data = array();
    }

    /**
     * 根据绑定内容查找UID
     *
     * @param string $type
     * @param number $content
     */
    public function get_uid_by_bind($type, $content)
    {
        $r = D('MemberBind')->field('uid')->where(array(
            'type' => $type,
            'content' => $content
        ))->find();
        if (empty ($r)) {
            return 0;
        }
        return $r ['uid'];
    }

    /**
     * 注册Bind
     *
     * @param string $type
     *            ：格式 [qq|wechat|..]_[suffix]
     * @param string $content
     *            ：通常为OpenID
     * @return true | 错误信息
     */
    public function bind($type, $content)
    {
        if (empty ($this->data ['member_user'] ['uid'])) {
            return '用户没有初始化';
        }
        $m = D('MemberBind');
        $data = array(
            'uid' => $this->data ['member_user'] ['uid'],
            'type' => $type,
            'content' => $content
        );
        if ($m->where($data)->find()) {
            return '已经存在';
        }
        $m->add($data);
        return true;
    }

    /**
     * 登录，email cellphone username 只能选择一个作为登录凭证
     *
     * @param string $email
     * @param string $cellphone
     * @param string $username
     * @param string $password
     * @return true : 注册成功
     *         string : 错误信息
     */
    public function login($email = '', $cellphone = '', $username = '', $password = '', &$ret_uid = null)
    {
        $email = trim($email);
        $cellphone = trim($cellphone);
        $username = trim($username);
        if (!($email || $cellphone || $username)) {
            return '所有登录字段均为空';
        }
        if (!$password) {
            return '密码为空';
        }

        if ($email) {
            if (!preg_match('/(^[\w-.]+@[\w-]+\.[\w-.]+$)/', $email)) {
                return '邮箱格式不正确';
            }
            $where = array(
                'email' => $email
            );
        } else if ($cellphone) {
            if (!preg_match('/(^1[0-9]{10}$)/', $cellphone)) {
                return '手机格式不正确';
            }
            $where = array(
                'cellphone' => $cellphone
            );
        } else if ($username) {
            if (strpos($username, '@') !== false) {
                return '用户名格式不正确';
            }
            $where = array(
                'username' => $username
            );
        }

        $record = D('MemberUser')->field('uid,password,password_salt')->where($where)->find();
        if (empty ($record)) {
            return '登录失败:1';
        }

        if ($record ['password'] != encrypt_password($password, $record ['password_salt'])) {
            return '登录失败:2';
        }

        $ret_uid = $record ['uid'];

        D('MemberUser')->where(array(
            'uid' => $ret_uid
        ))->save(array(
            'lastlogin_time' => time(),
            'lastlogin_ip' => get_client_ip(1, true)
        ));

        return true;
    }

    /**
     * 注册，通过第三方登录
     *
     * @param string $type
     *            ：格式 [qq|wechat|..]_[suffix]
     * @param string $content
     *            ：通常为OpenID
     * @return true | 错误信息
     */
    public function register_bind($type, $content, &$ret_uid = null, $suggestion_username = null)
    {
        if (null === $suggestion_username) {
            $suggestion_username = 'AUTO';
        }

        $password = String::randString(20);
        $suffix_len = 0;
        $suggestion_username = str_replace('@', '', $suggestion_username);
        do {
            if ($suffix_len > 0) {
                $username = $suggestion_username . '_' . String::randString($suffix_len);
            } else {
                $username = $suggestion_username;
            }
            $suffix_len++;
            $msg = $this->register($email = '', $cellphone = '', $username, $password, array(
                'user' => array(
                    'member_status' => 2
                )
            ), $ret_uid);
        } while ($msg !== true);

        if ($this->init($ret_uid)) {
            if ($this->bind($type, $content)) {
                return true;
            } else {
                return 'Register bind failed [uid=' . $ret_uid . '] ! ';
            }
        } else {
            return 'Init bind registered user failed [uid=' . $ret_uid . '] ! ';
        }
    }

    /**
     * 注册，email cellphone username 可以只选择一个为注册ID
     *
     * @param string $email
     * @param string $cellphone
     * @param string $username
     * @param string $password
     * @param array $add_data
     *            注册添加的额外数据 array('user'=>array(),'profile'=>array());
     * @return true : 注册成功
     *         string : 错误信息
     */
    public function register($email = '', $cellphone = '', $username = '', $password = '', $add_data = array(), &$ret_uid = null)
    {
        $email = trim($email);
        $cellphone = trim($cellphone);
        $username = trim($username);
        if (!($email || $cellphone || $username)) {
            return '所有注册字段均为空';
        }

        if ($email) {
            $msg = $this->unique_check($email, 'email');
            if (true !== $msg) {
                return $msg;
            }
        }
        if ($cellphone) {
            $msg = $this->unique_check($cellphone, 'cellphone');
            if (true !== $msg) {
                return $msg;
            }
        }
        if ($username) {
            $msg = $this->unique_check($username, 'username');
            if (true !== $msg) {
                return $msg;
            }
        }
        if (!$password || strlen($password) < 6) {
            return '密码不合法';
        }

        $data = array();
        $data ['email'] = $email;
        $data ['cellphone'] = $cellphone;
        $data ['username'] = $username;
        $data ['password_salt'] = String::randString(10);
        $data ['password'] = encrypt_password($password, $data ['password_salt']);

        $data ['reg_ip'] = get_client_ip(1);
        $data ['reg_time'] = time();
        $data ['lastlogin_ip'] = 0;
        $data ['lastlogin_time'] = 0;

        $data ['email_status'] = 0;
        $data ['cellphone_status'] = 0;
        $data ['avatar_status'] = 0;

        $data ['member_status'] = 0;
        $data ['gid'] = 0;

        if (isset ($add_data ['user'])) {
            foreach ($add_data ['user'] as $k => $v) {
                $data [$k] = $v;
            }
        }

        $uid = $this->user->add($data);

        $data = array();
        $data ['uid'] = $uid;

        if (isset ($add_data ['profile'])) {
            foreach ($add_data ['profile'] as $k => $v) {
                $data [$k] = $v;
            }
        }

        D('MemberProfile')->add($data);

        if (has_module('MemberUpload')) {
            D('MemberUploadSpace')->add(array(
                    'uid' => $uid,
                    'space' => tpx_config_get('member_upload_space', 0))
            );
        }

        if (has_cms('MemberExtraInfo')) {
            D('MemberExtraInfo')->add(array('uid' => $uid));
        }

        $ret_uid = $uid;

        return true;
    }

    /**
     * 唯一性检查
     *
     * @param string $value
     * @param string $type
     *            = email | cellphone | username
     * @param number $ignore_uid
     *            忽略的UID
     *
     * @return true | 错误信息
     */
    public function unique_check($value, $type = 'auto', $ignore_uid = 0)
    {
        $value = trim($value);
        switch ($type) {
            case 'email' :
                if (!preg_match('/(^[\w-.]+@[\w-]+\.[\w-.]+$)/', $value)) {
                    return '邮箱格式不正确';
                }
                break;
            case 'cellphone' :
                if (!preg_match('/(^1[0-9]{10}$)/', $value)) {
                    return '手机格式不正确';
                }
                break;
            case 'username' :
                if (strpos($value, '@') !== false) {
                    return '用户名格式不正确';
                }
                break;
            default :
                return '未能识别的类型' . $type;
        }
        $record = D('MemberUser')->field('uid')->where(array(
            $type => $value
        ))->find();
        if (empty ($record)) {
            return true;
        }

        $lang = array(
            'username' => '用户名',
            'email' => '邮箱',
            'cellphone' => '手机号'
        );
        if ($record ['uid']) {
            if ($ignore_uid == $record ['uid']) {
                return true;
            }
            return $lang [$type] . '已经被占用';
        }
        return true;
    }

    /**
     * 修改当前用户密码
     *
     * @param string $old
     * @param string $new
     * @param boolean $ignore_old
     */
    public function change_password($old, $new, $ignore_old = false)
    {
        if (empty ($this->data ['member_user'] ['uid'])) {
            return '用户没有初始化';
        }
        if (!$ignore_old && encrypt_password($old, $this->data ['member_user'] ['password_salt']) != $this->data ['member_user'] ['password']) {
            return '旧密码不正确';
        }
        if (empty ($new)) {
            return '新密码为空';
        }
        $data = array();
        $data ['password_salt'] = String::randString(10);
        $data ['password'] = encrypt_password($new, $data ['password_salt']);
        $this->user->where(array(
            'uid' => $this->data ['member_user'] ['uid']
        ))->save($data);
        return true;
    }

    /**
     * 删除用户
     */
    public function delete()
    {
        if (!empty ($this->data ['member_user'] ['uid'])) {
            $this->enable_avatar(false);

            // Extra Info
            if (has_cms('MemberExtraInfo')) {
                D('MemberExtraInfo')->where(array(
                    'uid' => $this->data ['member_user'] ['uid']
                ))->delete();
            }

            // Upload
            if (has_module('MemberUpload')) {
                M('MemberUploadSpace')->where(array(
                    'uid' => $this->data ['member_user'] ['uid']
                ))->delete();
            }

            // Rbac
            if (has_module('MemberRbac')) {
                M('MemberRbacRoleUser')->where(array(
                    'user_id' => $this->data ['member_user'] ['uid']
                ))->delete();
            }

            // Authority
            if (has_module('MemberAuthority')) {
                M('MemberAuthority')->where(array(
                    'uid' => $this->data ['member_user'] ['uid']
                ))->delete();
            }

            M('MemberProfile')->where(array(
                'uid' => $this->data ['member_user'] ['uid']
            ))->delete();
            M('MemberMsg')->where(array(
                'uid' => $this->data ['member_user'] ['uid']
            ))->delete();
            M('MemberMsg')->where(array(
                'fuid' => $this->data ['member_user'] ['uid']
            ))->delete();
            M('MemberFollow')->where(array(
                'uid' => $this->data ['member_user'] ['uid']
            ))->delete();
            M('MemberFollow')->where(array(
                'fuid' => $this->data ['member_user'] ['uid']
            ))->delete();
            M('MemberBind')->where(array(
                'uid' => $this->data ['member_user'] ['uid']
            ))->delete();
            M('MemberUser')->where(array(
                'uid' => $this->data ['member_user'] ['uid']
            ))->delete();
            return true;
        }
        return false;
    }

    /**
     * 设置当前用户的头像
     *
     * @param file_path $file
     */
    public function set_avatar($file)
    {
        // 由于临时文件在本次存储，故可以使用file_exists
        if (!empty ($this->data ['member_user'] ['uid'])) {
            if (file_exists($file)) {
                $uids = sprintf("%09d", abs(intval($this->data ['member_user'] ['uid'])));
                import('Common/Extends/Image');
                $tmp_file = upload_temp_dir_get() . upload_temp_file_get('jpg');

                $avatar_file = 'data/member/avatar/' . substr($uids, 0, 3) . '/' . substr($uids, 3, 2) . '/' . substr($uids, 5, 2) . '/' . substr($uids, -2);

                \Image::image_thumb($file, $tmp_file, $maxWidth = 200, $maxHeight = 200, $savetype = 'jpg', $waterMark = false);
                Storage::put($avatar_file . "_b.jpg", file_get_contents($tmp_file));

                \Image::image_thumb($file, $tmp_file, $maxWidth = 100, $maxHeight = 100, $savetype = 'jpg', $waterMark = false);
                Storage::put($avatar_file . "_m.jpg", file_get_contents($tmp_file));

                \Image::image_thumb($file, $tmp_file, $maxWidth = 50, $maxHeight = 50, $savetype = 'jpg', $waterMark = false);
                Storage::put($avatar_file . "_s.jpg", file_get_contents($tmp_file));

                @unlink($tmp_file);

                $this->data ['member_user'] ['avatar_status'] = 1;

                $this->enable_avatar(true);
            }
        }
    }

    /**
     * 设置头像 false则会尝试删除
     *
     * @param boolean $enable
     * @return boolean
     */
    public function enable_avatar($enable = true)
    {
        if (!empty ($this->data ['member_user'] ['uid'])) {
            $data = array();
            if ($enable) {
                $data ['avatar_status'] = 1;
            } else {
                $uids = sprintf("%09d", abs(intval($this->data ['member_user'] ['uid'])));
                foreach (array(
                             'b',
                             'm',
                             's'
                         ) as $size) {
                    $avatar_file = 'data/member/avatar/' . substr($uids, 0, 3) . '/' . substr($uids, 3, 2) . '/' . substr($uids, 5, 2) . '/' . substr($uids, -2) . "_{$size}.jpg";
                    if (Storage::has($avatar_file)) {
                        Storage::unlink($avatar_file);
                    }
                }
                $data ['avatar_status'] = 0;
            }
            D('MemberUser')->where(array(
                'uid' => $this->data ['member_user'] ['uid']
            ))->save($data);
            return true;
        }
        return false;
    }

    /**
     * 更新用户数据
     *
     * @param string $cat
     *            user|profile
     * @param array $data
     */
    public function update($cat, $data = array())
    {
        if (!empty ($this->data ['member_user'] ['uid'])) {
            switch ($cat) {
                case 'user':
                case 'profile':
                    D('Member' . ucwords($cat))->where(array(
                        'uid' => $this->data ['member_user'] ['uid']
                    ))->save($data);
                    return true;
                    break;
                case 'upload_space':
                    if (has_module('MemberUpload')) {
                        D('Member' . ucwords($cat))->where(array(
                            'uid' => $this->data ['member_user'] ['uid']
                        ))->save($data);
                        return true;
                    }
                    break;
                case 'rbac_role':
                    if (has_module('MemberRbac')) {
                        $m = D('MemberRbacRoleUser');
                        $m->where(array(
                            'user_id' => $this->data ['member_user'] ['uid']
                        ))->delete();
                        $data_insert = array();
                        foreach ($data as $role_id) {
                            $data_insert[] = array(
                                'user_id' => $this->data ['member_user'] ['uid'],
                                'role_id' => $role_id
                            );
                        }
                        $m->addAll($data_insert);
                        return true;
                    }
                    break;
                case 'authority':
                    if (has_module('MemberAuthority')) {
                        $m = D('MemberAuthority');
                        $m->where(array(
                            'uid' => $this->data ['member_user'] ['uid']
                        ))->delete();
                        $data_insert = array();
                        foreach ($data as $code) {
                            $data_insert[] = array(
                                'uid' => $this->data ['member_user'] ['uid'],
                                'code' => $code
                            );
                        }
                        $m->addAll($data_insert);
                        return true;
                    }
                    break;
                case 'extra_info':
                    if (has_cms('MemberExtraInfo')) {
                        if (isset($data['uid'])) {
                            unset($data['uid']);
                        }
                        D('MemberExtraInfo')->where(array(
                            'uid' => $this->data ['member_user'] ['uid']
                        ))->save($data);
                    }
                    break;
            }
        }
        return false;
    }

    /**
     * 根据key获取用户信息
     *
     * @param string $key
     *            $key 可以为 category.key 的形式
     */
    public function get($key, $default = null)
    {
        if (strpos($key, '.') !== false) {
            list ($c, $k) = explode('.', $key);
            // 如果没有初始化，自动初始化
            if (!isset ($this->data ["member_$c"]) && !empty ($this->data ['member_user'] ['uid'])) {
                switch ($c) {
                    case 'bind' :
                        $d = D('MemberBind')->field('uid', true)->where(array(
                            'uid' => $this->data ['member_user'] ['uid']
                        ))->select();
                        if (empty ($d)) {
                            $this->data ["member_$c"] = array();
                        } else {
                            $this->data ["member_$c"] = $d;
                        }
                        break;
                    case 'follow' :
                        $ids = array();
                        $datas = D('MemberFollow')->field('uid', true)->where(array(
                            'uid' => $this->data ['member_user'] ['uid']
                        ))->select();
                        if (is_array($datas)) {
                            foreach ($datas as &$r) {
                                $ids [] = $r ['fuid'];
                            }
                        }
                        $this->data ["member_$c"] ['follow_uids'] = $ids;

                        $ids = array();
                        $datas = D('MemberFollow')->field('fuid', true)->where(array(
                            'fuid' => $this->data ['member_user'] ['uid']
                        ))->select();
                        if (is_array($datas)) {
                            foreach ($datas as &$r) {
                                $ids [] = $r ['uid'];
                            }
                        }
                        $this->data ["member_$c"] ['be_followed_uids'] = $ids;
                        break;
                    case 'msg' :

                        $d = D('MemberMsg')->field('uid', true)->where(array(
                            'uid' => $this->data ['member_user'] ['uid']
                        ))->select();
                        if (empty ($d)) {
                            $this->data ["member_$c"] ['inbox'] = array();
                        } else {
                            $this->data ["member_$c"] ['inbox'] = $d;
                        }

                        $d = D('MemberMsg')->field('fuid', true)->where(array(
                            'fuid' => $this->data ['member_user'] ['uid']
                        ))->select();
                        if (empty ($d)) {
                            $this->data ["member_$c"] ['sentbox'] = array();
                        } else {
                            $this->data ["member_$c"] ['sentbox'] = $d;
                        }

                        break;
                    case 'profile' :
                        $d = D('MemberProfile')->field('uid', true)->where(array(
                            'uid' => $this->data ['member_user'] ['uid']
                        ))->find();
                        if (empty ($d)) {
                            $this->data ["member_$c"] = array();
                        } else {
                            $this->data ["member_$c"] = $d;
                        }
                        break;
                    case 'upload_space':
                        if (has_module('MemberUpload')) {
                            $d = D('MemberUploadSpace')->field('uid', true)->where(array(
                                'uid' => $this->data ['member_user'] ['uid']
                            ))->find();
                            if (empty ($d)) {
                                $this->data ["member_$c"] = array();
                            } else {
                                $this->data ["member_$c"] = $d;
                            }
                        } else {
                            $this->data ["member_$c"] = array();
                        }
                        break;
                    case 'rbac_role':
                        $this->data ["member_$c"] = array();
                        if (has_module('MemberRbac')) {
                            $d = D('MemberRbacRoleUser')->table('__MEMBER_RBAC_ROLE_USER__ mrru')->field('mrru.role_id,mrr.name')
                                ->join('__MEMBER_RBAC_ROLE__ mrr ON mrru.role_id=mrr.id')
                                ->where(array(
                                    'mrru.user_id' => $this->data ['member_user'] ['uid']
                                ))->select();
                            if (!empty ($d)) {
                                foreach ($d as &$r) {
                                    $this->data ["member_$c"] [$r['role_id']] = $r['name'];
                                }
                            }
                        }
                        break;
                    case 'authority':
                        $this->data ["member_$c"] = array();
                        if (has_module('MemberAuthority')) {
                            $d = D('MemberAuthority')->where(array(
                                'uid' => $this->data ['member_user'] ['uid']
                            ))->select();
                            if (!empty ($d)) {
                                foreach ($d as &$r) {
                                    $this->data ["member_$c"] [] = $r['code'];
                                }
                            }
                        }
                        break;
                    case 'extra_info':
                        $this->data ["member_$c"] = array();
                        if (has_cms('MemberExtraInfo')) {
                            $one = D('MemberExtraInfo')->where(array(
                                'uid' => $this->data ['member_user'] ['uid']
                            ))->find();
                            if (!empty($one)) {
                                if (isset($one['uid'])) {
                                    unset($one['uid']);
                                }
                                $this->data ["member_$c"] = $one;
                            }
                        }
                        break;

                }
            }
            if (empty ($k)) {
                return $this->data ["member_$c"];
            }
            if (isset ($this->data ["member_$c"] [$k])) {
                return $this->data ["member_$c"] [$k];
            }
        }
        return $default;
    }

    /**
     * 根据UID给出头像数据
     *
     * @param number $uid
     *            uid为0传回空头像
     *            uid为-1传回当前用户头像
     * @param string $size
     * @return string
     */
    public function get_avatar_url($uid = 0, $size = 's')
    {
        if (-1 == $uid) {
            $uid = $this->get('user.uid');
            if (!$this->get('user.avatar_status')) {
                $uid = 0;
            }
        }
        if ($uid) {
            $uids = sprintf("%09d", abs(intval($uid)));
            return C('TMPL_PARSE_STRING.__DATA__') . '/member/avatar/' . substr($uids, 0, 3) . '/' . substr($uids, 3, 2) . '/' . substr($uids, 5, 2) . '/' . substr($uids, -2) . "_{$size}.jpg";
        }
        return C('TMPL_PARSE_STRING.__ASSERTS__') . '/m/member/noavatar_' . $size . '.jpg';
    }

    /**
     * 添加用户操作日志
     *
     * @param $msg
     */
    public function add_log($msg)
    {
        if (has_cms('MemberLog') && !empty ($this->data ['member_user'] ['uid'])) {
            $data = array(
                'uid' => $this->data ['member_user'] ['uid'],
                'operation' => $msg,
                'add_time' => time()
            );
            D('CmsMemberLog')->add($data);
        }
    }


}