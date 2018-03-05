<?php

/**
 * 登录
 */
class LoginController extends Controller
{
    //登录页面
    public function Login(){
        //接收数据
        //处理数据
        if (isset($_SESSION['userinfo'])){
            self::redirect("index.php?p=Home&c=Users&a=index");
        }
        //显示页面
        $this->display("login");
    }
    //登录检查
    public function check(){
//        var_dump($_POST);die;
        //接收数据
        $username = $_POST['username'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];
        //>>2.处理数据
        //验证验证码是否正确
        @session_start();
        //不区分大小写进行比对  strtoupper()  全部大写
        if(strtoupper($captcha) != strtoupper($_SESSION['random_code'])){
            self::redirect("index.php?p=Home&c=Login&a=Login","验证码错误",2);
        }
        //处理数据
        $usersModel = new UsersModel();
        $users = $usersModel->check($username,$password);
        if ($users ===false){   //登录失败
            self::redirect("index.php?p=Home&c=Login&a=Login","登录失败".$usersModel->getError(),2);
        }
        //成功 将用户信息保存到session中
        @session_start();
        $_SESSION['userinfo'] = $users;
        //判断是否需要记住登录
        if(isset($_POST['remember'])){
            //需要记住,将id和password保存到cookie中
            setcookie("id",$users['user_id'],time() + 7*24*3600,"/");
            setcookie("password",md5(md5($users['password'])),time() + 7*24*3600,"/");
        }
        //显示页面
        //登录成功
        self::redirect("index.php?p=Home&c=Users&a=index");
    }
    //退出登录
    public function logout(){
        //1.删除session中的用户信息
        @session_start();
        unset($_SESSION['userinfo']);
        //2.删除cookie中的id和password
        setcookie("id",null,-1,"/");
        setcookie("password",null,-1,"/");
        //3.跳转到登录页面
        self::redirect("index.php?p=Home&c=Login&a=Login");
    }
}