<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');


$ops = new DbOperations($db_conn);
$query = "SELECT * FROM customer ORDER BY customer_name ASC";
$stat = $ops->getData($query);
$row_count = $stat->rowCount();
if($row_count>=1){
    $rows = $stat->fetchAll(PDO::FETCH_ASSOC);  
}
?>
<div class="row" style="margin:10px; padding:10px;">
    <div class="col-md-12">
        <h5> Customers</h5>
        <hr/>
        <table  width="100%" class="table table-primary table-striped"  >
            <thead>
            <tr>
            <th>#</th>
			<th>Customer Name</th>
			<th>Email</th>
            <th>Dob</th>
            <th>Phone</th>
            <th>ID No</th>
            <th>Physical Address</th>
            <th>Action</th>
		
            </tr>
            </thead>         
            <tbody>
            <?php
            foreach($rows as $row){
            ?>
            <tr>  
                <td><?php echo $row['id']; ?></td>
				<td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['email']; ?></td>	
                <td><?php echo $row['dob']; ?></td>	
                <td><?php echo $row['phone_no']; ?></td>	
                <td><?php echo $row['id_no']; ?></td>	
                <td><?php echo $row['phy_address']; ?></td>				
                <td><a href="#" class="" onclick=editItem(<?php echo $row['id']; ?>) >Edit Item</td>				
            </tr>
            <?php } ?>


        </table>

</div>
</div>

<script>

</script>