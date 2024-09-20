<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');


$ops = new DbOperations($db_conn);
$query = "SELECT cr.curr_desc, lr.id AS item_id, lr.loan_no, lr.amount, lr.`status`,lr.period, prod.prod_name, prod.prod_code, c.customer_name FROM loan_request AS lr 
LEFT JOIN product AS prod ON prod.id = lr.product_id  LEFT JOIN currency AS cr ON cr.id = prod.currency_id 
LEFT JOIN customer AS c ON c.id = lr.customer_id WHERE lr.status='D' ORDER BY lr.id DESC";
$stat = $ops->getData($query);
$row_count = $stat->rowCount();
if($row_count>=1){
    $loans = $stat->fetchAll(PDO::FETCH_ASSOC);  
}
?>

<div class="row" style="margin:10px; padding:10px;">
    <div class="col-md-4">
        <h5>   New Loan Repayment</h5>
        <hr/>   
         
              <div class="form-group">
                <label for="Customer Name">Loan No</label>
                <select class="form-control" id="Loan">
                <option value="">{Select Customer Loan }</option>
                <?php 
                foreach($loans as $row){
                ?>
                    <option value="<?php echo $row['item_id']; ?>"><?php echo $row['customer_name']."--".$row['loan_no']."--".$row['prod_name']."-".number_format($row['amount'],2,'.',','); ?></option>
                <?php
                }
                ?>
              </select>
                <small id="loan_error" class="form-text text-muted"><font color="red">Select Loan No</font></small>
              </div>
           
              <div class="form-group">
                <label for="Amount">Amount</label>
                <input type="text" autocomplete="off" class="form-control" id="Amount" placeholder="Enter Amount">
                <small id="amount_error" class="form-text text-muted"><font color="red">Enter Amount</font></small>
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
$("#loan_error").hide();
$("#amount_error").hide();
$(document).ready(function(){
    //hande click event
    $("#submit").click(function(){
        $("#response").empty();
        loan = $("#Loan").val();
        amount = $("#Amount").val();
        error = false;

		if(loan ===''){
		error = true;
		$("#Loan").css("border-color","#FE0F03");
		$("#Loan").focus();	
		$("#loan_error").show();
		}else{
		  $("#loan_error").hide();
		  $("#Loan").css("border-color","#30C700");
		 
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
 
 


        if(error==false){	
		$("#submit").hide();
		$("#loader").show();
		//data values
		var myData =  'loan=' + loan +  '&amount=' + amount; //build a post data structure
		jQuery.ajax({
		type: "POST", // Post / Get method
		url: "process/save_loan_repayment.php", //Where form data is sent on submission
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