<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');

$ops = new DbOperations($db_conn);
$errors = array();


//check if its an ajax request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
//validate user input
if(isset($_POST['fname']) && $_POST['fname']!=''){
    $fname = $ops->sanitizeInput($_POST['fname']);
}else{
    array_push($errors,"First Name cannot be empty");
}
if(isset($_POST['lname']) && $_POST['lname']!=''){
    $lname = $ops->sanitizeInput($_POST['lname']);
}else{
    array_push($errors,"Last Name cannot be empty");
}
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
    $query = "INSERT INTO user(fname,lname,email,password,date_created,time_created)VALUES('".$fname."','".$lname."','".$email."','".$hashed_password."',curdate(),curtime())";
    $ops->save($query);
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