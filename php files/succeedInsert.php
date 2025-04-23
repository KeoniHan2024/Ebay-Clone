<?php
	include 'connection.php';
	include 'header.php';
	echo "<div>
	<h>ITEM LISTED SUCCESSFULLY!!!</h>
	<p>If the website doesn't redirect you back in 3 seconds click the link below</p>
			<a href=home.php>Back to home page</a>
	</div>";
	
	header("Refresh: 3; URL=home.php");
?>

