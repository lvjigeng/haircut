<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/2/28
 * Time: 18:32
 */
class GroupController extends Controller
{
    public function groupList(){

        $groupModel=new GroupModel();
        $groups=$groupModel->getAll();
        $this->assign('groups',$groups);
        //显示页面
        $this->display('list');

    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $groupModel=new GroupModel();
            $rs=$groupModel->getAdd($data);
            if ($rs===false){
                self::redirect('index.php?p=Admin&c=Group&a=add','添加失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Group&a=groupList');
        }
        else{

            $this->display('add');
        }
    }

    public function edit(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $groupModel=new GroupModel();
            $rs=$groupModel->getEdit($data);
            if ($rs===false){
                self::redirect("index.php?p=Admin&c=Group&a=edit&id={$data['id']}",'修改失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Group&a=groupList');
        }
        else{
            $id=$_GET['id'];
            $groupModel=new GroupModel();
            $group=$groupModel->getRow($id);
            $this->assign('group',$group);
            $this->display('edit');
        }
    }

    public function delete(){
        $id=$_GET['id'];

        $groupModel=new GroupModel();
        $rs=$groupModel->getDelete($id);
        if ($rs===false){
            self::redirect("index.php?p=Admin&c=Group&a=groupList",'删除失败!!'.$groupModel->getError(),2);
        }
        elseif($rs===3){
            self::redirect("index.php?p=Admin&c=Group&a=groupList",'删除失败!部门下面有人不能删除',2);
        }
        self::redirect("index.php?p=Admin&c=Group&a=groupList");

    }
}