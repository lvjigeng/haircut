<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/3
 * Time: 21:09
 */
class VipController extends PlatformController
{
    public function index(){

        $VipModel=new VipModel();
        $vips=$VipModel->getAll();
        $this->assign('vips',$vips);
        //显示页面
        $this->display('list');

    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $VipModel=new VipModel();
            $rs=$VipModel->getAdd($data);
            if ($rs===false){
                self::redirect('index.php?p=Admin&c=Vip&a=add','添加失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Vip&a=index');
        }
        else{

            $this->display('add');
        }
    }

    public function edit(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $VipModel=new VipModel();
            $rs=$VipModel->getEdit($data);
            if ($rs===false){
                self::redirect("index.php?p=Admin&c=Vip&a=edit&id={$data['vip_id']}",'修改失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Vip&a=index');
        }
        else{
            $id=$_GET['id'];
            $VipModel=new VipModel();
            $vip=$VipModel->getRow($id);
            $this->assign('vip',$vip);
            $this->display('edit');
        }
    }

    public function delete(){
        $id=$_GET['id'];

        $VipModel=new VipModel();
        $rs=$VipModel->getDelete($id);
        if ($rs===false){
            self::redirect("index.php?p=Admin&c=Vip&a=index",'删除失败!!'.$VipModel->getError(),2);
        }
        self::redirect("index.php?p=Admin&c=Vip&a=index");

    }
}