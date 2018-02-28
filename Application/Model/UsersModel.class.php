<?php

/**
 * 会员模型
 */
class UsersModel extends Model
{
    //获取全部数据
    public function getAll(){
        //SQL语句
        $sql = "select * from users";
        //执行
        return $this->db->fetchAll($sql);
    }
    //获取一条数据
    public function getOne($id){
        //SQL语句
        $sql = "select * from users where user_id='{$id}'";
        //执行
        return $this->db->fetchRow($sql);
    }
}