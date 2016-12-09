<?php
if (!defined('THINK_PATH')) {
    exit ();
}

$url = strtolower(CONTROLLER_NAME);
if (!$url) {
    exit ('error request ' . $url);
}

$page = D('SinglePage', 'Service')->page($url);

if (empty ($page)) {
    $this->error('错误的页面' . $url);
}

$page ['content'] = parse_res_url($page ['content'], __ROOT__ . '/', __ROOT__ . '/');

$this->page = $page;

$this->page_title = $page ['title'];
$this->page_keywords = $page ['keywords'];
$this->page_description = $page ['description'];
$this->display('Empty/page');
