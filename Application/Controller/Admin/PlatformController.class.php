<?php

/**
 * 平台统一控制器,验证是否登录
 */
class PlatformController extends Controller
{
    /**
     * 初始化
     */
    public function __construct()
    {
        //验证session中的登录信息
        @session_start();
        if(!isset($_SESSION['membersinfo'])){//验证cookie中没有登录信息,跳转到等页面
            //检测cookie中是否有id和password
            if(isset($_COOKIE['id']) && isset($_COOKIE['password'])){
                //有id和password 就取出来
                $id = $_COOKIE['id'];
                $password = $_COOKIE['password'];
                //验证对不对
                $usersModel = new UsersModel();
                //成功返回用户信息 失败返回false
                $result = $usersModel->checkIdPwd($id,$password);
                if($result===false){//验证失败
                    //跳转登录功能
                    self::redirect("index.php?p=Admin&c=Login&a=Login","请登录",2);
                }else{
                    //保存用户信息到session中
                    $_SESSION['membersinfo'] = $result;
                    return;
                }
            }
            //跳转登录功能
            self::redirect("index.php?p=Admin&c=Login&a=Login","请登录",2);
        }
    }
}