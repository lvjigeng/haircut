<?php

/**
 * 使用PDO操作数据库
 */
class PDODB
{
    //保存创建好的pdo对象
    public $pdo;
    //私有的静态成员属性
    private static $instance;
    /**
     * 初始化
     */
    private function __construct()
    {
        $config = require "./Application/Config/application.config.php";
        $this->pdo = new PDO($config['db']['dsn'],$config['db']['username'],$config['db']['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    private function __clone()
    {
    }
    //公有的静态的创建对象的方法
    public static function getInstance(){
        if(!self::$instance instanceof self){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 执行sql语句
     * @param $sql
     */
    private function query($sql){
        $stm = $this->pdo->query($sql);
        if($stm===false){
            die("执行sql语句失败!:".$this->pdo->errorInfo()[2]);
        }
        return $stm;
    }
    /**
     * 获取所有数据
     */
    public function fetchAll($sql){
        $stm = $this->query($sql);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 获取一行数据
     */
    public function fetchRow($sql){
        $stm = $this->query($sql);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * 获取一行的指定的一列
     */
    public function fetchColumn($sql,$column=0){
        $stm = $this->query($sql);
        return $stm->fetchColumn($column);
    }
    /**
     * 执行sql语句
     */
    public function execute($sql){
        $num = $this->pdo->exec($sql);
//        var_dump($num);die;
        if($num===false){//执行sql失败
            die($this->pdo->errorInfo()[2]);
        }
        if($num == 0){//没有执行到sql
            return false;
        }
        return true;
    }
}