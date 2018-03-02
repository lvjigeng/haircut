<?php

/**
 * 商城商品
 */
class GoodsController extends PlatformController
{
    //商城首页
    public function index(){
        //接收数据
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //处理数据
        $goodsModel = new GoodsModel();
        $goods = $goodsModel->getAll($page);
        extract($goods);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配
        $this->assign("goods",$goods);
        $this->assign("html",$html);
        //显示页面
        $this->display("index");
    }
    //兑换商品页面
    public function exchange(){

            //根据id查询会员信息
//            var_dump($_GET);die;
            $good_id = $_GET['id'];
            //处理数据
            $goodsModel = new GoodsModel();
            $good = $goodsModel->getGood($good_id);//获取商品消耗积分
//            var_dump($good);die;
//        var_dump($_SESSION['userinfo']);die;
        if ($good > $_SESSION['userinfo']['integral']){
            self::redirect("index.php?p=Home&c=Goods&a=index","积分不足,不能兑换",2);
        }
            $this->assign("good",$good);
        //显示页面
            $this->display("exchange");




    }
}