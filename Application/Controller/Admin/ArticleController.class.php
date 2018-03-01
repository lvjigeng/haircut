<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 11:01
 */
class ArticleController extends PlatformController
{
    public function index(){

        //接受数据

        $search='';
        if (!empty($_REQUEST['keywords'])){
            $search=" `title` like '%{$_REQUEST['keywords']}%' or `content` like '%{$_REQUEST['keywords']}%'";
        }
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //操作数据
        $articleModel=new ArticleModel();
        $articles=$articleModel->gteAll($search,$page);

        //把数组里的键板为变量名值变为变量值
        extract($articles);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配数据
        $this->assign('articles',$articles);
        $this->assign('html',$html);
        //显示页面
        $this->display('list');

    }


    public function add(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $data['start']=strtotime($_POST['start']);
            $data['end']=strtotime($_POST['end']);
            $articleModel=new ArticleModel();
            $rs=$articleModel->getAdd($data);
            if ($rs===false){
                self::redirect('index.php?p=Admin&c=Article&a=add','添加失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Article&a=index');
        }
        else{

            $this->display('add');
        }
    }

    public function edit(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $data['start']=strtotime($_POST['start']);
            $data['end']=strtotime($_POST['end']);
            $articleModel=new ArticleModel();
            $rs=$articleModel->getEdit($data);
            if ($rs===false){
                self::redirect("index.php?p=Admin&c=Article&a=edit&id={$data['id']}",'修改失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Article&a=index');
        }
        else{
            $id=$_GET['id'];
            $articleModel=new ArticleModel();
            $article=$articleModel->getRow($id);
            $this->assign('article',$article);
            $this->display('edit');
        }
    }

    public function delete(){
        $id=$_GET['id'];

        $articleModel=new articleModel();
        $rs=$articleModel->getDelete($id);
        if ($rs===false){
            self::redirect("index.php?p=Admin&c=article&a=index",'删除失败!!'.$articleModel->getError(),2);
        }

        self::redirect("index.php?p=Admin&c=article&a=index");

    }
}