<?php

/**
 * 会员模型
 */
class UsersModel extends Model
{
    //获取全部数据
    public function getAll($search=[],$page=1){
        $where='';
        if (!empty($search)){
            $where=" where $search ";
        }

        //分页部分
        $limit='';
        $sql="select count(*) from users".$where;

        //每页显示6条记录
        $pageSize=8;
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

        $sql="select * from users".$where.$limit;
//        echo '<pre>';
//        var_dump($sql);exit;
        $users=$this->db->fetchAll($sql);
        return ['users'=>$users,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];
    }
    //获取一条数据
    public function getOne($id){
        //SQL语句
        $sql = "select * from users where user_id='{$id}'";
        //执行
        return $this->db->fetchRow($sql);
    }
    //注册保存
    public function add($data){
        //用户名不能为空
        if (empty($data['username'])){
            $this->error = "用户名不能为空";
            return false;
        }
        //真实姓名不能为空
        if (empty($data['realname'])){
            $this->error = "真实姓名不能为空";
            return false;
        }
        //密码不能为空
        if (empty($data['password'])){
            $this->error = "密码不能为空";
            return false;
        }
        //电话不能为空
        if (empty($data['telephone'])){
            $this->error = "电话不能为空";
            return false;
        }
        //头像不能为空
        if (empty($data['photo'])){
            $this->error = "请上传头像";
            return false;
        }
        //密码和确认密码一致
        if($data['password'] != $data['repassword']){
            $this->error = "密码和确认密码不一致";
            return false;
        }
        //密码加密
        $data['password'] = md5($data['password']);
        //SQL语句
        $sql = "insert into users set 
username='{$data['username']}',
realname='{$data['realname']}',
password='{$data['password']}',
sex='{$data['sex']}',
telephone='{$data['telephone']}',
photo='{$data['photo']}'
";
        //执行
        return $this->db->execute($sql);
    }
    //修改保存
    public function editSave($data){
//        var_dump($data);
        //用户名不能为空
        if(empty($data['username'])){
            $this->error = "用户名不能为空!";
            return false;
        }
        //真实姓名不能为空
        if(empty($data['realname'])){
            $this->error = "真实姓名不能为空!";
            return false;
        }
        //电话不能为空
        if(empty($data['telephone'])){
            $this->error = "电话号码不能为空!";
            return false;
        }
        //判断是否填写了原密码
        if (empty($data['oldpassword'])){
            //没有填写
            $sql = "update users set 
username='{$data['username']}',
realname='{$data['realname']}',
sex='{$data['sex']}',
telephone='{$data['telephone']}',
photo='{$data['photo']}' where user_id='{$data['user_id']}'
";
        }else{
            //填写了
            //修改密码.先输入原密码
            if(empty($data['password'])){
                $this->error = "新密码不能为空!";
                return false;
            }
            //新密码和确认密一致
            if($data['password'] != $data['repassword']){
                $this->error = "确认密码不一致!";
                return false;
            }
            //根据会员id查询密码
            $sql_password = "select password from users where user_id='{$data['user_id']}'";
            //数据库的密码
            $db_password = $this->db->fetchColumn($sql_password);
            //将传过来的密码加密与数据库密码进行比对
            if(md5($data['oldpassword']) != $db_password){
                $this->error = "原密码错误!";
                return false;
            }
            //如果正确  更新数据库
            $password = md5($data['password']); //加密保存
            //SQL语句
            $sql = "update users set 
username='{$data['username']}',
realname='{$data['realname']}',
sex='{$data['sex']}',
telephone='{$data['telephone']}',
password='{$password}',
photo='{$data['photo']}' where user_id='{$data['user_id']}'
";
        }
        //执行
        return $this->db->execute($sql);
    }
    //获取最新活动
    public function getAllArticle($search,$page){
        $where='';
        if (!empty($search)){
            $where=" where $search ";
        }
        //分页部分
        $limit='';
        $sql="select count(*) from article".$where;

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

        $sql="select * from article".$where.$limit;
//        echo '<pre>';
//        var_dump($sql);exit;
        $articles=$this->db->fetchAll($sql);
        return ['articles'=>$articles,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];
    }
    //获取预约数据
    public function getOrder(){
        //SQL语句
        $sql = "select * from `order`";
        //执行
        $orders =  $this->db->fetchAll($sql);
        foreach ($orders as &$val){
//            var_dump($val);die;
            //sql
            $sql_barber = "select realname from members where member_id='{$val['barber']}'";
            //执行
            $barber = $this->db->fetchrow($sql_barber);
            $val['barber'] = $barber;
        }
//        var_dump($orders);die;
        return $orders;
    }
    //验证登录
    public function check($username,$password){
        //将传过来的用户名进行转义
        $username = addslashes($username);
        //将传过来的密码md5加密
        $password = md5($password);
        //从数据库查询出用户名和密码等于传入的,如果查询到说明该用户存在,如果查询不到说明用户不存在
        $users_sql = "select * from users WHERE username='{$username}'" ;
        //查询用户的信息
        $users = $this->db->fetchRow($users_sql);
        //判断用户信息是否为空
        if(empty($users)){
            $this->error = "用户名不存在!";
            return false;
        }
        //判断密码是否正确
        if($users['password'] != $password){
            $this->error = "密码填写错误!";
            return false;
        }
//        var_dump($_SERVER['REMOTE_ADDR']);die;
        //返回用户的信息
        return $users;
    }
    /**
     * 验证id和password
     * @param $id 用户id
     * @param $password 密码 双重加密
     * @return false 表名验证失败  成功返回用户的完整信息
     */
    public function checkIdPwd($id,$password){
        //根据用户id查询用户的数据
        $user_sql = "select * from users WHERE user_id='{$id}'" ;
        //查询用户的信息
        $users = $this->db->fetchRow($user_sql);
        //判断用户信息是否为空
        if(empty($users)){
            $this->error = "用户不存在!";
            return false;
        }
        //判断密码是否正确
        if(md5(md5($users['password'])) != $password){
            $this->error = "密码填写错误!";
            return false;
        }
        //返回用户的信息
        return $users;
    }
}