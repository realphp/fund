<?php

/**
 * Usage
 * import ( 'Common/Extends/Image' );
 * \Image::image_thumb ($image, $thumbname, $maxWidth = 99999, $maxHeight = 99999, $savetype = false, $waterMark = false);
 */

/**
 * @deprecated
 */
class Image
{

    /**
     * 取得图像信息
     */
    public static function image_get_info($img)
    {
        $imageInfo = getimagesize($img);
        if ($imageInfo !== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo [2]), 1));
            $imageSize = filesize($img);
            $info = array(
                "width" => $imageInfo [0],
                "height" => $imageInfo [1],
                "type" => $imageType,
                "size" => $imageSize,
                "mime" => $imageInfo ['mime']
            );
            return $info;
        } else {
            return false;
        }
    }

    /* 生成缩略图 */
    public static function image_thumb($image, $thumbname, $maxWidth = 99999, $maxHeight = 99999, $savetype = false, $waterMark = false)
    {
        /* 获取原图信息 */
        if (!file_exists($image)) {
            return;
        }
        $info = self::image_get_info($image); /* echo '<pre>';print_r($info);exit(); */
        if ($info !== false) {
            $srcWidth = $info ['width'];
            $srcHeight = $info ['height'];
            $type = strtolower($info ['type']);
            $dir = dirname($thumbname);
            if (!file_exists($dir)) {
                @mkdir($dir, 0777, true);
            }
            if ($type == 'bmp' || ($type == 'gif' && $srcHeight < $maxHeight && $srcWidth < $maxWidth)) {
                if ($image != $thumbname) {
                    @copy($image, $thumbname);
                }
                return;
            }
            if (!$savetype) {
                $savetype = $type;
            }
            $interlace = true;
            unset ($info);
            $scale = min($maxWidth / $srcWidth, $maxHeight / $srcHeight); /* 计算缩放比例 */
            if ($scale >= 1) {
                /* 超过原图大小不再缩略 */
                $width = $srcWidth;
                $height = $srcHeight;
            } else {
                /* 缩略图尺寸 */
                $width = ( int )($srcWidth * $scale);
                $height = ( int )($srcHeight * $scale);
            }

            /* 载入原图 */
            $createFun = 'ImageCreateFrom' . ($type == 'jpg' ? 'jpeg' : $type);
            $srcImg = $createFun ($image);

            /* 创建缩略图 */
            if ($savetype != 'gif' && function_exists('imagecreatetruecolor')) {
                $thumbImg = imagecreatetruecolor($width, $height);
            } else {
                $thumbImg = imagecreate($width, $height);
            }
            /* 复制图片 */
            if (function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            else
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            if ('gif' == $savetype || 'png' == $savetype) {
                /* imagealphablending($thumbImg, false);//取消默认的混色模式 */
                /* imagesavealpha($thumbImg,true);//设定保存完整的 alpha 通道信息 */
                $background_color = imagecolorallocate($thumbImg, 0, 255, 0); /* 指派一个绿色 */
                imagecolortransparent($thumbImg, $background_color); /* 设置为透明色，若注释掉该行则输出绿色的图 */
            }

            /* 对jpeg图形设置隔行扫描 */
            if ('jpg' == $savetype || 'jpeg' == $savetype)
                imageinterlace($thumbImg, $interlace);

            if ($waterMark !== false) {
                self::image_water_mark($thumbImg, $width, $height, $waterMark);
            }

            /* 生成图片 */
            $imageFun = 'image' . ($savetype == 'jpg' ? 'jpeg' : $savetype);
            $imageFun ($thumbImg, $thumbname);
            imagedestroy($thumbImg);
            imagedestroy($srcImg);
            return true;
        }
        return false;
    }

    /* 添加水印 */
    public static function image_water_mark(&$thumbImg, $width, $height, $waterMark)
    {
        $wsize = intval($width / 40);
        if ($wsize < 10) {
            $wsize = 10;
        }
        switch (rand(1, 4)) {
            case 1 :
                $wleft = 10;
                $wtop = $wsize + 10;
                break;
            case 2 :
                $wleft = $width - $wsize * strlen($waterMark) - 10;
                $wtop = $wsize + 10;
                break;
            case 3 :
                $wleft = 10;
                $wtop = $height - $wsize - 5;
                break;
            default :
                $wleft = $width - $wsize * strlen($waterMark) - 10;
                $wtop = $height - $wsize - 5;
                break;
        }
        imagettftext($thumbImg, $wsize, 0, $wleft, $wtop, imagecolorallocate($thumbImg, 255, 255, 255), './app/Common/Font/default_zh.ttf', $waterMark);
        /* imagestring($thumbImg,5,$width-200,$height-200,$waterMark,$gray); */
    }
}
