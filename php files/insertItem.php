<?php
	include 'connection.php';
	include 'header.php';
?>
<?php

	
	
	$startTime = date("Y-m-d H:i:s");
	if(empty($_POST['Name']) || empty($_POST['StartBid']) || empty($_POST['Description'])) {
		header("Location: failedInsert.php");
	}
	
	$itemName = mysqli_real_escape_string($con, $_POST['Name']);
	$startBid = mysqli_real_escape_string($con, $_POST['StartBid']);
	$desc = mysqli_real_escape_string($con, $_POST['Description']);
	
	if ($_POST['AuctionOnly']) {
		$buyPrice = "None";
	}
	else {
		$buyPrice = mysqli_real_escape_string($con, $_POST['buyPrice']);
		if(preg_match("/[a-z]/i", $buyPrice) || floatVal($buyPrice) < 0){
    			header("Location: failedInsert.php");
		}
	
	}
	$methodString = "";
	$methodString .= $startTime;
	$methodString .= ' + 1 minute';
	$endTime = strtotime($methodString);
	$endTime = date('Y-m-d H:i:s', $endTime);
	

	if(preg_match("/[a-z]/i", $startBid) || floatVal($startBid) < 0){
    		header("Location: failedInsert.php");
	}
	
	
	
	
	$sql = "INSERT INTO tblItems VALUES(0,'".$itemName."',".$startBid.",".$startBid.",'".$buyPrice."',0,'".$startTime."','".$endTime."','".$_COOKIE['user']."','".$desc."')";
	mysqli_query($con, $sql);
	
	header("Location: succeedInsert.php");
	


?>
