
<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');

$ops = new DbOperations($db_conn);
$errors = array();

//check if its an ajax request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

//validate user input
if(isset($_POST['product']) && $_POST['product']!=''){
    $product = $ops->sanitizeInput($_POST['product']);
}else{
    array_push($errors,"Product cannot be empty");
}
if(isset($_POST['product_code']) && $_POST['product_code']!=''){
    $product_code = $ops->sanitizeInput($_POST['product_code']);
}else{
    array_push($errors,"Product code cannot be empty");
}
if(isset($_POST['min_amount']) && $_POST['min_amount']!=''){
    $min_amount = $ops->sanitizeInput($_POST['min_amount']);
}else{
    array_push($errors,"Min amount cannot be empty");
}
if(isset($_POST['int_rate']) && $_POST['int_rate']!=''){
    $int_rate = $ops->sanitizeInput($_POST['int_rate']);
}else{
    array_push($errors,"Interest rate cannot be empty");
}
if(isset($_POST['max_amount']) && $_POST['max_amount']!=''){
    $max_amount = $ops->sanitizeInput($_POST['max_amount']);
}else{
    array_push($errors,"Max amount cannot be empty");
}
if(isset($_POST['currency']) && $_POST['currency']!=''){
    $currency = $ops->sanitizeInput($_POST['currency']);
}else{
    array_push($errors," currency cannot be empty");
}

if(empty($errors)){
    //check if record exists
    $query = "SELECT id FROM product WHERE prod_name='".$product."' LIMIT 1";
    $check =  $ops->recordExists($query);
    if($check==1){
        die("<div class='alert alert-danger'> Record exists ! </div>");
    }
    $query = "INSERT INTO product(prod_name,prod_code,min_amount,max_amount,int_rate,currency_id)VALUES('".$product."','".$product_code."','".$min_amount."','".$max_amount."','".$int_rate."','".$currency."')";
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