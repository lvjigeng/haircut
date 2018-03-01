<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 9:45
 */
class PlansController extends PlatformController
{
    public function index(){

            //接受数据

            $search='';
            if (!empty($_REQUEST['keywords'])){
                $search=" `name` like '%{$_REQUEST['keywords']}%' or `desc` like '%{$_REQUEST['keywords']}%'";
            }
            $page=$_REQUEST['page']??1;
            //删除请求里的分页 ,后面手动拼在url上
            unset($_REQUEST['page']);
            //url上的参数
            $urlParams=http_build_query($_REQUEST);
            //操作数据
            $plansModel=new PlansModel();
            $plans=$plansModel->gteAll($search,$page);

            //把数组里的键板为变量名值变为变量值
            extract($plans);
            //调用分页工具
            $createPage=new PageTool();
            $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
            //分配数据
            $this->assign('plans',$plans);
            $this->assign('html',$html);
            //显示页面
            $this->display('list');

        }


    public function add(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $plansModel=new PlansModel();
            $rs=$plansModel->getAdd($data);
            if ($rs===false){
                self::redirect('index.php?p=Admin&c=Plans&a=add','添加失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Plans&a=index');
        }
        else{

            $this->display('add');
        }
    }

    public function edit(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $plansModel=new PlansModel();
            $rs=$plansModel->getEdit($data);
            if ($rs===false){
                self::redirect("index.php?p=Admin&c=Plans&a=edit&id={$data['id']}",'修改失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Plans&a=index');
        }
        else{
            $id=$_GET['id'];
            $plansModel=new PlansModel();
            $plan=$plansModel->getRow($id);
            $this->assign('plan',$plan);
            $this->display('edit');
        }
    }

    public function delete(){
        $id=$_GET['id'];

        $plansModel=new PlansModel();
        $rs=$plansModel->getDelete($id);
        if ($rs===false){
            self::redirect("index.php?p=Admin&c=Plans&a=index",'删除失败!!'.$plansModel->getError(),2);
        }

        self::redirect("index.php?p=Admin&c=Plans&a=index");

    }


}