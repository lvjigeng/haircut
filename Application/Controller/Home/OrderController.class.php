<?php

/**
 * 预约控制器
 */
class OrderController extends PlatformController
{
    //预约美发
    public function add(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //预约保存
            //接收数据
            $data = $_POST;
//            var_dump($data);
            //处理数据
            $orderModel = new OrderModel();
            $res = $orderModel->add($data);
            if ($res === false ){  //预约失败
                self::redirect("index.php?p=Home&c=Order&a=add","预约失败".$orderModel->getError(),2);
            }
            //成功
            //显示页面
            self::redirect("index.php?p=Home&c=Users&a=index","预约成功,请稍后",2);
        }else{
//            var_dump($_SESSION['userinfo']);
            //获取员工信息
            $orderModel = new OrderModel();
            $members = $orderModel->getAllMember();
//            var_dump($members);
            //分配
            $this->assign("members",$members);
            //显示页面
            $this->display("add");
        }
    }
}