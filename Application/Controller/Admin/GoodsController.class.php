<?php

/**
 * 积分商城商品
 */
class GoodsController extends PlatformController
{
    //商城页面
    public function index(){
        //接收数据
        $page=$_REQUEST['page']??1;
        //删除请求里的分页 ,后面手动拼在url上
        unset($_REQUEST['page']);
        //url上的参数
        $urlParams=http_build_query($_REQUEST);
        //处理数据
        $goodsModel = new GoodsModel();
        $goods = $goodsModel->getAll($page);
        extract($goods);
        //调用分页工具
        $createPage=new PageTool();
        $html=$createPage->show($count, $totalPage, $pageSize, $page, $urlParams);
        //分配
        $this->assign("goods",$goods);
        $this->assign("html",$html);
        //显示页面
        $this->display("index");
    }
    //添加商品
    public function add(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //添加保存
            var_dump($_POST);
            var_dump($_FILES);
            //接收数据
            $data = $_POST;
            $good_img = $_FILES['img'];
            //处理文件
            $upload = new UploadTool();
            $good_img_url = $upload->up("goods_img",$good_img); //返回图片路径
            if ($good_img_url ===false){  //失败
                self::redirect("index.php?p=Admin&c=Goods&a=add","商品上传图失败".$upload->getError(),2);
            }
            //成功 制作缩略图
            $imageTool = new ImageTool();
            $thumb_logo = $imageTool->thumbImage($good_img_url,150,150);
            if ($thumb_logo ===false ){  //失败
                self::redirect("index.php?p=Admin&c=Goods&a=add","制作商品缩略图失败".$imageTool->getError(),2);
            }
            //成功就将缩略图保存到$data里
            $data['img'] = $thumb_logo;
            //删除原图片
            @unlink($good_img_url);
            //处理数据
//            var_dump($data);die;
            $goodsModel = new GoodsModel();
            $res = $goodsModel->add($data);
            if ($res ===false){  //添加失败
                self::redirect("index.php?p=Admin&c=Goods&a=add","添加商品失败".$goodsModel->getError(),2);
            }
            //成功,跳转到首页
            self::redirect("index.php?p=Admin&c=Goods&a=index");
            //处理数据
            //显示页面
        }else{
            //展示
            $this->display("add");
        }
    }
    //修改商品
    public function edit(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //修改保存
            var_dump($_POST);
            var_dump($_FILES);
            //接收数据
            $data = $_POST;
            //判断是否更改商品图
            if ($_FILES['img']['error'] !="4"){ //不等于4就是上传了
                //处理上传图片
                $goods_img = $_FILES['img'];
                //处理文件
                $upload = new UploadTool();
                $goods_img_url = $upload->up("goods_img",$goods_img); //返回图片路径
                if ($goods_img_url ===false){  //失败
                    self::redirect("index.php?p=Admin&c=Goods&a=edit&id=".$data['goods_id'],"上传商品图失败".$upload->getError(),2);
                }
                //成功 制作缩略图
                $imageTool = new ImageTool();
                $thumb_logo = $imageTool->thumbImage($goods_img_url,150,150);
                if ($thumb_logo ===false ){  //失败
                    self::redirect("index.php?p=Admin&c=Goods&a=edit&id=".$data['goods_id'],"制作商品缩略图失败".$imageTool->getError(),2);
                }
                //先删除原头像文件
                @unlink($data['img']);
                //成功就将缩略图保存到$data里
                $data['img'] = $thumb_logo;
                //删除原图片
                @unlink($goods_img_url);
            }
            //处理数据
            $goodsModel = new GoodsModel();
            $res = $goodsModel->editSave($data);
            if ($res ===false){
                self::redirect("index.php?p=Admin&c=Goods&a=edit&id=".$data['goods_id'],"修改商品失败".$goodsModel->getError(),2);
            }
            //成功
            //显示页面
            self::redirect("index.php?p=Admin&c=Goods&a=index");
        }else{
            //回显
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $goodsModel = new GoodsModel();
            $good = $goodsModel->edit($id);
            //分配
            $this->assign($good);
            //显示页面
            $this->display("edit");
        }
    }
    //移除商品
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $goodsModel = new GoodsModel();
        $rs=$goodsModel->delete($id);
        if ($rs===false){
            self::redirect('index.php?p=Admin&c=Codes&a=index','删除失败'.$goodsModel->getError(),2);
        }
        //显示页面
        self::redirect("index.php?p=Admin&c=Goods&a=index");
    }
}