<?php

$db = new DbConnect();
$db_conn = $db->connectDb();
class DbOperations{
    private $conn;
    //Db Connection
    public function __construct($db){
      if($db!=null){
      $this->conn=$db;
      }
      
    }
    public function Save($query){
        try{
            $this->conn->beginTransaction();
            $stat = $this->conn->prepare($query);
            $stat->execute();
            $this->conn->commit();
            echo "<div class='alert alert-success'>Record saved successfully!</div>";
        }catch(Exception $e){
            $this->conn->rollback();
            echo "<div class='alert alert-danger'>DB Error : ".$e->getMessage()."</div>";
        }
    }
    
    public function Update($query){
        try{
            $this->conn->beginTransaction();
            $stat = $this->conn->prepare($query);
            $stat->execute();
            $this->conn->commit();
            echo "<div class='alert alert-success'>Record updated successfully!</div>";
        }catch(Exception $e){
            $this->conn->rollback();
            echo "<div class='alert alert-danger'>DB Error : ".$e->getMessage()."</div>";
        }
    }

    public function recordExists($query){      
        $stat = $this->conn->prepare($query);
        $stat->execute();
        $row_count = $stat->rowCount();
        return $row_count;
    }
    public function getData($query){

            $stat = $this->conn->prepare($query);
            $stat->execute();
            return $stat;
            
    }

    public function sanitizeInput($var){
        $var= strip_tags($var);
        $var=htmlentities($var);
        $var = trim($var);
        $var = str_replace("'"," ",$var);
        return $var;
    }

    public function createPasswordHash($password){
        global $conn;
        return hash_hmac('sha256',$password, 'Walter12345', true);
    }
}


?>