<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');

$ops = new DbOperations($db_conn);

//check if its an ajax request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    $loan_id =  $ops->sanitizeInput($_POST['item_id']);

    //confirm if loan has been approved
    $query = "SELECT id FROM loan_request WHERE id='".$loan_id."' AND status !='N' LIMIT 1";
    $check =  $ops->recordExists($query);
    if($check==1){
        die("<div class='alert alert-danger'> Loan application has already been actioned! </div>");
    }

    //update loan status
    $query = "UPDATE loan_request SET status='A' WHERE id='".$loan_id."'LIMIT 1";
    $ops->save($query);

    //lets fetch the loan details and disburse the amount
    $query = "SELECT lr.id AS item_id, lr.amount,lr.customer_id,lr.product_id,lr.period, prod.int_rate FROM loan_request AS lr LEFT JOIN product AS prod ON prod.id  = lr.product_id 
 WHERE lr.id='".$loan_id."' LIMIT 1";
    $stat = $ops->getData($query);
    $row_count = $stat->rowCount();
    if($row_count>=1){
        $loan_row = $stat->fetch(PDO::FETCH_ASSOC);  
    }

    //make the disbursement
    $query = "INSERT INTO statement (customer_id,trans_date,cr_dr,amount,trans_type,loan_id,user_id)VALUES('".$loan_row['customer_id']."',curdate(),'C','".$loan_row['amount']."','RECEIPT','".$loan_row['item_id']."','".$_SESSION['LNS_USER_ID']."')";
    $ops->save($query);

    //simple interest
    $interest = ($loan_row['amount'] * $loan_row['period']  * $loan_row['int_rate'])/100;
    $query = "INSERT INTO statement (customer_id,trans_date,cr_dr,amount,trans_type,loan_id,user_id)VALUES('".$loan_row['customer_id']."',curdate(),'C','".$interest."','RECEIPT','".$loan_row['item_id']."','".$_SESSION['LNS_USER_ID']."')";
    $ops->save($query);
    //update loan status
    $query = "UPDATE loan_request SET status='D' WHERE id='".$loan_id."'LIMIT 1";
    $ops->save($query);


    echo "<div class='alert alert-success'>Loan approved and disbursed successfully!</div>";



}else{
    die("<div class='alert alert-danger'>Invalid Request</div>");
}