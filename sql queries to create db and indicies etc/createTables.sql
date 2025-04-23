START TRANSACTION;
CREATE TABLE tblItems(
	ItemID INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	Name TEXT NOT NULL,
	FirstBid Decimal NOT NULL CHECK(FirstBid >= 0),
	CurrentBid Decimal NOT NULL CHECK(CurrentBid >= 0),
	BuyPrice varChar(40),
	NumBids Integer NOT NULL CHECK(NumBids >= 0),
	StartTime DATETIME NOT NULL,
	EndTime DATETIME NOT NULL,
	SellerID varChar(400) NOT NULL,
	Description LONGTEXT NOT NULL
);
CREATE TABLE tblCategories(
	ItemID INTEGER NOT NULL,
	Category varChar(300) NOT NULL
);
CREATE TABLE tblBids(
	ItemID INTEGER NOT NULL,
	UserID varChar(400) NOT NULL,
	Time DATETIME NOT NULL,
	Amount Decimal NOT NULL CHECK(Amount >= 0)
);
CREATE TABLE tblSellers(
	UserID varChar(400) PRIMARY KEY NOT NULL,
	Rating Integer NOT NULL CHECK(Rating >= 0),
	Location varChar(250),
	Country varChar(250)
);
CREATE TABLE tblBuyers(
	UserID varChar(400) PRIMARY KEY NOT NULL,
	Rating Integer NOT NULL CHECK(Rating >= 0),
	Location varChar(250),
	Country varChar(250)
);
CREATE TABLE login(
	username varChar(200) NOT NULL,
	password varChar(200) NOT NULL
);
COMMIT;

