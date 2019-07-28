<html>
<head>
	<meta charset="UTF-8">

</head>
<?php
		$servername = "localhost";
		$username = "rotfWebsite";
		$password = "rotfiscool101";
		$dbname = "rotfdata";

		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
		} else{
			echo "Connection success.";
		}
		$sql = "CREATE TABLE IF NOT EXISTS  tbl_TradesInfo (
		id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		AccountName VARCHAR(30) NOT NULL,
		comment VARCHAR(255),
		expiry DATETIME NOT NULL
		)";


		if (mysqli_query($conn, $sql)) {
		    echo "Table MyGuests created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($conn);
		}
		$sql = "CREATE TABLE IF NOT EXISTS  tbl_TradesData (
		id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		tradeId INT(30) NOT NULL,
		itemName VARCHAR(255) NOT NULL,
		quantity INT(30) NOT NULL,
		tradeMode BOOLEAN NOT NULL
		)";
		//true = buy, false = sell


		if (mysqli_query($conn, $sql)) {
		    echo "Table MyGuests created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($conn);
		}
		mysqli_close($conn);
		?>

</html>