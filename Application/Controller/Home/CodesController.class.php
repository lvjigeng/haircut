<?php

/**
 * 代金券
 */
class CodesController extends PlatformController
{
    //个人代金券列表
    public function index(){
        //接收数据
//        var_dump($_SESSION['userinfo']['user_id']);die;
        //根据session里的用户id查询自己的代金券
        $id = $_SESSION['userinfo']['user_id'];
        //处理数据
        $codesModel = new CodesModel();
        $codes = $codesModel->getUserCodes($id);
        //分配
        $this->assign("codes",$codes);
        //显示页面
        $this->display("codes");
    }
}