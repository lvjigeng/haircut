<?php

/**
 *商城商品
 */
class GoodsController extends PlatformController
{
    //商城首页
    public function index(){
        //接收数据
        //处理数据
        $goodsModel = new GoodsModel();
        $goods = $goodsModel->getAll();
        //分配
        $this->assign("goods",$goods);
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
            $this->assign("good",$good);
        //显示页面
            $this->display("exchange");




    }
}