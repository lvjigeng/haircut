<?php

/**
 * 预约控制器
 */
class OrderController extends Controller
{
    //后台预约列表显示
    public function index(){

        //接受数据

        $search='';
        if (!empty($_REQUEST['keywords'])){
            $search=" `realname` like '%{$_REQUEST['keywords']}%'";
        }
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //操作数据
        $orderModel=new OrderModel();
        $orders=$orderModel->gteAll($search,$page);

        //把数组里的键板为变量名值变为变量值
        extract($orders);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配数据
        $this->assign('orders',$orders);
        $this->assign('html',$html);
        //显示页面
        $this->display('list');

    }
    
    
    //预约美发
    public function add(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //预约保存
            //接收数据
            $data = $_POST;
//            var_dump($data);
            //处理数据
            $orderModel = new OrderModel();
            $res = $orderModel->add($data);
            if ($res === false ){  //预约失败
                self::redirect("index.php?p=Home&c=Order&a=add","预约失败".$orderModel->getError(),2);
            }
            //成功
            //显示页面
            self::redirect("index.php?p=Home&c=Users&a=index","预约成功,请稍后",2);
        }else{
//            var_dump($_SESSION['userinfo']);
            //获取员工信息
            $orderModel = new OrderModel();
            $members = $orderModel->getAllMember();
//            var_dump($members);
            //分配
            $this->assign("members",$members);
            //显示页面
            $this->display("add");
        }
    }

    //后代预约修改
    public function edit(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $orderModel=new OrderModel();
            $rs=$orderModel->getEdit($data);
            if ($rs===false){
                self::redirect("index.php?p=Admin&c=Order&a=edit&id={$data['id']}",'修改失败!!',2);
            }
            self::redirect('index.php?p=Admin&c=Order&a=index');
        }
        else{
            $id=$_GET['id'];
            $orderModel=new OrderModel();
            $order=$orderModel->getRow($id);
            $this->assign('order',$order);
            $this->display('edit');
        }
    }
}