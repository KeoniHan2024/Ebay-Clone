<?php 

session_start();


if (isset($_SESSION['username'])) {
	
	include 'connection.php';
	$query=mysqli_query($con, "SELECT * FROM login WHERE username = '".$_SESSION['username']."'");
	$row = mysqli_fetch_assoc($query);
	$cookieUsername = $_COOKIE['user'];
	if (isset($cookieUsername)) {
		print("Cookie is valid");
	}
	else {
		print("Cookie is expired");
	}
 ?>

<!DOCTYPE html>

<html>

<head>

    <title>HOME</title>

    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

     <h1>Hello, <?php echo $_SESSION['name']; ?></h1>

     <a href="addItem.php">Add Item</a>
     <a href="logout.php">Logout</a>
     <form action = 'search.php', method="POST">
	<input type="text" name="search" placeholder="Search">
	<input type="submit" name="submit-search" value = "Search">

	searchBy:
	<input type = "radio" name="searchField"
	<?php if (isset($searchField) && $searchField=="description") echo "checked";?>
	checked="checked" value="description" style="height:15px; width:15px;">Description
	
	<input type="radio" name="searchField"
	<?php if (isset($searchField) && $searchField == "seller") echo "checked";?>
	value="seller" style="height:15px; width:15px;">Seller

	<input type="radio" name="searchField"
	<?php if (isset($searchField) && $searchField == "category") echo "checked";?>
	value="category" style="height:15px; width:15px;">Category
</form>


	<h1>HOME PAGE</h1>
	<h2>Top 20 Featured Items (Sorted from cheapest to most expensive):</h2>

	<div class="article-container">
		<?php
			include "connection.php";
			$dollarSign = "$";
			$nameHeader = "Item Name:";
			$pricesHeader = "First Bid | Current Bid | Buy Price";
			$numBidsHeader = "Number of Bids";
			$descriptionHeader = "Description";
			$sellerHeader = "Seller Name";
			$categoriesHeader = "Categories";
			$seperator = "=====================================================================";
			$timeHeader = "StartTime | EndTime";
			$sql = "(SELECT * FROM tblItems WHERE EndTime > NOW() ORDER BY CurrentBid ASC) UNION (SELECT * FROM tblItems WHERE EndTime <= NOW() ORDER BY CurrentBid ASC) LIMIT 20";
			$result = mysqli_query($con, $sql);
			$queryResults = mysqli_num_rows($result);
			if ($queryResults > 0) {
				while($row = mysqli_fetch_assoc($result)) {
						$itemID = $row['ItemID'];
						$sql2 = "SELECT Category FROM tblCategories WHERE ItemID = '".$itemID."'";
						$result2 = mysqli_query($con, $sql2);
						$queryResult2 = mysqli_num_rows($result2);
						$sql3 = "SELECT EndTime FROM tblItems WHERE ItemID = '".$itemID."' AND EndTime > NOW()";
						$result3 = mysqli_query($con, $sql3);
						$queryResult3 = mysqli_num_rows($result3);
						echo "<div>
							<p>".$seperator."</p>
							</div>";
						if ($queryResult3 == 0) {
							echo "<div>
								<h3>NOT ACTIVE (SOLD)</h3>
								</div>";
						}
						else {
							echo "<div>
								<h3>ACTIVE LISTING</h3>
								</div>";
							echo "<a href='bidding.php?ID=".$row['ItemID']."'>Bid on Item</a>";
						}
						if ($queryResult2 > 0) {
							echo "<div>
								<h3>".$categoriesHeader." </h3>
								</div>";
							while($row2 = mysqli_fetch_assoc($result2)) {
								echo "<div>
									<p>".$row2['Category']."</p>
									</div>";
							}	
						}
					echo "<div>
						<h3>".$nameHeader."</h3>
						<p>".$row['Name']."</p>
						<h3>".$sellerHeader."</h3>
						<p>".$row['SellerID']."</p>
						<h3>".$pricesHeader."</h3>
						<p>".$dollarSign.$row['FirstBid']. " | " .$dollarSign.$row['CurrentBid']. " | " .$dollarSign.$row['BuyPrice']."</p>
						<h3>".$timeHeader."</h3>
						<p>".$row['StartTime']. " | ".$row['EndTime']."</p>
						<h3>".$numBidsHeader."</h3>
						<p>".$row['NumBids']."</p>
						<h3>".$descriptionHeader."</h3>
						<p>".$row['Description']."</p>
						<br>
						<br>
						<br>
					</div>";
				}
	
			}

		?>
	</div>




</body>

</html>

<?php 

}
else{

     header("Location:");

     exit();

}
?>
























