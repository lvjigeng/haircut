<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/3/1
 * Time: 11:02
 */
class ArticleModel extends Model
{
    public function gteAll($search,$page){
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


    public function getRow($id){
        $sql="select * from `article` where article_id='{$id}'";
        $article=$this->db->fetchRow($sql);
        return $article;
    }

    public function getAdd($data){
        $time=time();
        $sql="insert into `article` set 
`title`='{$data['title']}',
`content`='{$data['content']}',
`start`='{$data['start']}',
`end`='{$data['end']}',
`time`='{$time}'
";
        $rs=$this->db->execute($sql);
        return $rs;

    }

    public function getEdit($data){
        $sql="update `article` set 
`title`='{$data['title']}',
`content`='{$data['content']}',
`start`='{$data['start']}',
`end`='{$data['end']}' where article_id='{$data['id']}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }

    public function getDelete($id){
        $sql="select `end` from article where article_id='{$id}'";
        $end=$this->db->fetchColumn($sql);
        $time=time();
//        echo '<pre>';
//        var_dump($time);
//        var_dump($end);exit;
        if ($time<=$end){
            $this->error='活动期间不能删除';
            return false;
        }
        $sql="delete from `article` where article_id='{$id}'";
        $rs=$this->db->execute($sql);
        return $rs;
    }

}