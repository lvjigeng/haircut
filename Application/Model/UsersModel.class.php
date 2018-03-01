<?php

/**
 * 会员模型
 */
class UsersModel extends Model
{
    //获取全部数据
    public function getAll(){
        //SQL语句
        $sql = "select * from users";
        //执行
        return $this->db->fetchAll($sql);
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