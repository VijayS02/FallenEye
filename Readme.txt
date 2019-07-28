1) Setting up website on a server ------------
Requirements: database must have a user and setup  as follows:
servername = "localhost"
username = "rotfWebsite"
password = "rotfiscool101"
dbname = "rotfdata"
--------
In order to create the tables on the server, the "~createTradesTable.php" website inside scripts should be opened once, a success messgae should appear.
This page is not required after being run once. 
The page is now ready to be put on the www. Simply copy the WWW files to the desired location such that index.php is at the root.
----------------------------
2) To update if new items are added---------------------------- GenerateImages.py + tradeTable.py
Requirements: Python 3.7 + Opencv must be installed, progressbar should get automatically installed, safer to have installed before hand.

Files and what they do:
Sprites.txt - Contains a list of all sprite sheets that can be found on the remote server. (Format: "\n" seperated)
overrides.txt - to override a texture file name as found in xmls. E.g. replace lofiObj4 with EmbeddedAssets_lofiObj4Embed_.png.  (Format <file to be replaced>,<replacement>)
extras.txt - Items which are not found in XML files but may need to be added for trading purposes (e.g. 500 fame, etc)
blacklist - List of objects that are blacklisted, can be either a file (e.g. lofiObj1) or an item (e.g. Ring of Minor Defense) (CASE SENSITIVE)

GenerateImages.py uses all the files above and creates 4 things: 2 folders ("raw",images to be spliced a.k.a. spritesheets and "items",spliced items), 2 files, tradeBlank.txt and ignoredItems.txt. 
ignoredItems is a list of items that threw errors or have certain traits that are not allowing them to be used on the trading / market database.
Press 'y' and hit enter when prompted by generateImages.py
Once generateImages.py has completed running. Copy or cut data.txt (DO NOT DELETE, contains the number of trades for each item) from the trading folder and paste it into the same folder as tradeBlank.txt and tradeTable.py.
Run tradeTable.py and the new items will be added to the trading database (i.e. the data.txt file will be modified to contain the new items). 

The data.txt can be copied back into trading folder and replace the data.txt if it was not already deleted/cut.

Copy items folder into src folder. 