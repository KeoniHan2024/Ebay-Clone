import json
import pandas as pd
import re

itemsFile = open(f'tblItems.csv', 'w') # creates a csv file to write
bidsFile = open(f'tblBids.csv', 'w') # creates a csv file to write
sellersFile = open(f'tblSellers.csv', 'w') # creates a csv file to write
buyersFile = open(f'tblBuyers.csv', 'w') # creates a csv file to write
categoriesFile = open(f'tblCategories.csv', 'w') # creates a csv file to write

MONTHS = {'Jan':'01','Feb':'02','Mar':'03','Apr':'04','May':'05','Jun':'06',\
 'Jul':'07','Aug':'08','Sep':'09','Oct':'10','Nov':'11','Dec':'12'}

count = 0
# Iterates depending on how many json files
for i in range(40):
    count = 0
    # Opens the json file as an object 
    with open(f'AuctionData/items-{i}.json') as json_file:  
        data = json.load(json_file)
    
    item_data = data["Items"]   # puts data into a variable

    for item in item_data:      # loops through the item data as a csv file
        if count == 0:
            header = item.keys()
        
        
        ## ============================================= WRITES Descriptions FOR EACH ITEM ===================================================
        ## FORMAT === ITEMID | NAME | FIRSTBID | CURRENT BID | BUYPRICE(IF VALID) | # OF BIDS | START TIME | END TIME | SELLER | Desc
        firstBidFormat = str(item_data[count]['First_Bid'])
        firstBidFormat = re.sub(r'[^\d.]', '', firstBidFormat)

        currentlyFormat = str(item_data[count]['Currently'])
        currentlyFormat = re.sub(r'[^\d.]', '', currentlyFormat)

        formattedStartTime = str(item_data[count]['Started'])
        formattedStartTime = formattedStartTime.strip().split(' ')
        tok = formattedStartTime[0].split('-')
        mnt = tok[0]
        if mnt in MONTHS:
            mnt = MONTHS[mnt]
            date = '20' + tok[2] + '-'
            date += mnt + '-' + tok[1]
            formattedStartTime = date + ' ' + formattedStartTime[1]

        # Formats the time to YYYY-MM-DD HH:MM:SS
        formattedEndTime = str(item_data[count]['Ends'])
        formattedEndTime = formattedEndTime.strip().split(' ')
        tok = formattedEndTime[0].split('-')
        mnt = tok[0]
        if mnt in MONTHS:
            mnt = MONTHS[mnt]
            date = '20' + tok[2] + '-'
            date += mnt + '-' + tok[1]
            formattedEndTime = date + ' ' + formattedEndTime[1]

        # GETS RID OF COMMAS SO SQLITE DOESNT THINK ITS A NEW COLUMN AND 
        # GETS RID OF QUOTES SO THAT IT DOESNT GIVE ERRORS FOR UNESCAPED CHARS

        formattedDescription = str(item_data[count]['Description']).replace(",", "")
        formattedDescription = formattedDescription.replace('\"', "")

        formattedName = str(item_data[count]['Name']).replace(",", "")
        formattedName = formattedName.replace('\"', "")

        formattedSellerName = str(item_data[count]['Seller']['UserID']).replace(",", " ")
        formattedSellerName = formattedSellerName.replace('\"', "")

        if 'Buy_Price' in item_data[count]:
            buyPriceFormat = str(item_data[count]['Buy_Price'])
            buyPriceFormat = re.sub(r'[^\d.]', '', buyPriceFormat)

            itemsFile.write(str(item_data[count]['ItemID']) + "," +
            formattedName + "," +
            firstBidFormat + "," +
            currentlyFormat + "," +
            buyPriceFormat +  "," + 
            str(item_data[count]['Number_of_Bids']) +  "," + 
            formattedStartTime +  "," + 
            formattedEndTime +  "," +
            formattedSellerName +  "," + 
            formattedDescription + "\n"
            )
        else:
            
            itemsFile.write(str(item_data[count]['ItemID']) + "," +
            formattedName + "," +
            firstBidFormat + "," +
            currentlyFormat + "," +
            str("None") +  "," + 
            str(item_data[count]['Number_of_Bids']) + "," +
            formattedStartTime +  "," + 
            formattedEndTime +  "," +
            formattedSellerName +  "," + 
            formattedDescription + "\n"
            )


        ## ============================================= WRITES Categories FOR EACH ITEM ===================================================
        ## FORMAT === ITEMID | CATEGORY
        categoryCount = 0
        for category in item_data[count]['Category']:
            formattedCategory = str(item_data[count]['Category'][categoryCount]).replace(","," &")
            formattedCategory = formattedCategory.replace('\"', "")
            categoriesFile.write(str(item_data[count]['ItemID']) + "," +
                formattedCategory + "\n"
                )
            categoryCount += 1


        ## ============================================= WRITES BIDS FOR EACH ITEM ===================================================
        ## FORMAT == ITEMID | USERID | TIME | CURRENCY(PRICE) 
        bidCount = 0
        if item_data[count]['Bids'] != None:
            for bid in item_data[count]['Bids']:
                formattedCurrency = str(item_data[count]['Bids'][bidCount]['Bid']['Amount'])
                formattedCurrency = re.sub(r'[^\d.]', '', formattedCurrency)

                formattedTime = str(item_data[count]['Bids'][bidCount]['Bid']['Time'])
                formattedTime = formattedTime.strip().split(' ')
                tok = formattedTime[0].split('-')
                mnt = tok[0]
                if mnt in MONTHS:
                    mnt = MONTHS[mnt]
                    date = '20' + tok[2] + '-'
                    date += mnt + '-' + tok[1]
                    formattedTime = date + ' ' + formattedTime[1]

                bidsFile.write(str(item_data[count]['ItemID']) + "," + 
                str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['UserID']) + "," +
                str(formattedTime) + "," +
                str(formattedCurrency) + "\n") 
                bidCount += 1

        ## ============================================= WRITES INFO FOR EACH USER BUYER ===================================================
        ## FORMAT === USERID | RATING | LOCATION | COUNTRY 
        formattedSellerLocation = ""
        formattedSellerCountry = ""
        if 'Location' in item_data[count]:
            formattedSellerLocation = str(item_data[count]['Location']).replace(",", " ")
            formattedSellerLocation = formattedSellerLocation.replace('\"', " ")

        if 'Country' in item_data[count]:
            formattedSellerCountry = str(item_data[count]['Country']).replace(","," ")
            formattedSellerCountry = formattedSellerCountry.replace('\"', " ")

        bidCount = 0
        if item_data[count]['Bids'] != None:
            if 'Location' in item_data[count]['Bids'][bidCount]['Bid']['Bidder']:
                formattedBuyerLocation = str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['Location']).replace(",", " ")
                formattedBuyerLocation = formattedBuyerLocation.replace('\"', " ")
            
            if 'Country' in item_data[count]['Bids'][bidCount]['Bid']['Bidder']:
                formattedBuyerCountry = str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['Country']).replace(","," ")
                formattedBuyerCountry = formattedBuyerCountry.replace('\"', " ")


            for bid in item_data[count]['Bids']:
                if 'Location' in item_data[count]['Bids'][bidCount]['Bid']['Bidder'] and 'Country' in item_data[count]['Bids'][bidCount]['Bid']['Bidder']:
                    buyersFile.write(str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['UserID']) + "," +
                    str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['Rating']) + "," +
                    formattedBuyerLocation + "," +
                    formattedBuyerCountry + "\n")

                elif 'Location' not in item_data[count]['Bids'][bidCount]['Bid']['Bidder'] and 'Country' not in item_data[count]['Bids'][bidCount]['Bid']['Bidder'] and 'Rating' not in item_data[count]['Bids'][bidCount]['Bid']['Bidder']:
                    buyersFile.write(str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['UserID']) + "," +
                    "None" + "," +
                    formattedBuyerLocation + "," +
                    formattedBuyerCountry + "," + "\n")

                elif 'Location' not in item_data[count]['Bids'][bidCount]['Bid']['Bidder'] and 'Country' not in item_data[count]['Bids'][bidCount]['Bid']['Bidder']:
                    buyersFile.write(str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['UserID']) + "," +
                    str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['Rating']) + "," + 
                    "None" + "," + "None" + "\n") 

                elif 'Location' not in item_data[count]['Bids'][bidCount]['Bid']['Bidder']:
                    buyersFile.write(str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['UserID']) + "," +
                    str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['Rating']) + "," + 
                    "None" + "," +
                    formattedBuyerCountry + "\n")

                elif 'Rating' not in item_data[count]['Bids'][bidCount]['Bid']['Bidder']:
                    buyersFile.write(str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['UserID']) + "," +
                    "None" + "," +
                    formattedBuyerLocation + "," +
                    formattedBuyerCountry +"\n")

                else:
                    buyersFile.write(str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['UserID']) + "," +
                    str(item_data[count]['Bids'][bidCount]['Bid']['Bidder']['Rating']) + "," +
                    formattedBuyerCountry + "," + "None" + "\n")
                
                bidCount += 1

        ## ============================================= WRITES INFO FOR EACH USER SELLER ===================================================
        ## FORMAT === USERID | RATING | LOCATION | COUNTRY 

        sellersFile.write(formattedSellerName + "," + 
                str(item_data[count]['Seller']['Rating']) + "," + formattedSellerLocation + "," + formattedSellerCountry + "\n")
        count += 1



# CLOSES ALL FILES
itemsFile.close()
bidsFile.close()
buyersFile.close()
sellersFile.close()
categoriesFile.close()

