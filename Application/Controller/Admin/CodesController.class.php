<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 15:24
 */
class CodesController extends PlatformController
{
    public function index(){

        $codesModel=new CodesModel();
        $codes=$codesModel->getAll();
        $this->assign('codes',$codes);
        //显示页面
        $this->display('list');

    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
//            echo '<pre>';
//            var_dump($data);exit;
            $codesModel=new CodesModel();
            $rs=$codesModel->getAdd($data);
            if ($rs===false){
                self::redirect('index.php?p=Admin&c=Codes&a=add','添加失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Codes&a=index');
        }
        else{
            $usersModel=new UsersModel();
            $users=$usersModel->getAll();
            $this->assign('users',$users);
            $this->display('add');
        }
    }

    public function edit(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $codesModel=new CodesModel();
            $rs=$codesModel->getEdit($data);
            if ($rs===false){
                self::redirect("index.php?p=Admin&c=Codes&a=edit&id={$data['id']}",'修改失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Codes&a=index');
        }
        else{
            $id=$_GET['id'];
            $codesModel=new codesModel();
            $code=$codesModel->getRow($id);
            //查询会员表,回显要用到真实姓名
            $usersModel=new UsersModel();
            $users=$usersModel->getAll();
            $this->assign('users',$users);
            $this->assign('code',$code);
            $this->display('edit');
        }
    }

    public function delete(){
        $id=$_GET['id'];

        $codesModel=new CodesModel();
        $rs=$codesModel->getDelete($id);
        if ($rs===false){
            self::redirect("index.php?p=Admin&c=Codes&a=index",'删除失败!!'.$codesModel->getError(),2);
        }

        self::redirect("index.php?p=Admin&c=Codes&a=index");

    }
}