<?php
	include 'connection.php';
	include 'header.php';
	include 'connection.php';
	$query=mysqli_query($con, "SELECT * FROM login WHERE username = '".$_SESSION['username']."'");
	$row = mysqli_fetch_assoc($query);
?>

<?php
	$currentDateTime = date("Y-m-d H:i:s");
	
	$bidAmt = mysqli_real_escape_string($con, $_POST['bidAmt']);
	$ID = mysqli_real_escape_string($con, $_GET['ID']);
	$title = mysqli_real_escape_string($con, $_GET['title']);
	$sql = "SELECT * FROM tblItems WHERE ItemID = '".$ID."'";
	
	if(preg_match("/[a-z]/i", $bidAmt) || floatVal($bidAmt) == 0){
    		header("Location: bidding.php?ID=".$ID."");
	}
	$result = mysqli_query($con, $sql);
	$queryResults = mysqli_num_rows($result);
	
	$bidAmt = floatVal($bidAmt);
	
	if ($queryResults > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if (strtotime($currentDateTime) >= strtotime($row['EndTime'])) {
				header("Location: failedBid.php?ID=".$row['ItemID']."&reason=Expired");
			}
			else if (floatval($bidAmt) <= floatVal($row['CurrentBid'])) {
				header("Location: failedBid.php?ID=".$row['ItemID']."&reason=TooLow");
			}
			else {
				$sql2 = "INSERT INTO tblBids (ItemID, UserID, Time, Amount) VALUES ('".$ID."', '".$_COOKIE['user']."', '".$currentDateTime."', '".$bidAmt."')";
				$result2 = mysqli_query($con, $sql2);
				header("Location: successfulbid.php?ID=".$row['ItemID']."");
			}
		}
				
	}
	
	
	
	
?>
