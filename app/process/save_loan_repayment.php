<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');

$ops = new DbOperations($db_conn);
$errors = array();

//check if its an ajax request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
//validate user input
if(isset($_POST['loan']) && $_POST['loan']!=''){
    $loan_id = $ops->sanitizeInput($_POST['loan']);
}else{
    array_push($errors,"Loan cannot be empty");
}

if(isset($_POST['amount']) && $_POST['amount']!=''){
    $amount = $ops->sanitizeInput($_POST['amount']);
}else{
    array_push($errors,"Amount cannot be empty");
}


if(empty($errors)){
     //lets fetch the loan details and disburse the amount
     $query = "SELECT * FROM loan_request WHERE id='".$loan_id."' LIMIT 1";
     $stat = $ops->getData($query);
     $row_count = $stat->rowCount();
     if($row_count>=1){
         $loan_row = $stat->fetch(PDO::FETCH_ASSOC);  
     }

  //make the payment
  $query = "INSERT INTO statement (customer_id,trans_date,cr_dr,amount,trans_type,loan_id,user_id)VALUES('".$loan_row['customer_id']."',curdate(),'D','".$amount."','PAYMENT','".$loan_row['id']."','".$_SESSION['LNS_USER_ID']."')";
  $ops->save($query);
}else{
    foreach($errors as $item){
        echo '<div class="alert alert-danger">'.$item.'</div><br/>';
    }
}


}else{
    die("<div class='alert alert-danger'>Invalid Request</div>");
}
