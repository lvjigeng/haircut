<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/2/28
 * Time: 15:34
 */
class IndexController extends PlatformController
{
    public function index(){
        //接受数据

        //操作数据
        //消费榜阿三
        $historiesModel=new HistoriesModel();
        $user_consume=$historiesModel->getConsumeBang();
        $user_recharge=$historiesModel->getRechargeBang();
        $member_server=$historiesModel->getServerBang();

            $this->assign('user_consume',$user_consume);
            $this->assign('user_recharge',$user_recharge);
            $this->assign('member_server',$member_server);
        //显示页面

        $this->display('index');
    }
}