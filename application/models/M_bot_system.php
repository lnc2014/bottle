<?php
/**
 * Description：用户账户表
 * Author: LNC
 * Date: 2016/9/21
 * Time: 22:20
 */
include_once "BaseModel.php";
class M_bot_system extends BaseModel{
    protected $_tablename = 'bot_system';
    public function __construct()
    {
        parent::__construct();
    }
}