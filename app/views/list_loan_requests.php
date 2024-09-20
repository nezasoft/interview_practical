<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');


$ops = new DbOperations($db_conn);
$query = "SELECT cr.curr_desc, lr.id AS item_id, lr.loan_no, lr.amount, lr.`status`,lr.period, prod.prod_name, prod.prod_code, c.customer_name FROM loan_request AS lr 
LEFT JOIN product AS prod ON prod.id = lr.product_id  LEFT JOIN currency AS cr ON cr.id = prod.currency_id LEFT JOIN customer AS c ON c.id = lr.customer_id ORDER BY lr.id DESC";
$stat = $ops->getData($query);
$row_count = $stat->rowCount();
if($row_count>=1){
    $rows = $stat->fetchAll(PDO::FETCH_ASSOC);  
}
?>
<div class="row" style="margin:10px; padding:10px;">
    <div class="col-md-12">
        <h5> Loan Applications</h5>
        <hr/>
        <table  width="100%" class="table table-primary table-striped"  >
            <thead>
            <tr>
            <th>#</th>
			<th>Application No</th>
			<th>Customer Name</th>
            <th>Loan Type</th>
            <th>Loan Amount</th>
            <th>Period</th>
            <th>Loan Status</th>
            <th>Action</th>
		
            </tr>
            </thead>         
            <tbody>
            <?php
            foreach($rows as $row){

                if($row['status']=='N'){
                    $status = 'New';
                }elseif($row['status']=='A'){
                    $status = 'Approved';
                }elseif($row['status']=='D'){
                    $status = 'Disbursed';

                }elseif($row['status']=='R'){
                    $status = 'Repaid';
                }
            ?>
            <tr>  
                <td><?php echo $row['item_id']; ?></td>
                <td><?php echo $row['loan_no']; ?></td>
				<td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['prod_name']; ?></td>	
                <td><?php echo   $row['curr_desc'] ." " .number_format($row['amount'],2,'.',','); ?></td>	
                <td><?php echo $row['period']; ?></td>	
     	
                <td><?php echo $status; ?></td>				
                <td>
                   <?php 
                    if($status == 'New'){
                        ?>
                <a href="#" class="" onclick=approveLoan(<?php echo $row['item_id']; ?>) >Approve</td>	
                        <?php

                    }
                   ?> 
                			
            </tr>
            <?php } ?>


        </table>

</div>
</div>
<div id="response"></div>
<script>
function approveLoan(item_id){
    confirm = confirm("Are you sure you want to approve this loan?");
    if (confirm==true){
        	//data values
		var myData =  'item_id=' + item_id; //build a post data structure
		jQuery.ajax({
		type: "POST", // Post / Get method
		url: "process/approve_loan.php", //Where form data is sent on submission
		dataType:"text", // Data type, HTML, json etc.
		data:myData, //Form variables
		success:function(response){
		$("#response").append(response);
    }
    });
}
}
</script>