<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/1/29
 * Time: 11:18
 */
class CaptchaController
{
    public function create(){
        /**
         * 第一种验证码
         */
 //1.生成随机字符串
        $string='23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        //>>打乱字符串
        $string=str_shuffle($string);
        //>>截取前4位字符串
        $random_code=substr($string,0,4);
//        @session_start();
        $_SESSION['random_code']=$random_code;
 //2.创建图片
        //>>2.1.创建图片,规定大小
        $img_src="./Public/Admin/captcha/captcha_bg".mt_rand(1,5).".jpg";
        list($width,$height)=getimagesize($img_src);
        $img=imagecreatefromjpeg($img_src);

        //>>2.2.优化验证码干扰
            //生成随机点
        for ($i=0;$i<=200;$i++){
            $random_color=imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            imagesetpixel($img,mt_rand(0,$width),mt_rand(0,$height),$random_color);
        }
            //生成随机线段
        for($i=0;$i<=7;$i++){
            $random_color=imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            imageline($img,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),$random_color);
        }
            //画一个黑色边框
        $color=imagecolorallocate($img,0,0,0);
        imagerectangle($img,0,0,$width,$height,$color);

 //3.把字写在图片上
        //选择字体颜色  黑色和白色
        $white=imagecolorallocate($img,255,255,255);
        $black=imagecolorallocate($img,0,0,0);
        imagestring($img,5,$width/2.7,$height/8,$random_code,mt_rand(0,1)?$white:$black);

        //>>保存图片
//        imagejpeg($img,'./Public/Admin/captcha/yzm.jpg');
        ob_clean();
        header("Content-Type: image/jpeg");
        imagejpeg($img);

        //>>销毁图片
        imagedestroy($img);

        /**
         * 第二种验证码
         * 字母+数字的验证码生成
         */
//// 开启session
//        session_start();
////1.创建黑色画布
//        $image = imagecreatetruecolor(100, 30);
//
////2.为画布定义(背景)颜色
//        $bgcolor = imagecolorallocate($image, 255, 255, 255);
//
////3.填充颜色
//        imagefill($image, 0, 0, $bgcolor);
//
//// 4.设置验证码内容
//
////4.1 定义验证码的内容
//        $content = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789";
//
////4.1 创建一个变量存储产生的验证码数据，便于用户提交核对
//        $captcha = "";
//        for ($i = 0; $i < 4; $i++) {
//            // 字体大小
//            $fontsize = 10;
//            // 字体颜色
//            $fontcolor = imagecolorallocate($image, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
//            // 设置字体内容
//            $fontcontent = substr($content, mt_rand(0, strlen($content)), 1);
//            $captcha .= $fontcontent;
//            // 显示的坐标
//            $x = ($i * 100 / 4) + mt_rand(5, 10);
//            $y = mt_rand(5, 10);
//            // 填充内容到画布中
//            imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
//        }
//        $_SESSION['random_code'] = $captcha;
//
////4.3 设置背景干扰元素
//        for ($$i = 0; $i < 200; $i++) {
//            $pointcolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
//            imagesetpixel($image, mt_rand(1, 99), mt_rand(1, 29), $pointcolor);
//        }
//
////4.4 设置干扰线
//        for ($i = 0; $i < 3; $i++) {
//            $linecolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
//            imageline($image, mt_rand(1, 99), mt_rand(1, 29), mt_rand(1, 99), mt_rand(1, 29), $linecolor);
//        }
//
////5.向浏览器输出图片头信息
//        header('content-type:image/png');
//
////6.输出图片到浏览器
//        imagepng($image);
//
////7.销毁图片
//        imagedestroy($image);

        /**
         * 第三种方法
         * 验证码用加法表示
         */




    }
}