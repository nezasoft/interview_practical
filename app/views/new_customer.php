<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');


$ops = new DbOperations($db_conn);
$query = "SELECT id, curr_desc FROM currency ORDER BY curr_desc ASC";
$stat = $ops->getData($query);
$row_count = $stat->rowCount();
if($row_count>=1){
    $rows = $stat->fetchAll(PDO::FETCH_ASSOC);
    
}

?>
<div class="row" style="margin:10px; padding:10px;">
    <div class="col-md-4">
        <h5> Add New Customer</h5>
        <hr/>
    
         
              <div class="form-group">
                <label for="Customer Name">Customer Name</label>
                <input type="text" autocomplete="off" class="form-control" id="Customer" placeholder="Enter Customer Name">
                <small id="customer_error" class="form-text text-muted"><font color="red">Enter Customer Name</font></small>
              </div>
              <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" autocomplete="off" class="form-control" id="Email" placeholder="Enter Email">
                <small id="email_error" class="form-text text-muted"><font color="red">Enter Email Address </font></small>
              </div>
              <div class="form-group">
                <label for="Date of Birth">Date of Birth</label>
                <input type="text" autocomplete="off" value="<?php echo date('Y-m-d');?>" class="form-control" id="Dob" placeholder="Enter Date of Birth">
                <small id="dob_error" class="form-text text-muted"><font color="red">Enter Date of birth</font></small>
              </div>
              <div class="form-group">
              <label for="Phone No">Phone No</label>
              <input type="text" autocomplete="off" class="form-control" id="Phone" placeholder="Enter Phone No">
              <small id="phone_error" class="form-text text-muted"><font color="red">Enter Phone No</font></small>
			  </div>
			  <div class="form-group">
              <label for="ID No">ID No</label>
              <input type="text" autocomplete="off" class="form-control" id="IDNo" placeholder="Enter ID No">
              <small id="idno_error" class="form-text text-muted"><font color="red">Enter ID No</font></small>
			  </div>
			  <div class="form-group">
              <label for="Physical Address">Physical Address</label>
              <input type="text" autocomplete="off" class="form-control" id="Physical" placeholder="Enter Physical Address">
              <small id="physical_error" class="form-text text-muted"><font color="red">Enter Physical Address</font></small>
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
$("#customer_error").hide();
$("#email_error").hide();
$("#dob_error").hide();
$("#idno_error").hide();
$("#phone_error").hide();
$("#physical_error").hide();
$(document).ready(function(){
    //hande click event
    $("#submit").click(function(){
        $("#response").empty();
        customer = $("#Customer").val();
        email = $("#Email").val();
        dob = $("#Dob").val();
        phone = $("#Phone").val();
        idno = $("#IDNo").val();
		physical = $("#Physical").val();
        error = false;

	
		if(customer ===''){
		error = true;
		$("#Customer").css("border-color","#FE0F03");
		$("#Customer").focus();	
		$("#customer_error").show();
		}else{
		  $("#customer_error").hide();
		  $("#Customer").css("border-color","#30C700");
		 
		}

        if(email ===''){
		error = true;
		$("#Email").css("border-color","#FE0F03");
		$("#Email").focus();	
		$("#email_error").show();
		}else{
		  $("#email_error").hide();
		  $("#Email").css("border-color","#30C700");
		 
		}
		
		if(dob===''){
			error = true;
			$("#Dob").css("border-color","#FE0F03");
			$("#Dob").focus();	
			$("#dob_error").show();
		
		}else{
		    $("#dob_error").hide();
		    $("#Dob").css("border-color","#30C700");
		}
 
        if(idno===''){
			error = true;
			$("#IDNo").css("border-color","#FE0F03");
			$("#IDNo").focus();	
			$("#idno_error").show();
		
		}else{
		    $("#idno_error").hide();
		    $("#IDNo").css("border-color","#30C700");
		}

		if(phone===''){
			error = true;
			$("#Phone").css("border-color","#FE0F03");
			$("#Phone").focus();	
			$("#phone_error").show();
		
		}else{
		    $("#phone_error").hide();
		    $("#Phone").css("border-color","#30C700");
		}

        if(physical===''){
			error = true;
			$("#Physical").css("border-color","#FE0F03");
			$("#Physical").focus();	
			$("#physical_error").show();
		
		}else{
		    $("#physical_error").hide();
		    $("#Physical").css("border-color","#30C700");
		}
 


        if(error==false){	
		$("#submit").hide();
		$("#loader").show();
		//data values
		var myData =  'customer=' + customer +  '&email=' + email +  '&phone=' + phone +  '&idno=' + idno +  '&physical=' + physical  +  '&dob=' + dob; //build a post data structure
		jQuery.ajax({
		type: "POST", // Post / Get method
		url: "process/save_customer.php", //Where form data is sent on submission
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