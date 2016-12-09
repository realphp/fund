<?php
use Org\Util\Rbac;

/**
 * 检测当前访问是否有权限
 *
 * @param string $action
 * @param string $controller
 * @param string $module
 * @param number $level
 * @return boolean
 */
function access_permit($action = null, $controller = null, $module = null, $level = 3)
{
    if (!defined('ADMIN_UID')) {
        return false;
    }
    static $access_list = null;
    if (null === $access_list) {
        C('RBAC_ROLE_TABLE', C('DB_PREFIX') . 'admin_role');
        C('RBAC_USER_TABLE', C('DB_PREFIX') . 'admin_role_user');
        C('RBAC_ACCESS_TABLE', C('DB_PREFIX') . 'admin_access');
        C('RBAC_NODE_TABLE', C('DB_PREFIX') . 'admin_node');
        $access_list = Rbac::getAccessList(ADMIN_UID);
    }
    if (ADMIN_UID == intval(C('ADMIN_ROOT_ID'))) {
        return true;
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
 * 当前用户是否为网站创建者
 */
function is_founder()
{
    return (ADMIN_UID == intval(C('ADMIN_ROOT_ID')));
}


