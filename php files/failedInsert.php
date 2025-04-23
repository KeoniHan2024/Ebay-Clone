<?php
	include 'connection.php';
	include 'header.php';
	
		echo "<div>
			<h>Some values may have not been in the right format</h>
			<p>If the website doesn't redirect you back in 3 seconds click the link below</p>
			<a href=addItem.php>Back to adding page</a>
			<a href=home.php>Back to home page</a>
		</div>";

	
	header("Refresh: 3; URL=addItem.php");
?>

