
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
if(isset($_POST['customer']) && $_POST['customer']!=''){
    $customer = $ops->sanitizeInput($_POST['customer']);
}else{
    array_push($errors,"Customer cannot be empty");
}
if(isset($_POST['amount']) && $_POST['amount']!=''){
    $amount = $ops->sanitizeInput($_POST['amount']);
}else{
    array_push($errors,"Amount cannot be empty");
}
if(isset($_POST['period']) && $_POST['period']!=''){
    $period = $ops->sanitizeInput($_POST['period']);
}else{
    array_push($errors,"Period cannot be empty");
}

//lets fetch the product details
$query = "SELECT id, min_amount, max_amount FROM product WHERE id ='".$product."' LIMIT 1";
$stat = $ops->getData($query);
$row_count = $stat->rowCount();
if($row_count>=1){
    $prod_row = $stat->fetch(PDO::FETCH_ASSOC);   
}
if($amount>$prod_row['max_amount']){
    array_push($errors,"The amount requested cannot be more than the maximum limit allowed of <strong>".number_format($prod_row['max_amount'],2,'.',',')."</strong>");
}
if($amount<$prod_row['min_amount']){
    array_push($errors,"The amount requested cannot be less than the minimum limit allowed of <strong>".number_format($prod_row['min_amount'],2,'.',',')."</strong>");
}

$loan_no = rand(1,10000000000);
if(empty($errors)){
    //check if record exists
    $query = "SELECT id FROM loan_request WHERE product_id='".$product."' AND status='N' AND customer_id='".$customer."' AND amount='".$amount."' LIMIT 1";
    $check =  $ops->recordExists($query);
    if($check==1){
        die("<div class='alert alert-danger'>Application request already made ! </div>");
    }


    $query = "INSERT INTO loan_request(customer_id,product_id,amount,period,loan_no)VALUES('".$customer."','".$product."','".$amount."','".$period."','".$loan_no."')";
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