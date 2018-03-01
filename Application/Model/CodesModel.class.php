<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 15:25
 */
class CodesModel extends Model
{
    public function getAll(){
        $sql="select * from `codes` where status=0";
        $codes=$this->db->fetchAll($sql);
        foreach ($codes as &$code){
            $sql="select user_id,realname from users where user_id='{$code['user_id']}'";
            $code['user']=$this->db->fetchRow($sql);
        }

        return $codes;
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