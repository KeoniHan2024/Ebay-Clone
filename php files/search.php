<?php
include 'connection.php';
$cookieUsername = $_COOKIE['user'];
if (isset($cookieUsername)) {
	print("Cookie is valid");
}
else {
	print("Cookie is expired");
}

?>
<h1>Search Page</h1>
<a href="home.php">Back to home page</a>

<div class = "article-container">
<?php
	if (isset($_POST['submit-search'])) {
		$dollarsign = "$";
		$nameHeader = "Item Name";
		$pricesHeader = "First Bid | Current Bid | Buy Price|";
		$numBidsHeader = "Number of Bids";
		$descriptionHeader = "Description";
		$categoriesHeader = "Categories";
		$sellerHeader = "Seller Name";
		$timeHeader = "StartTime | EndTime";
		$topHeader = "Top Bidder";
		$seperator = "=====================================================================";
		if ($_POST['searchField'] == 'description') {
			$search = mysqli_real_escape_string($con, $_POST['search']);
			$sql = "SELECT * FROM tblItems WHERE Description LIKE '%$search%' ORDER BY EndTime DESC, CurrentBid ASC LIMIT 100";
			$result = mysqli_query($con, $sql);
			$queryResult = mysqli_num_rows($result);
			
			
			if ($queryResult > 0) {
						echo "<div>
							<p>".$queryResult." Items</p>
							</div>";
				while($row = mysqli_fetch_assoc($result)) {
						$itemID = $row['ItemID'];
						$sql2 = "SELECT Category FROM tblCategories WHERE ItemID = '".$itemID."'";
						$result2 = mysqli_query($con, $sql2);
						$queryResult2 = mysqli_num_rows($result2);
						$sql3 = "SELECT EndTime FROM tblItems WHERE ItemID = '".$itemID."' AND EndTime > NOW()";
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
			else {
				echo "There are no results matching your search";
			}


		}
		else if ($_POST['searchField'] == 'seller') {
			$search = mysqli_real_escape_string($con, $_POST['search']);
			$sql = "SELECT * FROM tblItems WHERE SellerID LIKE '%$search%' ORDER BY EndTime DESC, CurrentBid ASC LIMIT 100";
			$result = mysqli_query($con, $sql);
			$queryResult = mysqli_num_rows($result);
			
			if ($queryResult > 0) {
							echo "<div>
							<p>".$queryResult." Items</p>
							</div>";
				while($row = mysqli_fetch_assoc($result)) {
						$itemID = $row['ItemID'];
						$sql2 = "SELECT Category FROM tblCategories WHERE ItemID = '".$itemID."'";
						$result2 = mysqli_query($con, $sql2);
						$queryResult2 = mysqli_num_rows($result2);
						$sql3 = "SELECT EndTime FROM tblItems WHERE ItemID = '".$itemID."' AND EndTime > NOW()";
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
			else {
				echo "There are no results matching your search";
			}
		}
		else if ($_POST['searchField'] == 'category') {
			$search = mysqli_real_escape_string($con, $_POST['search']);
			$sql = "SELECT * FROM tblItems,tblCategories WHERE tblItems.ItemID = tblCategories.ItemID AND tblCategories.Category LIKE '%$search%' ORDER BY EndTime DESC, CurrentBid ASC LIMIT 100";
			$result = mysqli_query($con, $sql);
			$queryResult = mysqli_num_rows($result);
			
			if ($queryResult > 0) {
							echo "<div>
							<p>".$queryResult." Items</p>
							</div>";
				while($row = mysqli_fetch_assoc($result)) {
						$itemID = $row['ItemID'];
						$sql2 = "SELECT Category FROM tblCategories WHERE ItemID = '".$itemID."'";
						$result2 = mysqli_query($con, $sql2);
						$queryResult2 = mysqli_num_rows($result2);
						$sql3 = "SELECT EndTime FROM tblItems WHERE ItemID = '".$itemID."' AND EndTime > NOW()";
						$result3 = mysqli_query($con, $sql3);
						$queryResult3 = mysqli_num_rows($result3);
						$result4 = mysqli_query($con, $sql4);
						$queryResult4 = mysqli_num_rows($result4);
						if ($queryResult4 > 0) {
							while($row4 = mysqli_fetch_assoc($result4)) {
								$topBidder = $row4['UserID'];
							}
						}
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
			else {
				echo "There are no results matching your search";
			}
		}
	}
?>


</div>
