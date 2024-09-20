<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');


$ops = new DbOperations($db_conn);
$query = "SELECT id, customer_name FROM customer ORDER BY customer_name ASC";
$stat = $ops->getData($query);
$row_count = $stat->rowCount();
if($row_count>=1){
    $customers = $stat->fetchAll(PDO::FETCH_ASSOC);   
}

$query = "SELECT id, prod_name, prod_code FROM product ORDER BY prod_name ASC";
$stat = $ops->getData($query);
$row_count = $stat->rowCount();
if($row_count>=1){
    $products = $stat->fetchAll(PDO::FETCH_ASSOC);   
}
?>

<div class="row" style="margin:10px; padding:10px;">
    <div class="col-md-4">
        <h5>   New Loan Request</h5>
        <hr/>
    
         
              <div class="form-group">
                <label for="Customer Name">Customer Name</label>
                <select class="form-control" id="Customer">
                <option value="">{Select Customer}</option>
                <?php 
                foreach($customers as $row){
                ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['customer_name']; ?></option>
                <?php
                }
                ?>
              </select>
                <small id="customer_error" class="form-text text-muted"><font color="red">Select Customer Name</font></small>
              </div>
              <div class="form-group">
                <label for="Product Name">Product Name</label>
                <select class="form-control" id="Product">
                <option value="">{Select Product}</option>
                <?php 
                foreach($products as $row){
                ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['prod_name']."-".$row['prod_code']; ?></option>
                <?php
                }
                ?>
              </select>
                <small id="product_error" class="form-text text-muted"><font color="red">Select Product Name</font></small>
              </div>
              <div class="form-group">
                <label for="Amount">Amount</label>
                <input type="text" autocomplete="off" class="form-control" id="Amount" placeholder="Enter Amount">
                <small id="amount_error" class="form-text text-muted"><font color="red">Enter Amount</font></small>
              </div>
              <div class="form-group">
                <label for="Period">Period(Years)</label>
                <input type="text" autocomplete="off" class="form-control" id="Period" placeholder="Enter Period">
                <small id="period_error" class="form-text text-muted"><font color="red">Enter Period</font></small>
              </div>     
            
            <button  id="submit" class="btn btn-primary">Save</button> 	     
          <span id="loader"><img width="50" height="50" src="img/loader.gif" />Requesting...</span>
          <div id="response" class="pt-4">
          </div>
    </div>
</div>
<script>
//Hide error messages
$("#loader").hide();
$("#product_error").hide();
$("#customer_error").hide();
$("#amount_error").hide();
$("#period_error").hide();
$(document).ready(function(){
    //hande click event
    $("#submit").click(function(){
        $("#response").empty();
        product = $("#Product").val();
        customer = $("#Customer").val();
        amount = $("#Amount").val();
        period = $("#Period").val();

        error = false;

	
		if(product ===''){
		error = true;
		$("#Product").css("border-color","#FE0F03");
		$("#Product").focus();	
		$("#product_error").show();
		}else{
		  $("#product_error").hide();
		  $("#Product").css("border-color","#30C700");
		 
		}

        if(customer ===''){
		error = true;
		$("#Customer").css("border-color","#FE0F03");
		$("#Customer").focus();	
		$("#customer_error").show();
		}else{
		  $("#customer_error").hide();
		  $("#Customer").css("border-color","#30C700");
		 
		}
		
		if(amount===''){
			error = true;
			$("#Amount").css("border-color","#FE0F03");
			$("#Amount").focus();	
			$("#amount_error").show();
		
		}else{
		    $("#amount_error").hide();
		    $("#Amount").css("border-color","#30C700");
		}
 
        if(period===''){
			error = true;
			$("#Period").css("border-color","#FE0F03");
			$("#Period").focus();	
			$("#period_error").show();
		
		}else{
		    $("#period_error").hide();
		    $("#Period").css("border-color","#30C700");
		}

 


        if(error==false){	
		$("#submit").hide();
		$("#loader").show();
		//data values
		var myData =  'product=' + product +  '&customer=' + customer +  '&amount=' + amount +  '&period=' + period ; //build a post data structure
		jQuery.ajax({
		type: "POST", // Post / Get method
		url: "process/save_loan_request.php", //Where form data is sent on submission
		dataType:"text", // Data type, HTML, json etc.
		data:myData, //Form variables
		success:function(response){
		$("#response").append(response);
		//display the success message
		$('#loader').hide();
		$('#response').show();
		$("#submit").show();
    }
		});
	}
	
	});
	
	});

</script>