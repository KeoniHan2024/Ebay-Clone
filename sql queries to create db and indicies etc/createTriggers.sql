CREATE TRIGGER updateTotalBids AFTER INSERT ON tblBids
	FOR EACH ROW
 		UPDATE tblItems
    		SET NumBids = 1 + NumBids
  		WHERE ItemID = new.ItemID;

CREATE TRIGGER updateBidPrice AFTER INSERT ON tblBids
FOR EACH ROW
    	UPDATE tblItems
    	SET CurrentBid = new.Amount
    	WHERE ItemID = new.ItemID;
    	
CREATE TRIGGER updateSellerList AFTER INSERT ON tblItems
FOR EACH ROW
	INSERT IGNORE INTO tblSellers (UserID, Rating) VALUES (new.SellerID, 0);
      
CREATE TRIGGER updateBuyerList AFTER INSERT ON tblBids
FOR EACH ROW
	INSERT IGNORE INTO tblBuyers (UserID, Rating) VALUES (new.UserID, 0);
	
CREATE TRIGGER updateBuyerRating AFTER UPDATE ON tblSellers
FOR EACH ROW
    	UPDATE tblBuyers
    	SET Rating = new.Rating
    	WHERE BuyerID = new.UserID;
    	
