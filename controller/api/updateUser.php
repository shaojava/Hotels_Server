<?php
    error_reporting(0);
    require_once '../../model/PdoMySQL.class.php';
    require_once '../../model/config.php';
    require_once 'Response.php';

    class Updater{
        private  $tableName = "user";
        private  $telephone = "";           //手机号码
        private  $password = "";            //密码
        private  $type = 0;                 //操作类型 1:昵称；2:性别；3:生日：4:密码;5：头像
        private  $nickName = "";            //用户名
        private  $gender = "";              //性别
        private  $birthday  = "";           //生日
        private  $avator = "";              //用户头像


        protected static $_instance = null;
        protected function __construct(){
            //disallow new instance
        }
        protected function __clone(){
            //disallow clone
        }
        public function getInstance(){
            if (self::$_instance === null) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function updateInfo(){

            self.$this->telephone = $_GET["telephone"];
            self.$this->nickName = $_GET["nickname"];
            self.$this->type = $_GET["type"];
            self.$this->gender = $_GET["gender"];
            self.$this->birthday = $_GET["birthday"];
            self.$this->password = $_GET["password"];



            $pdo=new PdoMySQL();
             $pdo->query("set names utf8");
            if ($this->type == 1) {
                $sql = 'update user set nickname="'.$this->nickName.'" where telephone = "'.$this->telephone.'";';  
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                Response::show(200,'success',"昵称更改成功",'json'); 
                
            }else if ($this->type == 2) {
                $sql = 'update user set gender="'.$this->gender.'" where telephone = "'.$this->telephone.'";';
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                Response::show(200,'success',"性别更改成功",'json');
            }else if ($this->type == 3) {
                $sql = 'update user set birthday="'.$this->birthday.'" where telephone = "'.$this->telephone.'";';  
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                Response::show(200,'success',"生日更改成功",'json');
            }else{
                $sql = 'update user set password="'.$this->password.'" where telephone = "'.$this->telephone.'";'; 
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
                Response::show(200,'success',"密码更改成功",'json'); 
            }
        }
    }

    $api = Updater::getInstance();
    $api->updateInfo();
?>