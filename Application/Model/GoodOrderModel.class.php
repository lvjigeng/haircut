<?php

/**
 * 订单
 */
class GoodOrderModel extends Model
{
    //添加保存
    public function add($data){
        //地址不能为空
        if (empty($data['address'])){
            $this->error = "请填写地址";
            return false;
        }
        //订单号
        $num = $_SESSION['userinfo']['telephone'].uniqid();
//        var_dump($num);
        //收货人
        $name = $_SESSION['userinfo']['realname'];
        //电话
        $phone = $_SESSION['userinfo']['telephone'];
        //服务时间
        $time = time();
        //SQL语句
        $sql = "insert into goodOrder set 
order_num='{$num}',
username='{$name}',
telephone='{$phone}',
`time`='{$time}',
address='{$data['address']}'
";
        //执行
        return $this->db->execute($sql);
    }
}