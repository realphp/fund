<?php

namespace Ext;


class FileUtil
{

    public static function file_suffix($filename)
    {
        return strtolower(substr(strrchr($filename, '.'), 1));
    }
}