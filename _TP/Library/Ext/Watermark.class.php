<?php
namespace Ext;

class Watermark
{
    /**
     * 给图片添加文字水印
     *
     * @param string $image
     * @param string $string
     * @param integer $fontsize
     * @param string $color
     */
    public static function string_watermark($image, $string, $fontsize = false, $color = "#CCCCCC")
    {
        if (!$fontsize) {
            $fontsize = 12;
        }
        watermark($image, $waterPos = 0, $waterImage = "", $waterText = $string, $fontsize, $color, $fontfile = _OP_ROOT . 'system/font/default_en.ttf', $xOffset = 0, $yOffset = 0);
    }

    /**
     * 功能：PHP图片水印 (水印支持图片或文字) 参数：
     *
     * @param string $groundImage
     *            即需要加水印的图片，暂只支持GIF,JPG,PNG格式；
     * @param integer $waterPos
     *            水印位置，有10种状态，0为随机位置； 1为顶端居左，2为顶端居中，3为顶端居右； 4为中部居左，5为中部居中，6为中部居右； 7为底端居左，8为底端居中，9为底端居右；
     * @param string $waterImage
     *            图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式；
     * @param string $waterText
     *            文字水印，即把文字作为为水印，支持ASCII码，不支持中文；
     * @param integer $fontSize
     *            文字大小，值为1、2、3、4或5，默认为5；
     * @param string $textColor
     *            文字颜色，值为十六进制颜色值，默认为#CCCCCC(白灰色)；
     * @param string $fontfile
     *            ttf字体文件，即用来设置文字水印的字体。
     * @param integer $xOffset
     *            水平偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果你想留给水印留出水平方向上的边距
     * @param integer $yOffset
     *            垂直偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果你想留给水印留出垂直方向上的边距
     *
     * @return 0 水印成功
     *         1 水印图片格式目前不支持
     *         2 要水印的背景图片不存在
     *         3 需要加水印的图片的长度或宽度比水印图片或文字区域还小，无法生成水印
     *         4 字体文件不存在
     *         5 水印文字颜色格式不正确 6 水印背景图片格式目前不支持
     *         $waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。
     *         当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。
     *         加水印后的图片的文件名和 $groundImage 一样。
     */
    public static function watermark($groundImage, $waterPos = 0, $waterImage = "", $waterText = "", $fontSize = 12, $textColor = "#CCCCCC", $fontfile = '', $xOffset = 0, $yOffset = 0)
    {
        $isWaterImage = FALSE;
        /* 读取水印文件 */
        if (!empty ($waterImage) && file_exists($waterImage)) {
            $isWaterImage = TRUE;
            $water_info = getimagesize($waterImage);
            $water_w = $water_info [0]; /* 取得水印图片的宽 */
            $water_h = $water_info [1]; /* 取得水印图片的高 */

            switch ($water_info [2]) { // 取得水印图片的格式
                case 1 :
                    $water_im = imagecreatefromgif($waterImage);
                    break;
                case 2 :
                    $water_im = imagecreatefromjpeg($waterImage);
                    break;
                case 3 :
                    $water_im = imagecreatefrompng($waterImage);
                    break;
                default :
                    return 1;
            }
        }

        /* 读取背景图片 */
        if (!empty ($groundImage) && file_exists($groundImage)) {
            $ground_info = getimagesize($groundImage);
            $ground_w = $ground_info [0];
            $ground_h = $ground_info [1];

            switch ($ground_info [2]) { // 取得背景图片的格式
                case 1 :
                    $ground_im = imagecreatefromgif($groundImage);
                    break;
                case 2 :
                    $ground_im = imagecreatefromjpeg($groundImage);
                    break;
                case 3 :
                    $ground_im = imagecreatefrompng($groundImage);
                    break;
                default :
                    return 1;
            }
        } else {
            return 2;
        }

        /* 水印位置 */
        if ($isWaterImage) {
            $w = $water_w;
            $h = $water_h;
        } else {
            /* 文字水印 */
            if (!file_exists($fontfile) || empty ($fontfile)) {
                return 4;
            }
            $temp = imagettfbbox($fontSize, 0, $fontfile, $waterText); // 取得使用 TrueType 字体的文本的范围
            $w = $temp [2] - $temp [6];
            $h = $temp [3] - $temp [7];
            unset ($temp);
        }
        if (($ground_w < $w) || ($ground_h < $h)) {
            return 3;
        }
        switch ($waterPos) {
            case 0 : // 随机
                $posX = rand(0, ($ground_w - $w));
                $posY = rand(0, ($ground_h - $h));
                break;
            case 1 : // 1为顶端居左
                $posX = 0;
                $posY = 0;
                break;
            case 2 : // 2为顶端居中
                $posX = ($ground_w - $w) / 2;
                $posY = 0;
                break;
            case 3 : // 3为顶端居右
                $posX = $ground_w - $w;
                $posY = 0;
                break;
            case 4 : // 4为中部居左
                $posX = 0;
                $posY = ($ground_h - $h) / 2;
                break;
            case 5 : // 5为中部居中
                $posX = ($ground_w - $w) / 2;
                $posY = ($ground_h - $h) / 2;
                break;
            case 6 : // 6为中部居右
                $posX = $ground_w - $w;
                $posY = ($ground_h - $h) / 2;
                break;
            case 7 : // 7为底端居左
                $posX = 0;
                $posY = $ground_h - $h;
                break;
            case 8 : // 8为底端居中
                $posX = ($ground_w - $w) / 2;
                $posY = $ground_h - $h;
                break;
            case 9 : // 9为底端居右
                $posX = $ground_w - $w;
                $posY = $ground_h - $h;
                break;
            default : // 随机
                $posX = rand(0, ($ground_w - $w));
                $posY = rand(0, ($ground_h - $h));
                break;
        }

        // 设定图像的混色模式
        imagealphablending($ground_im, true);

        if ($isWaterImage) { // 图片水印
            imagecopy($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w, $water_h); // 拷贝水印到目标文件
        } else { // 文字水印
            if (!empty ($textColor) && (strlen($textColor) == 7)) {
                $R = hexdec(substr($textColor, 1, 2));
                $G = hexdec(substr($textColor, 3, 2));
                $B = hexdec(substr($textColor, 5));
            } else {
                return 5;
            }
            imagettftext($ground_im, $fontSize, 0, $posX + $xOffset, $posY + $h + $yOffset, imagecolorallocate($ground_im, $R, $G, $B), $fontfile, $waterText);
        }

        // 生成水印后的图片
        @unlink($groundImage);
        switch ($ground_info [2]) { // 取得背景图片的格式
            case 1 :
                imagegif($ground_im, $groundImage);
                break;
            case 2 :
                imagejpeg($ground_im, $groundImage);
                break;
            case 3 :
                imagepng($ground_im, $groundImage);
                break;
            default :
                return 6;
        }

        // 释放内存
        if (isset ($water_info))
            unset ($water_info);
        if (isset ($water_im))
            imagedestroy($water_im);
        unset ($ground_info);
        imagedestroy($ground_im);
        //
        return 0;
    }
}