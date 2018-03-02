<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/2/28
 * Time: 14:22
 */
class MembersModel extends Model
{
        //带搜索分页的员工列表
        public function getAll($search,$page){
            $where='';
            if (!empty($search)){
                $where=" where $search ";
            }
            //分页部分
            $limit='';
            $sql="select count(*) from members".$where;

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

            $sql="select * from members".$where.$limit;
            $members=$this->db->fetchAll($sql);
            foreach ($members as &$member){
                $sql="select * from `group` where group_id='{$member['group_id']}'";
                $member['group']=$this->db->fetchRow($sql);
            }
            return ['members'=>$members,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];
        }

        //不带搜索分页的所有员工信息
        public function getList(){
            $sql="select * from members";
            $members=$this->db->fetchAll($sql);
            return $members;
        }

        public function getRow($id){
            $sql="select * from members where member_id='{$id}'";
            $member=$this->db->fetchRow($sql);
            return $member;

        }

        public function getAdd($data){

            if (empty($data['username'])) {
                $this->error = '用户名不能为空';
                return false;
            }
            if (empty($data['password'])) {
                $this->error = '密码不能为空';
                return false;
            }
            if ($data['password'] !== $data['repassword']) {
                $this->error = '两次密码不一致';
                return false;
            }
            if (empty($data['realname'])) {
                $this->error = '姓名不能为空';
                return false;
            }

            $sql = "select username from members";
            $members = $this->db->fetchAll($sql);
            foreach ($members as $member) {
                if ($member['username'] == $data['username']) {
                    $this->error = '用户名已被注册,请换一个';
                    return false;
                }
            }

            $sql="insert into members set 
`username`='{$data['username']}',
`password`='{$data['password']}',
`realname`='{$data['realname']}',
`sex`='{$data['sex']}',
`telephone`='{$data['telephone']}',
`group_id`='{$data['group_id']}',
`is_admin`='{$data['is_admin']}',
`photo`='{$data['thumb_photo']}'
";
                $rs=$this->db->execute($sql);
                return $rs;
        }

        public function getEdit($data)
        {
            if (empty($data['realname'])) {
                $this->error = '用户名不能为空';
                return false;
            }
            if (empty($data['telephone'])) {
                $this->error = '电话不能为空';
                return false;
            }

            if (empty($data['oldpassword'])) {
                //只能改头像和用户名
                $sql = "update members set 

`realname`='{$data['realname']}',
`sex`='{$data['sex']}',
`telephone`='{$data['telephone']}',
`group_id`='{$data['group_id']}',
`is_admin`='{$data['is_admin']}',
`photo`='{$data['thumb_photo']}' where member_id='{$data['member_id']}'
";
                $rs = $this->db->execute($sql);
                return $rs;
            } else {
                if (empty($data['password'])) {
                    $this->error = '新密码不能为空';
                    return false;
                }
                //>>新密码和确认密码不相同
                if ($data['password'] != $data['repassword']) {
                    $this->error = '两次密码不一致';
                    return false;
                }

                //>>旧密码输入错误,首先要获取数据库的密码,和传入过来的密码进行比对
                $id = $data['id'];
                $sql = "select password from members where id={$data['id']}";
                //>>数据库的密码
                $db_password = $this->db->fetchColumn($sql);
                //>>输入的的旧密码
                $old_password = md5($data['oldpassword']);
                if ($db_password !== $old_password) {
                    $this->error = '旧密码不正确';
                    return false;
                }
                $sql = "update members set 
`password`='{$data['password']}',
`realname`='{$data['realname']}',
`sex`='{$data['sex']}',
`telephone`='{$data['telephone']}',
`group_id`='{$data['group_id']}',
`is_admin`='{$data['is_admin']}',
`photo`='{$data['thumb_photo']}' where member_id='{$data['member_id']}'
";
                $rs=$this->db->execute($sql);
                return $rs;
            }
        }

        public function getDelete($id){
            $sql="delete from members where member_id='{$id}' and is_server=0";
            $rs=$this->db->execute($sql);
            return $rs;
        }


        public function check($username,$password){
        //将传过来的用户名进行转义
        $username = addslashes($username);

        //将传过来的密码md5加密
        $password = md5($password);
        //从数据库查询出用户名和密码等于传入的,如果查询到说明该用户存在,如果查询不到说明用户不存在
        $users_sql = "select * from members WHERE username='{$username}' and is_admin=1";
        //查询用户的信息
        $members = $this->db->fetchRow($users_sql);

        //判断用户信息是否为空
        if(empty($members)){
            $this->error = "用户名不存在!";
            return false;
        }
        //判断密码是否正确
        if($members['password'] != $password){
            $this->error = "密码填写错误!";
            return false;
        }
//        var_dump($_SERVER['REMOTE_ADDR']);die;
        //返回用户的信息
        return $members;
    }


}