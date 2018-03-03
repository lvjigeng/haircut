<?php

/**
 * 商品
 */
class GoodsModel extends Model
{
    //获取全部数据
    public function getAll($page=1){
        //分页部分
        $limit='';
        $sql="select count(*) from goods";

        //每页显示6条记录
        $pageSize=6;
        //总记录数
        $count=$this->db->fetchColumn($sql);
        //总页数
        $totalPage=ceil($count/$pageSize);
        //优化
        $page=$page>$totalPage?$totalPage:$page;
        $page=$page<1?1:$page;
        //数据库limit的开始位置
        $start_page=($page-1)*$pageSize;
        $limit.=" limit $start_page,$pageSize";
        //SQL语句
        $sql = "select * from goods".$limit;
        //执行
        $goods = $this->db->fetchAll($sql);
        return ['goods'=>$goods,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];
    }
    //根据id查询商品兑换消耗积分
    public function getGood($good_id){
        //SQL语句
        $sql = "select num,goods_integral from goods where goods_id='{$good_id}'";
        //执行
        return $this->db->fetchRow($sql);
    }
    //添加商品保存
    public function add($data){
        //商品名不能为空
        if (empty($data['goods_name'])){
            $this->error = "商品名不能为空";
            return false;
        }
        //兑换积分不能为空
        if (empty($data['goods_integral'])){
            $this->error = "兑换积分不能为空";
            return false;
        }
        //库存不能为空
        if (empty($data['num'])){
            $this->error = "库存不能为空";
            return false;
        }
        //SQL语句
        $sql = "insert into goods set 
goods_name='{$data['goods_name']}',
goods_integral='{$data['goods_integral']}',
num='{$data['num']}',
img='{$data['img']}'
";
        //执行
        return $this->db->execute($sql);
    }
    //修改回显
    public function edit($id){
        //根据id查询商品全部信息
        //SQL语句
        $sql = "select * from goods where goods_id='{$id}'";
        //执行
        return $this->db->fetchRow($sql);
    }
    //修改保存
    public function editSave($data){
        //商品名不能为空
        if (empty($data['goods_name'])){
            $this->error = "商品名不能为空";
            return false;
        }
        //兑换积分不能为空
        if (empty($data['goods_integral'])){
            $this->error = "兑换积分不能为空";
            return false;
        }
        //库存不能为空
        if (empty($data['num'])){
            $this->error = "库存不能为空";
            return false;
        }
        //SQL语句
        $sql = "update goods set 
goods_name='{$data['goods_name']}',
goods_integral='{$data['goods_integral']}',
num='{$data['num']}',
img='{$data['img']}' where goods_id='{$data['goods_id']}'
";
        //执行
        return $this->db->execute($sql);
    }
    //移除商品
    public function delete($id){
        //根据id查询出商品图
        $sql_img = "select img from goods where goods_id='{$id}'";
        //执行
        $img = $this->db->fetchColumn($sql_img);
//        var_dump($img);
        @unlink($img);
        //再删除商品信息
        $sql = "delete from goods where goods_id='{$id}'";
        //执行
        $this->db->execute($sql);
    }
    //获取当前会员的积分
    public function getIntegral($id){
        //SQL语句
        $sql = "select integral from users where user_id='{$id}'";
        //执行
       $integral =  $this->db->fetchColumn($sql);
//       var_dump($integral);die;
        return $integral;
    }
    //修改积分以及库存
    public function editIntegralNum($good,$good_id){
        //sql
        //更新数据库积分
        $sql_integral = "update users integral set 
`integral`=integral-'{$good['goods_integral']}' where user_id='{$_SESSION['userinfo']['user_id']}'
";
        //更新库存
        $sql_num = "update goods num set
num=num-1 WHERE goods_id='{$good_id}'              
        ";
        //执行
        $this->db->execute($sql_integral);
        $this->db->execute($sql_num);
//        var_dump($good);die;
    }
}