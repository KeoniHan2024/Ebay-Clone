<?php
	include 'connection.php';
	include 'header.php';
	
	if(isset($_COOKIE['user']) && $_COOKIE['pass'] == true) {

?>


<h1> Bidding Page </h1>

<a href="home.php">Back to home page</a>
<?php
	$ID = mysqli_real_escape_string($con, $_GET['ID']);
?>
	<form method = "POST" action = "placedBid.php?ID=<?php echo $ID; ?>">
	<input type="text" name="bidAmt" placeholder="Bid Amount">
	<input type="submit" name="submit-bid" value = "Submit Bid">
	
	</form>


<div class = "article-container">
<?php
	$ID = mysqli_real_escape_string($con, $_GET['ID']);
	$sql = "SELECT * FROM tblItems WHERE ItemID = '".$ID."'";
	$result = mysqli_query($con, $sql);
	$queryResults = mysqli_num_rows($result);
			$dollarSign = "$";
			$nameHeader = "Item Name:";
			$pricesHeader = "First Bid | Current Bid | Buy Price";
			$numBidsHeader = "Number of Bids";
			$descriptionHeader = "Description";
			$sellerHeader = "Seller Name";
			$categoriesHeader = "Categories";
			$seperator = "=====================================================================";
			$timeHeader = "StartTime | EndTime";
			$topHeader = "Top Bidder";	
			
			
			// Prints all the information base off the item
			if ($queryResults > 0) {
				while($row = mysqli_fetch_assoc($result)) {
						$itemID = $row['ItemID'];
						$sql2 = "SELECT Category FROM tblCategories WHERE ItemID = '".$itemID."'";
						$result2 = mysqli_query($con, $sql2);
						$queryResult2 = mysqli_num_rows($result2);
						$sql3 = "SELECT EndTime FROM tblItems WHERE ItemID = '".$itemID."' AND EndTime > '2001-12-20 00:00:01'";
						$result3 = mysqli_query($con, $sql3);
						$queryResult3 = mysqli_num_rows($result3);
						$sql4 = "SELECT tblBids.UserID FROM tblBids, tblItems WHERE tblItems.ItemID = '".$itemID."' AND tblItems.ItemID = tblBids.ItemID ORDER BY tblBids.Amount Desc LIMIT 1";
						$result4 = mysqli_query($con, $sql4);
						$queryResult4 = mysqli_num_rows($result4);
						if ($queryResult4 > 0) {
						while($row4 = mysqli_fetch_assoc($result4)) {
							$topBidder = $row4['UserID'];
						}
						}
						
						
						// checks to see if the bid is active still and puts text showing that
						echo "<div>
							<p>".$seperator."</p>
							</div>";
						if ($queryResult3 == 0) {
							echo "<div>
								<h3>Not Active </h3>
								</div>";
						}
						else {
							echo "<div>
								<h3>Active </h3>
								</div>";
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
						<h3>".$topHeader."</h3>
						<p>".$topBidder."</p>
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
		}
	else {
		
		print_r("Cookie Expired Redirecting to Login Page");
		header("Refresh: 3; URL=index.php?ID=".$ID."");
	}
	
?>
