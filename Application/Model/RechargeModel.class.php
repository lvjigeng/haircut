<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 23:14
 */
class RechargeModel extends Model
{
    //获取所有充值活动信息
    public function getAll(){
        $sql="select * from `recharge`";
        $recharges=$this->db->fetchAll($sql);
        return $recharges;
    }
    //获取修改是需要回显的信息
    public function getRow($id){
        $sql="select * from `recharge` where recharge_id='{$id}'";
        $recharge=$this->db->fetchRow($sql);
        return $recharge;
    }
    //添加充值活动信息
    public function getAdd($data){
        $sql="select recharge_money from recharge";
        $recharge_moneys=$this->db->fetchAll($sql);
        foreach ($recharge_moneys as $recharge_money){
            if ($data['recharge_money']==$recharge_money['recharge_money']){
                $this->error='充值活动金额已经存在';
                return false;
            }
        }
        $sql="insert into `recharge` set `recharge_money`='{$data['recharge_money']}',`handsel_money`='{$data['handsel_money']}'";
        $rs=$this->db->execute($sql);
        return $rs;

    }
    //修改保存充值活动信息
    public function getEdit($data){
        $sql="update `recharge` set `recharge_money`='{$data['recharge_money']}',handsel_money='{$data['handsel_money']}' where recharge_id='{$data['id']}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }
    //删除充值活动
    public function getDelete($id){
        $sql="delete from `recharge` where recharge_id='{$id}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }

}