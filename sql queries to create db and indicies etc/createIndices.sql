CREATE INDEX CategoryIndex ON tblCategories (ItemID, Category);
CREATE INDEX BidsIndex ON tblBids (ItemID, Time);
CREATE INDEX ItemsIndex ON tblItems (Description, SellerID, ItemID, StartTime, EndTime);
