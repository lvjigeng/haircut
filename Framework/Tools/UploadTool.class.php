<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/2/9
 * Time: 11:42
 */
class UploadTool
{
    public $error;

    public function getError()
    {
        return $this->error;
    }

    public function up($category, $img_info)
    {
//1.判断上传图片是否成功
        if ($img_info['error'] != 0) {
            $this->error = '请选择上传图片';
            return false;
        }
//2.判断上传图片格式
        $img_allow_type = ['image/png', 'image/gif', 'image/jpeg','image/jpg'];
        if (!in_array($img_info['type'], $img_allow_type)) {
            $this->error = '上传格式不正确';
            return false;
        }
//3.判断上传图片是否超过2M
        $img_max_size = 2 * 1024 * 1024;
        if ($img_info['size'] > $img_allow_type) {
            $this->error = '上传图片大小超过2M';
            return false;
        }
//4.判断图片是否是真的合法图片格式
        $size = getimagesize($img_info['tmp_name']);
        if ($size === false) {
            $this->error = '非法文件';
            return false;
        }
//5.判断图片是否通过http协议上传的
        if (!is_uploaded_file($img_info['tmp_name'])) {
            $this->error = '非法文件';
            return false;
        }
//6.操作图片
        //>>获取临时文件路径
        $tmp = $img_info['tmp_name'];
        //>>截取图片后缀名
        $suffix = strrchr($img_info['name'], '.');
        //>>生成唯一的图片名
        $dir_name = './Uploads/' . $category . '/' . date('Y-m-d');
        $file = $dir_name . '/' . uniqid('image_') . $suffix;
        //>>把图片放到新的位置
        if (!is_dir($dir_name)) {
            mkdir($dir_name, 0777, true);
        }
        move_uploaded_file($tmp, $file);
        return $file;
    }
}