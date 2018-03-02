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
    //获取当前会员的订单
    public function myself(){
        //根据session中的会员信息查询订单
        //接收数据
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //处理数据
        $goodOrderModel = new GoodOrderModel();
        $orders = $goodOrderModel->getOne($page);
        extract($orders);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配
        $this->assign("orders",$orders);
        $this->assign("html",$html);
        //显示页面
        $this->display("index");
    }
    //确认收货后,修改其订单状态
    public function update(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $goodOrderModel = new GoodOrderModel();
        $goodOrderModel->update($id);
        //显示页面
        self::redirect("index.php?p=Home&c=GoodOrder&a=myself");

    }
}