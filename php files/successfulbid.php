<?php
	include 'connection.php';
	include 'header.php';
	$ID = mysqli_real_escape_string($con, $_GET['ID']);
	echo "<div>
	<h>Bid has been submitted successfully!!!</h>
	<p>If the website doesn't redirect you back in 3 seconds click the link below</p>
			<a href=bidding.php?ID=".$ID.">Back to bidding page</a>
			<a href=home.php>Back to home page</a>
	</div>";
	
	header("Refresh: 3; URL=bidding.php?ID=".$ID."");
?>

