<?php

/**
 * 订单
 */
class GoodOrderController extends PlatformController
{
    //订单首页
    public function index(){
        //接收数据

        $search='';
        if (!empty($_REQUEST['keywords'])){
            $search=" `username` like '%{$_REQUEST['keywords']}%' or `address` like '%{$_REQUEST['keywords']}%'";
        }
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //操作数据
        $goodOrderModel = new GoodOrderModel();
        $orders = $goodOrderModel->getAll($search,$page);
        extract($orders);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配数据
        $this->assign('orders',$orders);
        $this->assign('html',$html);
        //处理数据
        //显示页面
        $this->display("index");
    }
    //修改发货状态
    public function update(){
        //根据id修改发货状态
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $goodOrderModel = new GoodOrderModel();
        $goodOrderModel->update1($id);
        //显示页面
        //显示页面
        self::redirect("index.php?p=Admin&c=GoodOrder&a=index");
    }
}