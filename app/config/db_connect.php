<?php
session_start();
//require_once('config.php');
date_default_timezone_set("Africa/Nairobi");
class DbConnect{
    private $db_user ='root'; //User
    private $db_host ='localhost';//Host
    private $db_pass =''; //Password
    private $db_prefix='';//Database Prefix. If on a local machine just leave it blank
    private $db_name ='loans_db';
    public $conn;

    public function connectDb(){
        $this->conn = null;
        try{
            $this->conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name.';charset=utf8', $this->db_user, $this->db_pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            if(!$this->conn){
                die('Error connecting to DB Server. Check your credentials');
            }
            return $this->conn;
        }catch(PDOException $e){
            echo '<title>Connection Error!!!</title>';
            die("<font color='red'>Error connecting to database:</font>".$e->getMessage());
        
        }

    }

}

$db = new DbConnect();
$db->connectDb();






?>