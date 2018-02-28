<?php

/**
 * Created by PhpStorm.
 * User: www29
 * Date: 2018/2/9
 * Time: 15:29
 */
class PlatformController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['authorinfo'])) {
            if (isset($_COOKIE['id']) && isset($_COOKIE['password'])) {
                $id = $_COOKIE['id'];
                $password = $_COOKIE['password'];
                $authorModel = new authorModel();
                $authorinfo = $authorModel->getCookieCheck($id, $password);
                if ($authorinfo === false) {
                    self::redirect('index.php?p=Home&c=Login&a=index', '非法登录', 2);
                }
                return null;
            }
            self::redirect('index.php?p=Home&c=Login&a=index', '请先登录', 2);
        }
        //有session就跳转到首页
        self::redirect('index.php?p=Home&c=Index&a=index');
    }
}