<?php

/**
 * 预约
 */
class OrderModel extends Model
{
    //获取全部员工数据
    public function getAllMember(){
        //SQL语句
        $sql = "select member_id,realname from members";
        //执行
        return $this->db->fetchAll($sql);
    }
    //保存预约数据
    public function add($data){
        //真实姓名不能为空
        if (empty($data['realname'])){
            $this->error = "请填写姓名";
            return false;
        }
        //号码不能为空
        if (empty($data['telephone'])){
            $this->error = "请填写11位电话号码";
        }
        //预约项目不能为空
        if (empty($data['content'])){
            $this->error = "请填写预约项目";
            return false;
        }
        //预约时间
        $time = time();
        //sql语句
        $sql = "insert into `order` set 
realname='{$data['realname']}',
phone='{$data['telephone']}',
barber='{$data['barber']}',
content='{$data['content']}',
`date`='{$time}'
";
        //执行
        return $this->db->execute($sql);
    }
}