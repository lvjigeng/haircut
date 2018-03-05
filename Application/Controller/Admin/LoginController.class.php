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
        //显示页面
        $this->display("login");
    }
    //登录检查
    public function check(){
//        var_dump($_POST);die;
        //接收数据
        $username = $_POST['username'];
        $password = $_POST['password'];
        $random_code=$_POST['random_code'];
        //处理数据

        $membersModel = new MembersModel();
        $members = $membersModel->check($username,$password,$random_code);
        if ($members ===false){   //登录失败
            self::redirect("index.php?p=Admin&c=Login&a=Login","登录失败".$membersModel->getError(),2);
        }
        //成功 将用户信息保存到session中
        @session_start();
        $_SESSION['membersinfo'] = $members;
        //判断是否需要记住登录
        if(isset($_POST['remember'])){
            //需要记住,将id和password保存到cookie中
            setcookie("id",$members['Member_id'],time() + 7*24*3600,"/");
            setcookie("password",md5(md5($members['password'])),time() + 7*24*3600,"/");
        }
        //显示页面
        //登录成功
        self::redirect("index.php?p=Admin&c=Index&a=index");
    }
    //退出登录
    public function logout(){
        //1.删除session中的用户信息
        @session_start();
        unset($_SESSION['membersinfo']);
        //2.删除cookie中的id和password
        setcookie("id",null,-1,"/");
        setcookie("password",null,-1,"/");
        //3.跳转到登录页面
        self::redirect("index.php?p=Admin&c=Index&a=index");

    }
}