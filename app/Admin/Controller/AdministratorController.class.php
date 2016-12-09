<?php

namespace Admin\Controller;

use Org\Util\String;

class AdministratorController extends AdminController
{
    static $export_menu = array(
        'system' => array(
            '管理人员' => array(
                'rolelist' => array(
                    'title' => '角色列表',
                    'hiddens' => array(
                        'rolehandle' => '角色管理'
                    )
                ),
                'nodelist' => array(
                    'title' => '节点列表',
                    'hiddens' => array(
                        'nodehandle' => '节点管理'
                    )
                ),
                'userlist' => array(
                    'title' => '管理员列表',
                    'hiddens' => array(
                        'userhandle' => '管理员管理'
                    )
                )
            )
        )
    );

    function userlist()
    {
        if (IS_POST) {

            $current = I('post.current', 1, 'intval');
            $rowCount = I('post.rowCount', 10, 'intval');
            $sort = I('post.sort');
            $searchPhrase = I('post.searchPhrase');

            $user = D('AdminUser');

            // pre process
            $where = array();
            if ($searchPhrase) {
                $where ['username'] = array(
                    'LIKE',
                    "%$searchPhrase%"
                );
            }
            $order = null;
            foreach ($sort as $f => $d) {
                $order = "$f $d";
            }
            if (empty ($order)) {
                $order = 'id ASC';
            }

            // get info
            $total = $user->where($where)->count();
            if ($order) {
                $user->order($order);
            }
            $data = array();
            foreach ($user->relation('roles')->where($where)->page($current, $rowCount)->select() as $v) {
                $roles = array();
                foreach ($v ['roles'] as $vv) {
                    $roles [] = $vv ['name'];
                }
                if (empty($roles)) {
                    $roles[] = '超级管理员';
                }
                $data [] = array(
                    'id' => $v ['id'],
                    'username' => $v ['username'],
                    'last_login_time' => $v ['last_login_time'] ? date('Y-m-d H:i:s', $v ['last_login_time']) : L('never_logined'),
                    'last_login_ip' => $v ['last_login_ip'] ? long2ip($v ['last_login_ip']) : L('never_logined'),
                    'roles' => join(',', $roles),
                    'status' => $v ['status']
                );
            }
            // print_r($data);
            $json = array(
                'current' => $current,
                'rowCount' => $total > $rowCount ? $rowCount : $total,
                'total' => $total,
                'rows' => $data
            );
            $this->ajaxReturn($json);
        }
        $this->display();
    }

    function userhandle($action = '', $id = 0)
    {
        $id = intval($id);
        $user = D('AdminUser');

        switch ($action) {
            case 'delete' :
                $ids = array();
                foreach (explode(',', I('post.ids', '', 'trim')) as $id) {
                    $id = intval($id);
                    if ($id > 1) {
                        $ids [] = $id;
                    }
                }
                $user->delete(join(',', $ids));
                $this->success('OK');
                break;
            case 'add' :
                if (IS_POST) {

                    $username = I('post.username', '', 'trim');
                    $password = I('post.password');
                    $status = I('post.status', '', 'intval');
                    if (($user_id = $user->m_add($username, $password, $status)) > 0) {

                        $roleids = array();
                        foreach (I('post.roleids', array()) as $role_id) {
                            $roleids [] = array(
                                'role_id' => $role_id,
                                'user_id' => $user_id
                            );
                        }
                        $role_user = D('AdminRoleUser');
                        $role_user->where(array(
                            'user_id' => $user_id
                        ))->delete();

                        if (empty ($roleids) || $role_user->addAll($roleids)) {
                            $this->success('', U('Administrator/userlist'));
                        } else {
                            $this->error($role_user->getError());
                        }
                    } else {
                        $this->error($user->getError());
                    }
                }

                $this->data_username = '';
                $this->data_password = String::randNumber(100000, 999999);
                $this->data_roleids = array();
                $this->data_rolelist = M('AdminRole')->select();
                $this->data_status = 1;

                $this->display('userhandle_add');
                break;
            case 'edit' :
                if (IS_POST) {

                    $data = array();
                    $data ['id'] = $id;
                    $data ['username'] = I('post.username', '', 'trim');
                    $data ['status'] = I('post.status', '', 'intval');

                    if ($password = I('post.password')) {
                        if (!($data_old = $user->find($id))) {
                            $this->error(L('error_request'));
                        }
                        $data ['password'] = encrypt_password($password, $data_old ['password_salt']);
                    }

                    if ($user->create($data)) {
                        $user->save();

                        $roleids = array();
                        foreach (I('post.roleids', array()) as $role_id) {
                            $roleids [] = array(
                                'role_id' => $role_id,
                                'user_id' => $id
                            );
                        }

                        $role_user = D('AdminRoleUser');
                        $role_user->where(array(
                            'user_id' => $id
                        ))->delete();

                        if (empty ($roleids) || $role_user->addAll($roleids)) {
                            $this->success('', U('Administrator/userlist'));
                        } else {
                            $this->error($role_user->getError());
                        }
                    } else {
                        $this->error($user->getError());
                    }
                }

                if (!($data = $user->find($id))) {
                    $this->error(L('error_request'));
                }

                if (1 == $id) {
                    $this->error('Founder Uneditable');
                }

                $data_roleids = array();
                foreach (D('AdminRoleUser')->where(array(
                    'user_id' => $id
                ))->select() as $r) {
                    $data_roleids [] = $r ['role_id'];
                }

                $this->data_id = $id;
                $this->data_username = $data ['username'];
                $this->data_password = '';
                $this->data_roleids = $data_roleids;
                $this->data_rolelist = D('AdminRole')->select();
                $this->data_status = $data ['status'];

                $this->display('userhandle_edit');
                break;
            default :
                $this->error(L('error_request'));
        }
    }

    function nodelist()
    {
        $node = D('AdminNode');
        $nodes = $node->order('sort asc')->select();
        if (empty($nodes)) {
            $nodes = array();
        }
        $this->nodes = node_merge($nodes);
        $this->display();
    }

    function nodehandle($action = '', $id = 0, $pid = 0)
    {
        $id = intval($id);
        $pid = intval($pid);
        $node = D('AdminNode');

        switch ($action) {
            case 'delete' :
                foreach (explode(',', I('request.ids', '', 'trim')) as $_id) {
                    $_id = intval($_id);
                    if ($_id) {
                        $node->where('pid=%d', $_id)->delete();
                    }
                    $node->delete($_id);
                }
                $this->redirect('Administrator/nodelist');
                break;

            case 'add' :
                if (IS_POST) {

                    $data = array();
                    $data ['name'] = I('post.name', '', 'trim');
                    $data ['title'] = I('post.title', '', 'trim');
                    $data ['status'] = I('post.status', '', 'intval');
                    $data ['sort'] = I('post.sort', '', 'intval');
                    $data ['pid'] = I('post.pid', '', 'intval');

                    if ($data ['pid'] != 1) {
                        $data ['level'] = 3;
                        if (!($parent = $node->find($data ['pid']))) {
                            $this->error('PID not exists!');
                        }
                        $class = 'Admin\\Controller\\' . $parent ['name'] . 'Controller';
                        if (!method_exists($class, $data ['name'])) {
                            $this->error(L('controller_method_not_exists'));
                        }
                    } else {
                        $data ['level'] = 2;
                        $class = 'Admin\\Controller\\' . $data ['name'] . 'Controller';
                        if (!class_exists($class)) {
                            $this->error(L('controller_not_exists'));
                        }
                    }

                    $d = $node->where(array(
                        'pid' => $data ['pid'],
                        'name' => $data ['name']
                    ))->find();
                    if ($d) {
                        $this->error(L('controller_method_exists'));
                    }

                    if ($node->create($data) && $node->add()) {
                        $this->success('', U('Administrator/nodelist?pid=' . $data ['pid']));
                    } else {
                        $this->error($node->getError());
                    }
                }

                $this->data_name = '';
                $this->data_title = '';
                $this->data_status = 1;
                $this->data_sort = 100;
                $this->data_pid = $pid;

                $this->display('nodehandle_add');
                break;
            case 'edit' :
                if (IS_POST) {

                    $data = array();
                    $data ['id'] = $id;
                    $data ['name'] = I('post.name', '', 'trim');
                    $data ['title'] = I('post.title', '', 'trim');
                    $data ['status'] = I('post.status', '', 'intval');
                    $data ['sort'] = I('post.sort', '', 'intval');
                    $data ['pid'] = I('post.pid', '', 'intval');

                    if ($data ['pid'] != 1) {
                        $data ['level'] = 3;
                        if (!($parent = $node->find($data ['pid']))) {
                            $this->error('PID not exists!');
                        }
                        $class = 'Admin\\Controller\\' . $parent ['name'] . 'Controller';
                        if (!method_exists($class, $data ['name'])) {
                            $this->error(L('controller_method_not_exists'));
                        }
                    } else {
                        $data ['level'] = 2;
                        $class = 'Admin\\Controller\\' . $data ['name'] . 'Controller';
                        if (!class_exists($class)) {
                            $this->error(L('controller_not_exists'));
                        }
                    }

                    $d = $node->where(array(
                        'pid' => $data ['pid'],
                        'name' => $data ['name']
                    ))->find();
                    if ($d && $d ['id'] != $data ['id']) {
                        $this->error(L('controller_method_exists'));
                    }

                    if ($node->create($data)) {
                        $node->save();
                        $this->success('', U('Administrator/nodelist?pid=' . $data ['pid']));
                    } else {
                        $this->error($node->getError());
                    }
                }
                if (!($data = $node->find($id))) {
                    $this->error(L('error_request'));
                }

                $this->data_id = $id;
                $this->data_name = $data ['name'];
                $this->data_title = $data ['title'];
                $this->data_status = $data ['status'];
                $this->data_sort = $data ['sort'];
                $this->data_pid = $data ['pid'];

                $this->display('nodehandle_edit');
                break;

            default :
                $this->error(L('error_request'));
        }
    }

    function rolelist()
    {
        if (IS_POST) {

            $current = I('post.current', 1, 'intval');
            $rowCount = I('post.rowCount', 10, 'intval');
            $sort = I('post.sort');
            $searchPhrase = I('post.searchPhrase');

            $role = M('AdminRole');

            // pre process
            $where = array();
            if ($searchPhrase) {
                $where ['name'] = array(
                    'LIKE',
                    "%$searchPhrase%"
                );
                $where ['remark'] = array(
                    'LIKE',
                    "%$searchPhrase%"
                );
                $where ['_logic'] = 'OR';
            }
            $order = null;
            foreach ($sort as $f => $d) {
                $order = "$f $d";
            }

            if (empty ($order)) {
                $order = 'id ASC';
            }

            // get info
            $total = $role->where($where)->count();
            if ($order) {
                $role->order($order);
            }
            $this->data = $role->where($where)->page($current, $rowCount)->select();

            $json = array(
                'current' => $current,
                'rowCount' => $total > $rowCount ? $rowCount : $total,
                'total' => $total,
                'rows' => $this->data
            );
            $this->ajaxReturn($json);
        }
        $this->display();
    }

    function rolehandle($action = '', $id = 0)
    {
        $id = intval($id);
        $role = D('AdminRole');

        switch ($action) {
            case 'delete' :
                $role->delete(I('post.ids', '', 'trim'));
                $this->success('OK');
                break;
            case 'add' :
                if (IS_POST) {
                    $data = array();
                    $data ['name'] = I('post.name', '', 'trim');
                    $data ['status'] = I('post.status', '', 'intval');

                    if ($role->create($data) && ($roleid = $role->add())) {

                        $nodeids = array();
                        $nodeids [] = array(
                            'role_id' => $roleid,
                            'node_id' => 1,
                            'level' => 1
                        );
                        foreach (I('post.nodeids', array()) as $n) {
                            list ($nid, $nlevel) = explode('-', $n);
                            if ($nid && $nlevel) {
                                $nodeids [] = array(
                                    'role_id' => $roleid,
                                    'node_id' => $nid,
                                    'level' => $nlevel
                                );
                            }
                        }

                        $access = D('AdminAccess');
                        $access->where(array(
                            'role_id' => $roleid
                        ))->delete();

                        if (empty ($nodeids) || $access->addAll($nodeids)) {
                            $this->success('', U('Administrator/rolelist'));
                        } else {
                            $this->error($access->getError());
                        }
                    } else {
                        $this->error($role->getError());
                    }
                }

                $nodes = M('AdminNode')->order('sort asc')->select();

                $this->data_name = '';
                $this->data_status = 1;
                $this->data_remark = '';
                $this->data_nodes = node_merge($nodes);
                $this->data_accesses = array();

                $this->display('rolehandle_add');
                break;
            case 'edit' :
                if (IS_POST) {
                    $data = array();
                    $data ['id'] = $id;
                    $data ['name'] = I('post.name', '', 'trim');
                    $data ['status'] = I('post.status', '', 'intval');
                    $data ['remark'] = I('post.remark', '', 'trim');
                    if ($role->create($data)) {
                        $role->save();

                        $nodeids = array();
                        $nodeids [] = array(
                            'role_id' => $id,
                            'node_id' => 1,
                            'level' => 1
                        );
                        foreach (I('post.nodeids', array()) as $n) {
                            list ($nid, $nlevel) = explode('-', $n);
                            if ($nid && $nlevel) {
                                $nodeids [] = array(
                                    'role_id' => $id,
                                    'node_id' => $nid,
                                    'level' => $nlevel
                                );
                            }
                        }

                        $access = D('AdminAccess');
                        $access->where(array(
                            'role_id' => $id
                        ))->delete();

                        if (empty ($nodeids) || $access->addAll($nodeids)) {
                            $this->success('', U('Administrator/rolelist'));
                        } else {
                            $this->error($access->getError());
                        }
                    } else {
                        $this->error($role->getError());
                    }
                }

                if (!($data = $role->find($id))) {
                    $this->error(L('error_request'));
                }

                $nodes = M('AdminNode')->order('sort asc')->select();
                $accesses = array();
                $accesses_db = M('AdminAccess')->where(array(
                    'role_id' => $id
                ))->select();
                if (is_array($accesses_db)) {
                    foreach ($accesses_db as &$a) {
                        $accesses [] = $a ['node_id'];
                    }
                }

                $this->data_id = $id;
                $this->data_name = $data ['name'];
                $this->data_status = $data ['status'];
                $this->data_remark = $data ['remark'];
                $this->data_nodes = node_merge($nodes);
                $this->data_accesses = $accesses;

                $this->display('rolehandle_edit');
                break;
            default :
                $this->error(L('error_request'));
        }
    }
}
