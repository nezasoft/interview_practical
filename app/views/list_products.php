<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');


$ops = new DbOperations($db_conn);
$query = "SELECT prod.id AS item_id, prod.prod_name, prod.prod_code, prod.min_amount,prod.max_amount, prod.int_rate, curr.curr_desc FROM product AS prod LEFT JOIN currency AS curr ON curr.id = prod.currency_id ORDER BY prod_name ASC";
$stat = $ops->getData($query);
$row_count = $stat->rowCount();
if($row_count>=1){
    $rows = $stat->fetchAll(PDO::FETCH_ASSOC);
    
}

?>

<div class="row" style="margin:10px; padding:10px;">
    <div class="col-md-12">
        <h5> Loan Products</h5>
        <hr/>
        <table  width="100%" class="table table-primary table-striped" >
            <thead>
            <tr>
            <th>#</th>
			<th>Product Name</th>
			<th>Product Code</th>
            <th>Min. Amount</th>
            <th>Max. Amount</th>
            <th>Interest Rate</th>
            <th>Currency</th>
            <th>Action</th>

            </tr>
            </thead>         
            <tbody>
            <?php
            foreach($rows as $row){
            ?>
            <tr>  
                <td><?php echo $row['item_id']; ?></td>
				<td><?php echo $row['prod_name']; ?></td>
                <td><?php echo $row['prod_code']; ?></td>	
                <td><?php echo $row['min_amount']; ?></td>	
                <td><?php echo $row['max_amount']; ?></td>	
                <td><?php echo $row['int_rate']; ?></td>	
                <td><?php echo $row['curr_desc']; ?></td>				
                <td><a href="#" class="" onclick=editItem(<?php echo $row['item_id']; ?>) >Edit Item</td>				
            </tr>
            <?php } ?>


        </table>

</div>
</div>

<script>

</script>