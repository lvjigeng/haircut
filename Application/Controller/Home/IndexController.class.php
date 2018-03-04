<?php

/**
 * 前台首页
 */
class IndexController extends Controller
{
    //前台页面
    public function index(){
        //接收数据
        $search='';
        if (!empty($_REQUEST['keywords'])){
            $search=" `title` like '%{$_REQUEST['keywords']}%' or `content` like '%{$_REQUEST['keywords']}%'";
        }
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //处理数据
        //活动
        $articleModel = new ArticleModel();
        $articles = $articleModel->gteAll($search,$page);
        //套餐
        $plansModel = new PlansModel();
        $plans = $plansModel->gteAll($search,$page);
//        var_dump($articles);die;
        extract($articles);
//        var_dump($articles);die;
        extract($plans);
//        var_dump($plans);die;
        //分配
        $this->assign("articles",$articles);
        $this->assign("plans",$plans);

        //显示页面
        $this->display("index");
    }
    //前台注册
    public function add(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //添加保存
            //接收数据
//            var_dump($_POST);
//            var_dump($_FILES);
            $data = $_POST;
            $photo = $_FILES['photo'];
            if ($photo['error'] !=4){
                //处理文件
                $upload = new UploadTool();
                $photo_url = $upload->up("user_photo",$photo); //返回图片路径
                if ($photo_url ===false){  //失败
                    self::redirect("index.php?p=Home&c=Index&a=add","制作头像失败".$upload->getError(),2);
                }
                //成功 制作缩略图
                $imageTool = new ImageTool();
                $thumb_logo = $imageTool->thumbImage($photo_url,100,100);
                if ($thumb_logo ===false ){  //失败
                    self::redirect("index.php?p=Home&c=Index&a=add","制作头像缩略图失败".$imageTool->getError(),2);
                }
                //成功就将缩略图保存到$data里
                $data['photo'] = $thumb_logo;
                //删除原图片
                @unlink($photo_url);
            }else{
                $data['photo'] = "Public/Admin/images/head.jpg";
            }

            //处理数据
//            var_dump($data);die;
            $usersModel = new UsersModel();
            $res = $usersModel->add($data);
            if ($res ===false){  //注册失败
                self::redirect("index.php?p=Home&c=Index&a=add","注册失败".$usersModel->getError(),2);
            }
            //成功,跳转到首页
            self::redirect("index.php?p=Home&c=Index&a=index");
            //显示页面
        }else{
            //展示添加页面
            //接收数据
            //处理数据
            //显示页面
            $this->display("add");
        }
    }
    //后台添加会员
    //注册
    public function add1(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //添加保存
            //接收数据
//            var_dump($_POST);
//            var_dump($_FILES);
            $data = $_POST;
            $photo = $_FILES['photo'];
            if ($photo['error'] !=4){
                //处理文件
                $upload = new UploadTool();
                $photo_url = $upload->up("user_photo",$photo); //返回图片路径
                if ($photo_url ===false){  //失败
                    self::redirect("index.php?p=Home&c=Index&a=add1","制作头像失败".$upload->getError(),2);
                }
                //成功 制作缩略图
                $imageTool = new ImageTool();
                $thumb_logo = $imageTool->thumbImage($photo_url,100,100);
                if ($thumb_logo ===false ){  //失败
                    self::redirect("index.php?p=Home&c=Index&a=add1","制作头像缩略图失败".$imageTool->getError(),2);
                }
                //成功就将缩略图保存到$data里
                $data['photo'] = $thumb_logo;
                //删除原图片
                @unlink($photo_url);
            }else{
                $data['photo'] = "Public/Admin/images/head.jpg";
            }

            //处理数据
//            var_dump($data);die;
            $usersModel = new UsersModel();
            $res = $usersModel->add($data);
            if ($res ===false){  //注册失败
                self::redirect("index.php?p=Home&c=Index&a=add1","注册失败".$usersModel->getError(),2);
            }
            //成功,跳转到首页
            self::redirect("index.php?p=Admin&c=Users&a=index");
            //显示页面
        }else{
            //展示添加页面
            //接收数据
            //处理数据
            //显示页面
            $this->display("add1");
        }
    }

}