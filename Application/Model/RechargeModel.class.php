<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 23:14
 */
class RechargeModel extends Model
{
    public function getAll(){
        $sql="select * from `recharge`";
        $recharges=$this->db->fetchAll($sql);
        return $recharges;
    }

    public function getRow($id){
        $sql="select * from `recharge` where recharge_id='{$id}'";
        $recharge=$this->db->fetchRow($sql);
        return $recharge;
    }

    public function getAdd($data){
        $sql="insert into `recharge` set `recharge_money`='{$data['recharge_money']}',`handsel_money`='{$data['handsel_money']}'";
        $rs=$this->db->execute($sql);
        return $rs;

    }

    public function getEdit($data){
        $sql="update `recharge` set `recharge_money`='{$data['recharge_money']}',handsel_money='{$data['handsel_money']}' where recharge_id='{$data['recharge_id']}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }

    public function getDelete($id){
        
        $sql="delete from `recharge` where recharge_id='{$id}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }

}