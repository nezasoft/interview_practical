
<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');

$ops = new DbOperations($db_conn);
$errors = array();

//check if its an ajax request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
$item_id = $ops->sanitizeInput($_POST['item_id']);
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

    $query = "UPDATE customer SET customer_name='".$customer."',email='".$email."',dob='".$dob."',phone_no='".$phone."',id_no='".$idno."',phy_address='".$physical."' WHERE id='".$item_id."' LIMIT 1";
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