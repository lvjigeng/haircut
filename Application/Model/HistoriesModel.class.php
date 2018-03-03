<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/3
 * Time: 21:52
 */
class HistoriesModel extends Model
{
    //消费榜前三
    public function getConsumeBang(){
        $sql="select user_id,sum(amount) as total_consume from histories where `type`=0 GROUP BY user_id order by total_consume desc limit 3";
        //每个用户的消费和id
        $users_consume=$this->db->fetchAll($sql);
//        echo '<pre>';
//        var_dump($users_consume);exit;
        foreach ($users_consume as &$value){
            $sql="select realname from `users` where user_id='{$value['user_id']}'";
            $value['realname']=$this->db->fetchColumn($sql);
        }
        return $users_consume;
    }
    //充值榜前三
    public function getRechargeBang(){
        $sql="select user_id,sum(amount) as total_recharge from histories where `type`=1 GROUP BY user_id order by total_recharge desc limit 3";
        //每个用户的消费和id
        $users_recharge=$this->db->fetchAll($sql);
//        echo '<pre>';
//        var_dump($users_consume);exit;
        foreach ($users_recharge as &$value){
            $sql="select realname from `users` where user_id='{$value['user_id']}'";
            $value['realname']=$this->db->fetchColumn($sql);
        }
        return $users_recharge;
    }
    //服务榜
    public function getServerBang(){
        $sql="select realname,is_server from members order by is_server DESC limit 3";
        return $this->db->fetchAll($sql);
    }
}