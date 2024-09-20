
<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');

$ops = new DbOperations($db_conn);
$errors = array();

//check if its an ajax request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

//validate user input
if(isset($_POST['customer']) && $_POST['customer']!=''){
    $customer = $ops->sanitizeInput($_POST['customer']);
}else{
    array_push($errors,"Customer cannot be empty");
}
if(isset($_POST['email']) && $_POST['email']!=''){
    $email = $ops->sanitizeInput($_POST['email']);
}else{
    array_push($errors,"Email cannot be empty");
}
if(isset($_POST['dob']) && $_POST['dob']!=''){
    $dob= $ops->sanitizeInput($_POST['dob']);
}else{
    array_push($errors,"Dob cannot be empty");
}
if(isset($_POST['phone']) && $_POST['phone']!=''){
    $phone = $ops->sanitizeInput($_POST['phone']);
}else{
    array_push($errors,"phone cannot be empty");
}

if(isset($_POST['idno']) && $_POST['idno']!=''){
    $idno = $ops->sanitizeInput($_POST['idno']);
}else{
    array_push($errors,"ID No cannot be empty");
}

if(isset($_POST['physical']) && $_POST['physical']!=''){
    $physical = $ops->sanitizeInput($_POST['physical']);
}else{
    array_push($errors,"Physical address cannot be empty");
}


if(empty($errors)){
    //check if record exists
    $query = "SELECT id FROM customer WHERE customer_name='".$customer."' LIMIT 1";
    $check =  $ops->recordExists($query);
    if($check==1){
        die("<div class='alert alert-danger'> Record exists ! </div>");
    }

    $query = "INSERT INTO customer(customer_name,email, dob, phone_no,id_no,phy_address)VALUES('".$customer."','".$email."','".$dob."','".$phone."','".$idno."','".$physical."')";
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