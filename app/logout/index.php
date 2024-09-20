<?php
require_once('../config/db_connect.php');
require_once('../modules/db_operations.php');

if(isset($_GET['logout'])){
session_unset();
session_destroy();
//Redirect to the login page
echo'<script>
window.location.href="../?home";</script>';
}else{
session_unset();
session_destroy();
//Redirect to the login page
echo'<script>
window.location.href="../?home";</script>';
}
?>