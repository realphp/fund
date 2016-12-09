<?php
namespace Admin\Widget;

use Think\Controller;

class FrameWidget extends Controller
{
    private function getExportMenus()
    {
        if (defined('ADMIN_EMPTY_FRAME')) {
            return;
        }
        $export_menus = array();
        foreach (get_admin_controller('exportable') as $controler) {
            $controller_name = $controler ['name'];
            $class = "\\Admin\\Controller\\${controller_name}Controller";
            if (property_exists($class, 'export_menu')) {
                $menus = $class::$export_menu;
                foreach ($menus as $tab => $tabs) {
                    if (!isset ($export_menus [$tab])) {
                        $export_menus [$tab] = array();
                    }
                    foreach ($tabs as $menu_sub => $menu_subs) {
                        if (!isset ($export_menus [$tab] [$menu_sub])) {
                            $export_menus [$tab] [$menu_sub] = array();
                        }
                        foreach ($menu_subs as $method => $title_with_hiddens) {
                            $vs = array();
                            $vs ['title'] = $title_with_hiddens ['title'];
                            $vs ['hiddens'] = array();
                            if (!empty($title_with_hiddens ['hiddens'])) {
                                foreach ($title_with_hiddens ['hiddens'] as $k => $v) {
                                    $vs ['hiddens'] [$controller_name . '/' . $k] = $v;
                                }
                            }
                            if (access_permit($method, $controller_name)) {
                                $export_menus [$tab] [$menu_sub] [$controller_name . '/' . $method] = $vs;
                            }
                        }
                    }
                }
            }
        }

        // 删除空的菜单
        foreach ($export_menus as $k => $v) {
            foreach ($export_menus [$k] as $kk => $vv) {
                if (empty ($export_menus [$k] [$kk])) {
                    unset ($export_menus [$k] [$kk]);
                }
            }
            if (empty ($export_menus [$k])) {
                unset ($export_menus [$k]);
            }
        }

        $export_menus_sorted = array();
        foreach (array(
                     'system',
                     'user',
                     'tools'
                 ) as $k) {
            if (isset ($export_menus [$k])) {
                $export_menus_sorted [$k] = $export_menus [$k];
                unset ($export_menus [$k]);
            }
        }
        foreach ($export_menus as $k => &$v) {
            $export_menus_sorted [$k] = $export_menus [$k];
        }

        return $export_menus_sorted;
    }

    private function getMenuIcon($tab)
    {
        static $menu_icons = array(
            'system' => '<span class="glyphicon glyphicon-cog"></span>',
            'tools' => '<span class="glyphicon glyphicon-wrench"></span>',
            'content' => '<span class="glyphicon glyphicon-th-list"></span>',
            'user' => '<span class="glyphicon glyphicon-user"></span>',
            'service' => '<span class="glyphicon glyphicon-globe"></span>',
            'default' => '<span class="glyphicon glyphicon-folder-open"></span>'
        );
        return isset($menu_icons[$tab]) ? $menu_icons[$tab] : $menu_icons['default'];
    }

    private function getMenuDeleted()
    {
        //需要删除的菜单 东西两处地方
        $menus_to_delete = array();
        if (!APP_DEV_MODE) {
            $menus_to_delete[] = 'System/cmslist';
            $menus_to_delete[] = 'System/modlist';
            $menus_to_delete[] = 'Administrator/nodelist';
        }
        return $menus_to_delete;
    }


    public function title()
    {
        if (defined('ADMIN_EMPTY_FRAME')) {
            return;
        }
        if (defined('ADMIN_PAGE_TITLE')) {
            $this->show(ADMIN_PAGE_TITLE);
            return;
        }

        static $current_title = null;
        if (null === $current_title) {

            $export_menus = $this->getExportMenus();
            $menus_to_delete = $this->getMenuDeleted();

            foreach ($export_menus as $tab => $tabs) {
                if ('__HOME__' == $tab) {
                    continue;
                }
                foreach ($tabs as $title_sub => $sub_menus) {
                    foreach ($sub_menus as $url => $title_with_hiddens) {
                        if (in_array($url, $menus_to_delete)) {
                            continue;
                        }
                        $found = false;
                        if ($url == CONTROLLER_NAME . '/' . ACTION_NAME) {
                            $current_title = $title_sub . ' &gt; ' . $title_with_hiddens ['title'];
                            $found = true;
                        } else {
                            foreach ($title_with_hiddens ['hiddens'] as $url_ => $title_) {
                                if ($url_ == CONTROLLER_NAME . '/' . ACTION_NAME && 'System/info' != $url_) {
                                    $current_title = $title_sub . ' &gt; ' . $title_;
                                    $found = true;
                                    break;
                                }
                            }
                        }
                        if ($found) {
                            break;
                        }
                    }
                }
            }
            if (!$current_title) {
                $current_title = L('admin_home');
            }
        }
        $this->show($current_title);
    }


    public function menu()
    {

        if (defined('ADMIN_EMPTY_FRAME')) {
            return;
        }

        $export_menus = $this->getExportMenus();
        $menus_to_delete = $this->getMenuDeleted();


        $menu_html_arr = array();
        $b_tab_selected = false;
        $current_title = '';
        foreach ($export_menus as $tab => $tabs) {
            if ('__HOME__' == $tab) {
                continue;
            }
            $b_current_tab = false;
            $menu_html_arr_items = array();
            foreach ($tabs as $title_sub => $sub_menus) {
                $submenu_html_arr = array();
                $b_current_sub = false;
                foreach ($sub_menus as $url => $title_with_hiddens) {
                    if (in_array($url, $menus_to_delete)) {
                        continue;
                    }
                    $found = false;
                    if ($url == CONTROLLER_NAME . '/' . ACTION_NAME) {
                        $current_title = $title_with_hiddens ['title'];
                        $b_current_sub = true;
                        $b_current_tab = true;
                        $b_tab_selected = true;
                        $found = true;
                    } else {
                        foreach ($title_with_hiddens ['hiddens'] as $url_ => $title_) {
                            if ($url_ == CONTROLLER_NAME . '/' . ACTION_NAME && 'System/info' != $url_) {
                                $current_title = $title_;
                                $b_current_sub = true;
                                $b_current_tab = true;
                                $b_tab_selected = true;
                                $found = true;
                                break;
                            }
                        }
                    }
                    $submenu_html_arr [] = '<a class="m-3' . ($found ? ' m-3-show' : '') . '" href="' . U($url) . '"> <span class="icon-double-angle-right"></span> ' . $title_with_hiddens ['title'] . '</a>';
                }

                $menu_html_arr_items [] = '<a class="m-2' . ($b_current_sub ? ' m-2-show' : '') . '" href="#">[' . $title_sub . ']</a>';
                $menu_html_arr_items [] = '<div class="m-3-box' . ($b_current_sub ? ' m-3-box-show' : '') . '">' . join('', $submenu_html_arr) . '</div>';
            }

            $menu_html_arr [] = '<a class="m-1' . ($b_current_tab ? ' m-1-show' : '') . '" href="#">' . $this->getMenuIcon($tab) . ' ' . L('menu_' . $tab) . '</a>';
            $menu_html_arr [] = '<div class="m-2-box' . ($b_current_tab ? ' m-2-box-show' : '') . '">';
            $menu_html_arr [] = join('', $menu_html_arr_items);
            $menu_html_arr [] = '</div>';
        }
        $this->show(join('', $menu_html_arr));
    }
}
