<?php
require_once('config/db_connect.php');
require_once('modules/db_operations.php');
$ops = new DbOperations($db_conn);
?>
<!DOCTYPE html>
<html lang="en"> 
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="css/bootstrap-4.2.1.css">
<script src="js/bootstrap-4.2.1.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<title>Loan Management System</title>
</head>

<body>
    <div class="containter">
        <div id="content">
            <?php

            if(isset($_SESSION['LNS_USER_ID']) && $_SESSION['LNS_USER_ID']!==''){
                include('views/home.html');
            }else{
                if(isset($_GET['signup'])){
                    include('views/signup.html');
                }else{
                    include('views/signin.html');
                }
  
            }
            ?>


        </div>
    </div>
</body>
</html>