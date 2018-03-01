<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 15:25
 */
class CodesModel extends Model
{
    public function getAll($search,$page){
        $where='';
        if (!empty($search)){
            $where=" where $search and status=0";
        }
        //分页部分
        $limit='';
        $sql="select count(*) from codes".$where;
//        echo '<pre>';
//        var_dump($sql);exit;

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
        $sql="select * from `codes`".$where.$limit;

        $codes=$this->db->fetchAll($sql);
        foreach ($codes as &$code){
            $sql="select user_id,realname from users where user_id='{$code['user_id']}'";
            $code['user']=$this->db->fetchRow($sql);
        }

        return ['codes'=>$codes,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];
    }

    public function getRow($id){
        $sql="select * from `codes` where code_id='{$id}'";
        $code=$this->db->fetchRow($sql);
        return $code;
    }

    public function getAdd($data){
        $sql="insert into `codes` set 
`code`='{$data['code']}',
`user_id`='{$data['user_id']}',
`money`='{$data['money']}'
";
        $rs=$this->db->execute($sql);
        return $rs;

    }

    public function getEdit($data){
        $sql="update `codes` set 
`code`='{$data['code']}',
`user_id`='{$data['user_id']}',
`money`='{$data['money']}',
`status`='{$data['status']}' where code_id='{$data['id']}'";

        $rs=$this->db->execute($sql);
        return $rs;
    }

    public function getDelete($id){

        $sql="delete from `codes` where code_id='{$id}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }

}