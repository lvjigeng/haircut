<?php

/**
 * 会员控制器
 */
class UsersController extends PlatformController
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
            //接收数据
//            var_dump($_POST);
//            var_dump($_FILES);
            $data = $_POST;
            $photo = $_FILES['photo'];
            //处理文件
            $upload = new UploadTool();
            $photo_url = $upload->up("user_photo",$photo); //返回图片路径
            if ($photo_url ===false){  //失败
                self::redirect("index.php?p=Admin&c=Users&a=add","制作头像失败".$upload->getError(),2);
            }
            //成功 制作缩略图
            $imageTool = new ImageTool();
            $thumb_logo = $imageTool->thumbImage($photo_url,50,50);
            if ($thumb_logo ===false ){  //失败
                self::redirect("index.php?p=Admin&c=Users&a=add","制作头像缩略图失败".$imageTool->getError(),2);
            }
            //成功就将缩略图保存到$data里
            $data['photo'] = $thumb_logo;
            //删除原图片
            @unlink($photo_url);
            //处理数据
//            var_dump($data);die;
            $usersModel = new UsersModel();
            $res = $usersModel->add($data);
            if ($res ===false){  //注册失败
                self::redirect("index.php?p=Admin&c=Users&a=add","注册失败".$usersModel->getError(),2);
            }
            //成功,跳转到首页
            self::redirect("index.php?p=Home&c=Index&a=index");
            //显示页面
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