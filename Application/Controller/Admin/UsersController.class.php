<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 21:50
 */
class UsersController extends PlatformController
{
    //显示会员列表
    public function index(){

        //接受数据

        $search='';
        if (!empty($_REQUEST['keywords'])){
            $search=" `realname` like '%{$_REQUEST['keywords']}%' or `telephone` like '%{$_REQUEST['keywords']}%'";
        }
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //操作数据
        $usersModel=new UsersModel();
        $users=$usersModel->getAll($search,$page);

        //把数组里的键板为变量名值变为变量值
        extract($users);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配数据
        $this->assign('users',$users);
        $this->assign('html',$html);
        //显示页面
        $this->display('list');

    }

    //会员充值
    public function recharge(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            //接受数据
            $data=$_POST;
            //操作数据
            $usersModel=new UsersModel();
            $rs=$usersModel->getRecharge($data);
            if ($rs===false){
                self::redirect('index.php?p=Admin&c=Users&a=index','充值失败'.$usersModel->getError(),2);
            }
            self::redirect('index.php?p=Admin&c=Users&a=index','充值成功',2);
        }
        else{
            //接受数据
            $user_id=$_GET['id'];
            $this->assign('user_id',$user_id);
            $this->display('recharge');
        }
    }

    //充值记录
    public function rechargeRecord(){
        $id=$_GET['id'];
        //接受数据

        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //操作数据
        $usersModel=new UsersModel();
        $records=$usersModel->getRechargeRecord($page,$id);

        //把数组里的键板为变量名值变为变量值
        extract($records);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配数据
        $this->assign('records',$records);
        $this->assign('html',$html);
        //
        $this->display('recharge_record');
    }

    //会员消费
    public function consume(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            //操作数据
            $userModel=new UsersModel();
            $rs=$userModel->getConsume($data);
        }
        else{
            $user_id=$_GET['id'];
            //操作数据
            //美发师
            $membersModel=new MembersModel();
            $members=$membersModel->getList();
            //代金券
            $codesModel=new CodesModel();
            $codes=$codesModel->getUserCodes($user_id);
            $this->assign('user_id',$user_id);
            $this->assign('members',$members);
            $this->assign('codes',$codes);
            $this->display('consume');
        }
    }

    //会员添加
    public function add(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $usersModel=new UsersModel();
            $rs=$usersModel->getAdd($data);
            if ($rs===false){
                self::redirect('index.php?p=Admin&c=Users&a=add','添加失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Users&a=index');
        }
        else{

            $this->display('add');
        }
    }
}