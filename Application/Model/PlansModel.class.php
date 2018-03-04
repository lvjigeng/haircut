<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 9:50
 */
class PlansModel extends Model
{
    public function gteAll($search,$page){
        $where='';
        if (!empty($search)){
            $where=" where $search ";
        }
        //分页部分
        $limit='';
        $sql="select count(*) from plans".$where;

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

        $sql="select * from plans".$where.$limit;
//        echo '<pre>';
//        var_dump($sql);exit;
        $plans=$this->db->fetchAll($sql);
        return ['plans'=>$plans,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];
    }


    public function getRow($id){
        $sql="select * from `plans` where plan_id='{$id}'";
        $plan=$this->db->fetchRow($sql);
        return $plan;
    }

    public function getAdd($data){
        $sql="insert into `plans` set 
`name`='{$data['name']}',
`money`='{$data['money']}',
`desc`='{$data['desc']}',
`status`='{$data['status']}'
";
        $rs=$this->db->execute($sql);
        return $rs;

    }

    public function getEdit($data){
        $sql="update `plans` set 
`name`='{$data['name']}',
`money`='{$data['money']}',
`desc`='{$data['desc']}',
`status`='{$data['status']}' where plan_id='{$data['id']}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }

    public function getDelete($id){

        $sql="delete from `plans` where plan_id='{$id}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }
}