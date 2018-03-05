<?php

/**
 * 预约
 */
class OrderModel extends Model
{
    //获取全部员工数据
    public function getAllMember(){
        //SQL语句
        $sql = "select member_id,realname from members";
        //执行
        return $this->db->fetchAll($sql);
    }
    //保存预约数据
    public function add($data){
        //号码不能为空
        if (empty($data['telephone'])){
            $this->error = "请填写11位电话号码";
        }
        //预约时间不能为空
        if (empty($data['date'])){
            $this->error = "请填写预约时间";
            return false;
        }
        //预约时间
        $data['date'] = strtotime($data['date']);
        //sql语句
        $sql = "insert into `order` set 
realname='{$data['realname']}',
phone='{$data['telephone']}',
barber='{$data['barber']}',
content='{$data['content']}',
`date`='{$data['date']}'
";
        //执行
        return $this->db->execute($sql);
    }

    //获取所有预约
    public function gteAll($search,$page){
        $where='';
        if (!empty($search)){
            $where=" where $search ";
        }
        //分页部分
        $limit='';
        $sql="select count(*) from `order`".$where;

        //每页显示6条记录
        $pageSize=4;
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

        $sql="select * from `order`".$where.$limit;
//        echo '<pre>';
//        var_dump($sql);exit;
        $orders=$this->db->fetchAll($sql);
        foreach ($orders as &$order){
            $sql="select member_id,realname from members where member_id='{$order['barber']}'";
            $order['member']=$this->db->fetchRow($sql);
        }

        return ['orders'=>$orders,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];
    }
    //获取修改需要回显的一条数据
    public function getRow($id){
        $sql="select * from `order` where order_id='{$id}'";
        $order=$this->db->fetchRow($sql);
        return $order;
    }
    //处理预约(修改)
    public function getEdit($data){
        $sql="update `order` set 
`status`='{$data['status']}',
 `reply`='{$data['reply']}' where order_id='{$data['id']}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }
}