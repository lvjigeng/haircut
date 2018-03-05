<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 15:24
 */
class CodesController extends PlatformController
{
    public function index(){
        $search='';
        if (!empty($_REQUEST['keywords'])){
            $search=" `code` like '%{$_REQUEST['keywords']}%'";
        }
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //操作数据
        $codesModel=new CodesModel();
        $codes=$codesModel->getAll($search,$page);

        //把数组里的键板为变量名值变为变量值
        extract($codes);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配数据
        $this->assign('codes',$codes);
        $this->assign('html',$html);
        //显示页面
        $this->display('list');

    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
//            echo '<pre>';
//            var_dump($data);exit;
            $codesModel=new CodesModel();
            $rs=$codesModel->getAdd($data);
            if ($rs===false){
                self::redirect('index.php?p=Admin&c=Codes&a=add','添加失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Codes&a=index');
        }
        else{
            $usersModel=new UsersModel();
            $users=$usersModel->getList();
            extract($users);
            $this->assign('users',$users);
            $this->display('add');
        }
    }

    public function edit(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $codesModel=new CodesModel();
            $rs=$codesModel->getEdit($data);
            if ($rs===false){
                self::redirect("index.php?p=Admin&c=Codes&a=edit&id={$data['id']}",'修改失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Codes&a=index');
        }
        else{
            $id=$_GET['id'];
            $codesModel=new codesModel();
            $code=$codesModel->getRow($id);
            //查询会员表,回显要用到真实姓名
            $usersModel=new UsersModel();
            $users=$usersModel->getAll();
            extract($users);
            $this->assign('users',$users);
            $this->assign('code',$code);
            $this->display('edit');
        }
    }

    public function delete(){
        $id=$_GET['id'];

        $codesModel=new CodesModel();
        $rs=$codesModel->getDelete($id);
        if ($rs===false){
            self::redirect("index.php?p=Admin&c=Codes&a=index",'删除失败!!'.$codesModel->getError(),2);
        }

        self::redirect("index.php?p=Admin&c=Codes&a=index");

    }
}