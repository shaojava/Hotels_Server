<?php

/**
 * Created by PhpStorm.
 * User: geek
 * Date: 2017/3/9
 * Time: 上午9:24
 */

header('content-type:text.html;charset=utf-8');
error_reporting(0);
require_once '../../model/PdoMySQL.class.php';
require_once '../../model/config.php';
require_once 'Response.php';


class Pay
{
    private  $tableName = "order";
    private  $telephone = 0;
    private  $orderId = "";

    protected static  $_instance = null;

    private  function  __construct()
    {
    }

    private  function  __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function  sharedInstance(){
        if(self::$_instance == null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function pay(){
        $mysqlPdo = new PdoMySQL();

        self.$this->telephone = $_REQUEST["telephone"];
        self.$this->orderId = $_REQUEST["orderId"];

        if($this->telephone == ""){
            Response::show(201,"fail","非安全的数据请求","json");
        }
        $userRows = $mysqlPdo->find('user',"telephone='$this->telephone'");
        if($userRows[0]["telephone"] != $this->telephone){
            Response::show(201,"fail","非安全的数据请求","json");
        }

        $pdo=new PDO('mysql:host=localhost;dbname=db_Hotel','root','root');
        $pdo->query("set names utf8");
        $sql = 'update `order` set `status`=1 where `orderId` = "'.$this->orderId.'";';
        $stmt=$pdo->prepare($sql);
        $res = $stmt->execute();
        if($res){
            //酒店下单成功
            Response::show(200,"success","","json");
        }else{
            //酒店下单失败
            Response::show(201,"fail","json");
        }

    }
}

$payer = Pay::sharedInstance();
$payer->pay();
?>