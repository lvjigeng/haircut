<?php

/**
 * 订单
 */
class GoodOrderModel extends Model
{

    //获取全部订单
    public function getAll($search=[],$page=1){
        $where='';
        if (!empty($search)){
            $where=" where $search ";
        }

        //分页部分
        $limit='';
        $sql="select count(*) from goodOrder".$where;

        //每页显示6条记录
        $pageSize=6;
        //总记录数
        $count=$this->db->fetchColumn($sql);
        //总页数
        $totalPage=ceil($count/$pageSize);
        //优化
        $page=$page>$totalPage?$totalPage:$page;
        $page=$page<1?1:$page;
        //数据库limit的开始位置
        $start_page=($page-1)*$pageSize;
        $limit.=" limit $start_page,$pageSize";

        $sql="select * from goodOrder".$where.$limit;
//        echo '<pre>';
//        var_dump($sql);exit;
        $orders = $this->db->fetchAll($sql);
        return ['orders'=>$orders,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];
    }
    //添加保存
    public function add($data){
        //地址不能为空
        if (empty($data['address'])){
            $this->error = "请填写地址";
            return false;
        }
        //订单号
        $num = $_SESSION['userinfo']['telephone'].uniqid();
//        var_dump($num);
        //收货人
        $name = $_SESSION['userinfo']['realname'];
        //电话
        $phone = $_SESSION['userinfo']['telephone'];
        //服务时间
        $time = time();
        //SQL语句
        $sql = "insert into goodOrder set 
order_num='{$num}',
username='{$name}',
telephone='{$phone}',
`time`='{$time}',
address='{$data['address']}'
";
        //执行
        return $this->db->execute($sql);
    }
    //获取当前登录会员的订单信息
    public function getOne($page=1){


        //分页部分
        $limit='';
        $sql="select count(*) from goodOrder";

        //每页显示6条记录
        $pageSize=6;
        //总记录数
        $count=$this->db->fetchColumn($sql);
        //总页数
        $totalPage=ceil($count/$pageSize);
        //优化
        $page=$page>$totalPage?$totalPage:$page;
        $page=$page<1?1:$page;
        //数据库limit的开始位置
        $start_page=($page-1)*$pageSize;
        $limit.=" limit $start_page,$pageSize";
//        var_dump($_SESSION['userinfo']['username']);
        //根据session里的用户信息查询订单
        $sql = "select * from goodOrder where username='{$_SESSION['userinfo']['realname']}'".$limit;
//        var_dump($sql);die;
        //执行
        $orders =  $this->db->fetchAll($sql);
//        var_dump($orders);die;
        return ['orders'=>$orders,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];
    }
    //根据id修改订单状态
    public function update($id){
        //SQL语句
        $sql = "update goodOrder set 
`status`=1 where order_id='{$id}'
";
        //执行
        $this->db->execute($sql);
    }
    //根据id修改订单状态
    public function update1($id){
        //SQL语句
        $sql = "update goodOrder set 
`status`=-1 where order_id='{$id}'
";
        //执行
        $this->db->execute($sql);
    }
}