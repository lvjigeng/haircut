<?php

/**
 * 会员控制器
 */
class UsersController extends Controller
{
    //会员列表
    public function index(){
        //接收数据
        //处理数据
        $usersModel = new UsersModel();
        $users = $usersModel->getAll();
        //分配
        $this->assign("users",$users);
        //显示页面
        $this->display("index");
    }
    //添加功能
    public function add(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //添加保存
        }else{
            //展示添加页面
            //接收数据
            //处理数据
            //显示页面
            $this->display("add");
        }
    }
    //修改功能
    public function edit(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //修改保存
        }else{
            //回显
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $usersModel = new UsersModel();
            $user = $usersModel->getOne($id);
            //分配
            $this->assign($user);
            //显示页面
            $this->display("edit");

        }
    }

}