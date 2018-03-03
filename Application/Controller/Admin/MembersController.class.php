q<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/2/28
 * Time: 13:31
 */
class MembersController extends PlatformController
{

    public function membersList(){

        //接受数据

        $search='';
        if (!empty($_REQUEST['keywords'])){
            $search=" realname like '%{$_REQUEST['keywords']}%' or telephone like '%{$_REQUEST['keywords']}%'";
        }
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //操作数据
        $membersModel=new MembersModel();
        $members=$membersModel->getAll($search,$page);

        //把数组里的键板为变量名值变为变量值
        extract($members);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配数据
        $this->assign('members',$members);
        $this->assign('html',$html);
        //显示页面
        $this->display('list');

    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $img_info = $_FILES['photo'];
            if($img_info['error']!=4){
                //创建对象
                /***************文件上传****************************************/
                $upload = new UploadTool();
                //调用上传方法,并把返回的路径赋给img_path
                $img_path = $upload->up('members_photo', $img_info);
                //上传没有成功
                if ($img_path === false) {
                    self::redirect('index.php?p=Admin&c=Members&a=add', '上传失败!!' . $upload->getError(), 2);
                }

                //把返回的路径保存到$data里


                /**************制做缩略图***********************************/
                $thumb = new ImageTool();
                $thumb_path = $thumb->thumbImage($img_path, 100, 100);
                if ($thumb_path === false) {
                    self::redirect('index.php?p=Admin&c=Members&a=add', '制做缩略图失败' . $thumb->getError(), 2);
                }
                $data['thumb_photo'] = $thumb_path;
                unlink($img_path);
            }else{
                $data['thumb_photo']='./Public/Admin/images/head.jpg';
            }

            //操作数据
            $membersModel=new MembersModel();
            $rs=$membersModel->getAdd($data);
            if ($rs===false){
                self::redirect("index.php?p=Admin&c=Members&a=add",'添加失败!!'.$membersModel->getError(),2);
            }
            //成功
            self::redirect("index.php?p=Admin&c=Members&a=membersList");
        }
        else{
            $groupModel=new GroupModel();
            $groups=$groupModel->getAll();
            $this->assign('groups',$groups);
            $this->display('add');
        }


    }

    public function edit(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $img_info=$_FILES['photo'];
            if (!$img_info['error']==4){
                //创建对象
                /***************文件上传****************************************/
                $upload = new UploadTool();
                //调用上传方法,并把返回的路径赋给img_path
                $img_path = $upload->up('members_photo', $img_info);
                //上传没有成功
                if ($img_path === false) {
                    self::redirect("index.php?p=Home&c=members&a=edit&id={$data['member_id']}", '上传失败!!' . $upload->getError(), 2);
                }

                //把返回的路径保存到$data里



                /**************制做缩略图***********************************/
                $thumb = new ImageTool();
                $thumb_path = $thumb->thumbImage($img_path, 100, 100);
                if ($thumb_path === false) {
                    self::redirect("index.php?p=Home&c=members&a=edit&id={$data['member_id']}", '制做缩略图失败' . $thumb->getError(), 2);
                }
                @unlink($data['thumb_photo']);
                $data['thumb_photo'] = $thumb_path;
                @unlink($img_path);
            }

            //操作数据
            $membersModel=new membersModel();
            $rs=$membersModel->getEdit($data);
            if ($rs===false){
                self::redirect("index.php?p=Home&c=members&a=edit&id={$data['member_id']}",'修改失败!!'.$membersModel->getError(),2);
            }
            self::redirect("index.php?p=Admin&c=members&a=membersList");

        }
        else{
            //接受数据
            $id=$_GET['id'];
            $membersModel=new MembersModel();
            $member=$membersModel->getRow($id);
            $groupModel=new GroupModel();
            $groups=$groupModel->getAll();
            $this->assign('groups',$groups);
            $this->assign('member',$member);
            $this->display('edit');
        }
        //接受数据

    }

    public function delete(){
        $id=$_GET['id'];

        $membersModel=new MembersModel();
        $rs=$membersModel->getDelete($id);
        if ($rs===false){
            self::redirect("index.php?p=Admin&c=members&a=membersList",'删除失败!!'.$membersModel->getError(),2);
        }
        self::redirect("index.php?p=Admin&c=members&a=membersList");

    }


}