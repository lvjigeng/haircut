<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/3
 * Time: 21:10
 */
class VipModel extends Model
{
    public function getAll(){
        $sql="select * from `vip`";
        $vips=$this->db->fetchAll($sql);
        return $vips;
    }

    public function getRow($id){
        $sql="select * from `vip` where vip_id='{$id}'";
        $vip=$this->db->fetchRow($sql);
        return $vip;
    }

    public function getAdd($data){
        $sql="insert into `vip` set `name`='{$data['name']}'";
        $rs=$this->db->execute($sql);
        return $rs;

    }

    public function getEdit($data){
        $sql="update `vip` set `discount`='{$data['discount']}',`money`='{$data['money']}' where vip_id='{$data['vip_id']}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }

    public function getDelete($id){
        $sql="select vip_id from members where vip_id='{$id}'";
        $arr=$this->db->fetchAll($sql);
        if (!empty($arr)){
            return 3;
        }
        $sql="delete from `vip` where vip_id='{$id}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }
}