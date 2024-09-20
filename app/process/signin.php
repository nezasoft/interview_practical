<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');

$ops = new DbOperations($db_conn);
$errors = array();

//check if its an ajax request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
//validate user input
if(isset($_POST['email']) && $_POST['email']!=''){
    $email = $ops->sanitizeInput($_POST['email']);
}else{
    array_push($errors,"Email cannot be empty");
}

if(isset($_POST['password']) && $_POST['password']!=''){
    $password = $ops->sanitizeInput($_POST['password']);
    $hashed_password = $ops->createPasswordHash($password);
}else{
    array_push($errors,"Password cannot be empty");
}

if(empty($errors)){
    $query = "SELECT * FROM user WHERE email='".$email."' AND password='".$hashed_password."' LIMIT 1";
    $stat = $ops->getData($query);
    $row_count = $stat->rowCount();
    if($row_count>=1){
        $row = $stat->fetch(PDO::FETCH_ASSOC);
        //save details in session
        $_SESSION['LNS_USER_ID'] = $row['id'];
        $_SESSION['LNS_USER_FNAME'] = $row['fname'];
        echo "<div class='alert alert-success'>Authentication successful!</div>";
       echo "<script>
        window.setTimeout(function(){
       window.location.href = '?home';
       }, 3000);
       </script>";
    }else{
        echo "<div class='alert alert-danger'>Invalid username / password</div>";

    }
    //save
}else{
    foreach($errors as $item){
        echo '<div class="alert alert-danger">'.$item.'</div><br/>';
    }
}

}else{
    die("<div class='alert alert-danger'>Invalid Request</div>");
}


?>