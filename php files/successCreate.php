<?php
	include 'connection.php';
	include 'header.php';
	echo "<div>
	<h>ACCOUNT CREATED SUCCESSFULLY!!!</h>
	<p>If the website doesn't redirect you back in 3 seconds click the link below</p>
			<a href=index.php>Back to login page</a>
	</div>";
	
	header("Refresh: 3; URL=index.php");
?>

