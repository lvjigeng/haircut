<?php

/**
 * 订单
 */
class GoodOrderController extends PlatformController
{
    //添加订单
    public function add(){
//        var_dump($_POST);
//        var_dump($_SESSION['userinfo']);
        //接收数据
        $data = $_POST;
        //处理数据
        $goodOrderModel = new GoodOrderModel();
        $res = $goodOrderModel->add($data);
        if ($res ===false){
            self::redirect("index.php?p=Home&c=Goods&a=index","兑换失败".$goodOrderModel->getError(),2);
        }
        //显示页面
        self::redirect("index.php?p=Home&c=Goods&a=index");
    }
}