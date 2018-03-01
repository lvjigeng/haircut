<?php

/**
 * 商品
 */
class GoodsModel extends Model
{
    //获取全部数据
    public function getAll(){
        //SQL语句
        $sql = "select * from goods";
        //执行
        return $this->db->fetchAll($sql);
    }
    //根据id查询商品兑换消耗积分
    public function getGood($good_id){
        //SQL语句
        $sql = "select goods_integral from goods where goods_id='{$good_id}'";
        //执行
        return $this->db->fetchColumn($sql);
    }
}