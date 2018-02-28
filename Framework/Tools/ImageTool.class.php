<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/2/1
 * Time: 18:01
 */
class ImageTool
{
    private $error;

    public function getError()
    {
        return $this->error;
    }

    public function thumbImage($img_path, $width, $height)
    {

        if (!is_file($img_path)) {
            $this->error = '原图片不存在';
            return false;
        }
        //1.获得原图片,
        //获取原图片的mime
        $mime = getimagesize($img_path)['mime'];
        $suffix = explode('/', $mime)[1];
        //用可变方法来替换imagecreatefrom+格式这个函数
        $create_img = 'imagecreatefrom' . $suffix;
        $src_img = $create_img($img_path);

        //获取原图片的宽高
        $src_size = getimagesize($img_path);

        list($src_width, $src_height) = $src_size;

//2.画新画布
        $thumb_width = $width;
        $thumb_height = $height;
        //画新画布
        $thumb_img = imagecreatetruecolor($thumb_width, $thumb_height);
        //选一个白色
        $white = imagecolorallocate($thumb_img, 255, 255, 255);
        //填充一个白色背景
        imagefill($thumb_img, 0, 0, $white);
//3.把原图片复制在新图片上面
        //求最大比例
        $bili = max($src_width / $thumb_width, $src_height / $thumb_height);
        $width = $src_width / $bili;
        $height = $src_height / $bili;

        imagecopyresampled($thumb_img, $src_img, ($thumb_width - $width) / 2, ($thumb_height - $height) / 2, 0, 0, $width, $height, $src_width, $src_height);

//4.输出图片
        $img_info = pathinfo($img_path);
//            Tools::dump($img_info);
        $thumb_img_path = $img_info['dirname'] . '/' . $img_info['filename'] . "_{$thumb_width}x{$thumb_height}." . $img_info['extension'];
//            Tools::dump($thumb_img_path);

        imagejpeg($thumb_img, $thumb_img_path);
//5.销毁图片
        imagedestroy($src_img);
        imagedestroy($thumb_img);

//6.返回缩略图的路径
        return $thumb_img_path;
    }

}