<?php
namespace Ext;

class StringMisc
{
    /**
     * 根据start和end截取中间，不包含start和end
     * @param string $str
     * @param string $start
     * @param string $end
     */
    public static function string_cut(&$str, $start, $end)
    {
        if (($pos1 = strpos($str, $start)) === false) {
            return '';
        }
        if (($pos2 = strpos($str, $end)) === false) {
            return '';
        }
        return substr($str, $pos1 + strlen($start), $pos2 - $pos1 - strlen($start));
    }

    /**
     * 获取左边的len个字符
     * @param string $str
     * @param integer $len
     */
    public static function string_left(&$str, $len)
    {
        return substr($str, 0, $len);
    }

    public static function string_right(&$str, $len)
    {
        return substr($str, -$len);
    }

    /**
     * 根据正则表达式获取中间的部分
     * @param string $pattern = a(\\d+)b 将获取括号中的值
     */
    public static function string_pattern_value(&$str, $pattern)
    {
        if (preg_match($pattern, $str, $match)) {
            if (isset ($match [1])) {
                return $match [1];
            }
        }
        return '';
    }

    public static function string_exists(&$str, $check_str)
    {
        return false !== strpos($str, $check_str);
    }

    public static function string_cut_left(&$str, $check_str)
    {
        $pos = strpos($str, $check_str);
        if ($pos === null) {
            return '';
        }
        return substr($str, $pos + strlen($check_str));
    }

    public static function string_cut_right(&$str, $check_str)
    {
        $pos = strpos($str, $check_str);
        if ($pos === null) {
            return '';
        }
        return substr($str, 0, $pos);
    }

    public static function string_remove_html(&$str)
    {
        $str = preg_replace('/<[^>]+>/', '', $str);
        return $str;
    }

}

