<?php

/*
 * 验证码管理器
 */
class CaptchaController extends Controller
{
    /**
     * 生成验证码
     */
    public function create(){
        //>>1.生成随机字符串
        //1.准备好需要的字母和数字
        //        $number = range(0,9);
        //        $char = range("A","Z");
        //        //合并两个数组
        //        $arr = array_merge($number,$char);
        //        //将数组拼接成字符串
        $string = "23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
        //将字符串打乱
        $string = str_shuffle($string);
        //截取前四位
        $random_code = substr($string,0,4);
        //>>2.保存到session中
        @session_start();
        $_SESSION['random_code'] = $random_code;
        //背景随机改变
        //路径
        $img_src = "./Public/captcha/captcha_bg".mt_rand(1,5).".jpg";
        //动态获取图片大小
        $imgsize = getimagesize($img_src);
        //获取宽高
        list($width,$height) = $imgsize;
        //从已有的图片创建画布
        $image = imagecreatefromjpeg($img_src);
        /**
         * 混淆验证码
         *      加点
         */
        for ($i=0;$i<=250 ;++$i){
            //随机颜色
            $color_rand = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            //随机画点
            imagesetpixel($image,mt_rand(0,$width),mt_rand(0,$height),$color_rand);
        }
        //加线
        for ($i = 0;$i<=6;++$i){
            //随机颜色
            $color_rand = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            //随机画线
            imageline($image,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),$color_rand);
        }
        //>>文字颜色 随机 黑白色
        //随机颜色
        $white = imagecolorallocate($image,255,255,255);
        $blank = imagecolorallocate($image,0,0,0);
        //保存在一个数组中
        $font_color = [$white,$blank];
        //打乱
        shuffle($font_color);
        //写字
        imagestring($image,5,$width/2.5,$height/7,$random_code,$font_color[0]);
        //给图片加边框  黑色
        imagerectangle($image,0,0,$width-1,$height-1,$blank);
        ob_clean();
        //输出到浏览器上
        header("Content-Type: image/jpeg");
        imagejpeg($image);
        //>>5. 销毁图片
        imagedestroy($image);
    }
}