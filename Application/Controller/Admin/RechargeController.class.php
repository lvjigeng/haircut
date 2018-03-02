<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 23:10
 */
class RechargeController extends PlatformController
{
    public function index(){

        $rechargeModel=new RechargeModel();
        $recharges=$rechargeModel->getAll();
        $this->assign('recharges',$recharges);
        //显示页面
        $this->display('list');

    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $rechargeModel=new RechargeModel();
            $rs=$rechargeModel->getAdd($data);
            if ($rs===false){
                self::redirect('index.php?p=Admin&c=Recharge&a=add','添加失败!!'.$rechargeModel->getError(),2);
            }
            self::redirect('index.php?p=Admin&c=Recharge&a=index');
        }
        else{

            $this->display('add');
        }
    }

    public function edit(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $rechargeModel=new RechargeModel();
            $rs=$rechargeModel->getEdit($data);
            if ($rs===false){
                self::redirect("index.php?p=Admin&c=Recharge&a=edit&id={$data['id']}",'修改失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Recharge&a=index');
        }
        else{
            $id=$_GET['id'];
            $rechargeModel=new RechargeModel();
            $recharge=$rechargeModel->getRow($id);
            $this->assign('recharge',$recharge);
            $this->display('edit');
        }
    }

    public function delete(){
        $id=$_GET['id'];

        $rechargeModel=new RechargeModel();
        $rs=$rechargeModel->getDelete($id);
        if ($rs===false){
            self::redirect("index.php?p=Admin&c=Recharge&a=index",'删除失败!!'.$rechargeModel->getError(),2);
        }

        self::redirect("index.php?p=Admin&c=Recharge&a=index");

    }
}