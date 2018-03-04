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
        $pageSize=5;
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
    //充值
    public function getRecharge($data){
        @session_start();
        if (empty($data['money'])){
            $this->error='请添写充值金额';
            return false;
        }
        if ($data['money']<=0){
            $this->error='充值金额必须大于0';
            return false;
        }
        //查询赠送的金额
        $sql="select handsel_money from `recharge` where recharge_money<='{$data['money']}' ORDER BY recharge_money DESC limit 1";
        //赠送的金额
        $handsel_money=$this->db->fetchColumn($sql);
        if (empty($handsel_money)){
            $handsel_money=0;
        }

        //总金额
        $total_money=$data['money']+$handsel_money;
        //查询会员等级
        $sql="select vip_rank from `vip` where money<='{$data['money']}' ORDER BY `money` DESC limit 1";
        //单次充值的vip等级
        $vip_rank=$this->db->fetchColumn($sql);
        //把数据更新到会员表里面
        //判断原来的会员等级是否大于现在单次充值的vip等级

        $sql="select * from `users` where user_id='{$data['user_id']}'";
        $user=$this->db->fetchRow($sql);
        //原来的vip等级
        $old_vip_rank=$user['vip_rank'];
        //充值后的余额
        $balance=$user['money']+$total_money;
        $member_id=$_SESSION['membersinfo']['member_id'];
        $time=time();

        //单次充值的vip等级小于原来的等级,不需要改变vip等级,只需要更新充值的钱
        if ($vip_rank<$old_vip_rank){

            try {
                $this->db->pdo->beginTransaction();
                $sql = "update users set `money`='{$total_money}'+`money` where user_id='{$data['user_id']}'";
                 $this->db->pdo->exec($sql);

                //heistory表,充值记录
                $sql="insert into histories set
`user_id`='{$data['user_id']}',
`member_id`='{$member_id}',
`type`=1,
`amount`='{$data['money']}',
`handsel_money`='{$handsel_money}',
`money`='{$balance}',
`time`='{$time}'
";
                 $this->db->pdo->exec($sql);
                $this->db->pdo->commit();
            }
            catch (PDOException $e){
                $this->db->pdo->rollBack();
                $this->error=$e->getMessage();
                return false;
            }

        }else{
            //单次充值的vip等级大于原来的等级,需要改变vip等级和更新充值的钱
            try{
                $this->db->pdo->beginTransaction();
                $sql="update users set `money`='{$total_money}'+money,vip_rank='{$vip_rank}' where user_id='{$data['user_id']}'";
                $this->db->execute($sql);
                //heistory表,充值记录
                $sql="insert into histories set
`user_id`='{$data['user_id']}',
`member_id`='{$member_id}',
`type`=1,
`amount`='{$data['money']}',
`handsel_money`='{$handsel_money}',
`money`='{$balance}',
`time`='{$time}'
";
                $this->db->pdo->exec($sql);
                $this->db->pdo->commit();

            }catch (PDOException $e){
                $this->db->pdo->rollBack();
                $this->error=$e->getMessage();
                return false;
            }
        }

    }
    //充值记录
    public function getRechargeRecord($page,$id){

        //分页部分
        $limit='';
        $sql="select count(*) from histories where user_id='{$id}' and `type`=1";

        //每页显示6条记录
        $pageSize=4;
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
        $sql="select * from histories where user_id='{$id}' and `type`=1 order by history_id DESC".$limit;

        $records=$this->db->fetchAll($sql);

        foreach ($records as &$record){
            $sql="select realname from users where user_id='{$record['user_id']}'";
            $record['user_realname']=$this->db->fetchColumn($sql);
            $sql="select realname from members where member_id='{$record['member_id']}'";
            $record['member_realname']=$this->db->fetchColumn($sql);

        }
        return ['records'=>$records,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];;
    }
    //消费
    public function getConsume($data){

        //查询用户余额是否足够
        $sql="select * from users where user_id='{$data['user_id']}'";
        //余额
        $user=$this->db->fetchRow($sql);
        if ($data['money']>$user['money']){
            $this->error='余额不足!!';
        }

        //查询消费折扣
        $sql="select discount from vip where vip_rank='{$user['vip_rank']}'";
        $discount=$this->db->fetchColumn($sql);

        //查询代金券金额
        $sql="select money from codes where code_id='{$data['code_id']}'";
        $code_money=$this->db->fetchColumn($sql);
        //时间
        $time=time();
        //如果不使用代金券
        if (empty($code_money)){
            $code_money=0;
        }

        //如果消费金额大于代金券金额
        if ($data['money']>=$code_money){
            //打完折和使用消费券后的消费金额
            $consume_money=($data['money']-$code_money)*$discount;
            //优惠金额
            $handsel_money=$data['money']-$consume_money;
            //积分
            $integral=$data['money']-$code_money;
            //余额
            $balance=$user['money']-$consume_money;
            //修改user表里面的金额
            try{
                $this->db->pdo->beginTransaction();
                $sql="update users set 
money=money-$consume_money,
integral=integral+'{$integral}' where user_id='{$data['user_id']}'
";
                $this->db->pdo->exec($sql);
                //员工表里服务记录加一次
                $sql="update members set 
is_server=is_server+1 where member_id='{$data['member_id']}'";
                $this->db->pdo->exec($sql);
                //在histories表里添加消费记录
                $sql="insert into histories set 
user_id='{$data['user_id']}',
member_id='{$data['member_id']}',
amount='{$data['money']}',
handsel_money='{$handsel_money}',
money=$balance,
`type`=0,
`time`='{$time}'
";

                $this->db->pdo->exec($sql);
                if ($data['code_id']!=0){
                    $sql="update codes set money=0,status=1 where code_id='{$data['code_id']}'";
                    $this->db->pdo->exec($sql);

                }

                $this->db->pdo->commit();
            }catch (ErrorException $e){
                $this->db->pdo->rollBack();
                $this->error=$e->getMessage();
                return false;
            }
        }
        //消费金额小于代金券,如果使用代金券就扣代金券的钱,代金券可以多次使用.不是用就扣余额的钱
        else{
            try{
                $this->db->pdo->beginTransaction();
                //使用代金券消费
                if ($data['code_id']!=0){

                    //消费金额等于代金券金额,代金券就已经使用完了,需要更改状态
                    if($data['money']==$code_money){
                        echo '<pre>';
                        var_dump(11);exit;
                        $sql="update codes set money=0, `type`=1 where code_id='{$data['code_id']}'";
                        $this->db->pdo->exec($sql);
                        //员工表里服务记录加一次
                        $sql="update members set 
is_server=is_server+1 where member_id='{$data['member_id']}'";
                        $this->db->pdo->exec($sql);
                        //在histories表里添加消费记录
                        $sql="insert into histories set 
user_id='{$data['user_id']}',
member_id='{$data['member_id']}',
amount='{$data['money']}',
handsel_money='{$data['money']}',
money='{$user['money']}',
`type`=0,
`time`='{$time}'
";
                        $this->db->pdo->exec($sql);

                    }else{
                        //抵扣代金券的钱,更新代金券里面的数据
                        $sql="update codes set money=money-'{$data['money']}' where code_id='{$data['code_id']}'";
                        $this->db->pdo->exec($sql);
                        //员工表里服务记录加一次
                        $sql="update members set 
is_server=is_server+1 where member_id='{$data['member_id']}'";
                        $this->db->pdo->exec($sql);
                        //在histories表里添加消费记录
                        $sql="insert into histories set 
user_id='{$data['user_id']}',
member_id='{$data['member_id']}',
amount='{$data['money']}',
handsel_money='{$data['money']}',
money='{$user['money']}',
`type`=0,
`time`='{$time}'
";
                        $this->db->pdo->exec($sql);
                    }


                }
                //不使用代金券消费
                else{
                    //打完折和使用消费券后的消费金额
                    $consume_money=$data['money']*$discount;
                    //优惠金额
                    $handsel_money=$data['money']-$code_money;
                    //积分
                    $integral=$data['money'];
                    //余额
                    $balance=$user['money']-$consume_money;
                    $sql="update users set moneny=money-$consume_money,integral=integral+'{$integral}' where user_id='{$data['$user_id']}'";
                    $this->db->pdo->exec($sql);
                    //员工表里服务记录加一次
                    $sql="update members set 
is_server=is_server+1 where member_id='{$data['member_id']}'";
                    $this->db->pdo->exec($sql);
                    $sql="insert into histories set 
user_id='{$data['user_id']}',
member_id='{$data['member_id']}',
amount='{$data['money']}',
handsel_money='{$handsel_money}',
money='{$balance}',
`type`=0,
`time`='{$time}'
";
                    $this->db->pdo->exec($sql);
                }
                $this->db->pdo->commit();
            }catch (ErrorException $e){
                $this->db->pdo->rollBack();
                $this->error=$e->getMessage();
                return false;
            }



        }



    }
    //消费记录
    public function getConsumeRecord($page,$id){

        //分页部分
        $limit='';
        $sql="select count(*) from histories where user_id='{$id}' and `type`=0";

        //每页显示6条记录
        $pageSize=4;
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
        $sql="select * from histories where user_id='{$id}' and `type`=0 order by history_id DESC".$limit;

        $records=$this->db->fetchAll($sql);

        foreach ($records as &$record){
            $sql="select realname from users where user_id='{$record['user_id']}'";
            $record['user_realname']=$this->db->fetchColumn($sql);
            $sql="select realname from members where member_id='{$record['member_id']}'";
            $record['member_realname']=$this->db->fetchColumn($sql);

        }
        return ['records'=>$records,'pageSize'=>$pageSize,'count'=>$count,'totalPage'=>$totalPage,'page'=>$page];;
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
        $pageSize=4;
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