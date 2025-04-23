<h1> Add An Item Page </h1>
<?php
	include 'connection.php';
	include 'header.php';


	// Checks to see if the cookie is still valid if not then redirects
	if(isset($_COOKIE['user']) && $_COOKIE['pass'] == true) {
		echo "<div><h2>What item would you like to add ".$_COOKIE['user']."</h2></div>";
	
	// Creates form for information to add (4 text boxes, a check box, and a submit button)
	?>
		<form method = "POST" action = "insertItem.php">
		<input type="text" name="Name" placeholder="Item Name">
		<input type="text" name="StartBid" placeholder="Starting Bid">
		<input type="text" name="buyPrice" placeholder="Buy Price">
		<input type="text" name="Description" placeholder="Description">
		<input type="checkbox" name="AuctionOnly" value= "checked" style="height:15px; width:15px;">Auction Only?
		<input type="submit" name="submit-Item" value = "Add Item">
		</form>
<?php
}
else {
		
		print_r("Cookie Expired Redirecting to Login Page");
		header("Refresh: 3; URL=index.php");
	}	
?>	

