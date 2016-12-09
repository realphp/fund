<?php
// local variables has defined
// $db

// restore data files
if (file_exists($backupdir = './app/Common/Custom/data')) {
    tpx_copy_dir($backupdir, './data');
}

// restore database files
if (file_exists($dbsqldir = './app/Common/Custom/dbinit')) {
    foreach (list_file($dbsqldir, '*.sql') as $file) {
        db_restore_file($file['pathname']);
    }
}
