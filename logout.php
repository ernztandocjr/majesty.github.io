<?php
session_start();
require('connection.php');

	$action = "Log out successful";

	if($_SESSION["account"] == "Admin" || $_SESSION["account"] == "Super-Admin"){
        $accountID = $_SESSION["account"]."-".substr(str_repeat(0, 3).$_SESSION['acctID'], - 3);
    }else{
        $accountID = $_SESSION["username"];
    }

    date_default_timezone_set("Asia/Manila");
    $date = date("m/d/Y");
    $time = date("H:i:s a");

    $sqlx = "INSERT INTO tbl_activitylogs(actAccountID,actActions,actDate,actTime) VALUES ('$accountID','$action','$date','$time')";

    $resultx = mysqli_query($conn, $sqlx);

session_destroy();
header("location:login.php");
?>