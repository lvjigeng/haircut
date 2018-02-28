<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/2/28
 * Time: 16:27
 */
class GroupModel extends Model
{
    public function getAll(){
        $sql="select * from `group`";
        $groups=$this->db->fetchAll($sql);
        return $groups;
    }

    public function getRow($id){
        $sql="select * from `group` where group_id='{$id}'";
        $group=$this->db->fetchRow($sql);
        return $group;
    }

    public function getAdd($data){
        $sql="insert into `group` set `name`='{$data['name']}'";
        $rs=$this->db->execute($sql);
        return $rs;

    }

    public function getEdit($data){
        $sql="update `group` set `name`='{$data['name']}' where group_id='{$data['group_id']}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }

    public function getDelete($id){
        $sql="select group_id from members where group_id='{$id}'";
        $arr=$this->db->fetchAll($sql);
        if (!empty($arr)){
            return 3;
        }
        $sql="delete from `group` where group_id='{$id}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }
}