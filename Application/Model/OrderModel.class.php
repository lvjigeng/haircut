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
        //号码不能为空
        if (empty($data['telephone'])){
            $this->error = "请填写11位电话号码";
        }
        //预约时间不能为空
        if (empty($data['date'])){
            $this->error = "请填写预约时间";
            return false;
        }
        //预约时间
        $data['date'] = strtotime($data['date']);
        //sql语句
        $sql = "insert into `order` set 
phone='{$data['telephone']}',
barber='{$data['barber']}',
content='{$data['content']}',
`date`='{$data['date']}'
";
        //执行
        return $this->db->execute($sql);
    }
}