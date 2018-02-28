<?php

/**
 * 基础模型类
 */
abstract class Model
{
    //保存创建好的DB对象
    protected $db;
    //保存错误信息
    protected $error;
    /**
     * 初始化
     */
    public function __construct()
    {
        $config = require "./Application/Config/application.config.php";
        $this->db = PDODB::getInstance($config['db']['dsn'],$config['db']['username'],$config['db']['password']);
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError(){
        return $this->error;
    }
}