<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');
$ops = new DbOperations($db_conn);
$query = "SELECT curr.curr_desc, stat.id AS item_id, prod.prod_code, c.customer_name,lr.loan_no,lr.amount, lr.`status`, prod.prod_name, stat.trans_type, stat.amount,SUM(IF(stat.cr_dr='D',stat.amount,0)) AS debitBal, SUM(IF(stat.cr_dr='C',stat.amount,- stat.amount)) AS Bal 
FROM statement AS stat LEFT JOIN loan_request AS lr ON lr.id = stat.loan_id LEFT JOIN customer AS c ON c.id = lr.customer_id
LEFT JOIN product AS prod ON prod.id = lr.product_id
LEFT JOIN currency AS curr ON curr.id = prod.currency_id
 GROUP  BY stat.loan_id ORDER BY lr.id DESC";
$stat = $ops->getData($query);
$row_count = $stat->rowCount();
if($row_count>=1){
    $rows = $stat->fetchAll(PDO::FETCH_ASSOC);  
}
?>
<div class="row" style="margin:10px; padding:10px;">
    <div class="col-md-12">
        <h5> Loan Report</h5>
        <table  width="100%" class="table table-primary table-striped"  >
            <thead>
            <tr>
            <th>#</th>
			<th>Application No</th>
			<th>Customer Name</th>
            <th>Loan Type</th>
            <th>Loan Amount</th>
            <th>Disbursed Amount</th>
            <th>Repaid Amount</th>
            <th>Balance</th>
            </tr>
            </thead>         
            <tbody>
            <?php
            foreach($rows as $row){
            ?>
            <tr>  
                <td><?php echo $row['item_id']; ?></td>
                <td><?php echo $row['loan_no']; ?></td>
				<td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['prod_name']; ?></td>	
                <td><?php echo $row['curr_desc'] ." " .number_format($row['amount'],2,'.',','); ?></td>	
                <td><?php echo $row['curr_desc'] ." " .number_format($row['amount'],2,'.',','); ?></td>	
                <td><?php echo $row['curr_desc'] ." " .number_format($row['debitBal'],2,'.',','); ?></td>	
                <td><?php echo $row['curr_desc'] ." " .number_format($row['Bal'],2,'.',','); ?></td>
  	
            </tr>
            <?php } ?>


        </table>
  
</div>
</div>      