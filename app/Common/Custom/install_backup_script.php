<?php
// local variables has defined
// $db

// 保存文件
tpx_rm_dir('./app/Common/Custom/data');
tpx_copy_dir('./data', './app/Common/Custom/data');

// 需要备份的数据表
$tables_to_backup = array(
    'data_files',
    'config',
    'cms_slide',
    'cms_single_page',
    'cms_product',
    'cms_product_cat',
    'cms_partner',
    'cms_news',
);

tpx_rm_dir('./app/Common/Custom/dbinit/');
mkdir('./app/Common/Custom/dbinit/');
foreach ($tables_to_backup as $table) {
    file_put_contents('./app/Common/Custom/dbinit/' . $table . '.sql', db_get_insert_sqls($table));
}

echo 'ok';