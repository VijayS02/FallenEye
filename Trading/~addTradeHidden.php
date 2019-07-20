<html>

<?php
		function checkIfItem($itemName){
			$data = explode("\n",file_get_contents(explode("\n",file_get_contents('info.txt'))[0]."\src\items\data.txt"));
			$parsed = array();
			foreach($data as $val){
				$temp = explode(",",$val);
				array_push($parsed,$temp);

			}
			foreach($parsed as $item){
					$name = $item[0];
					$temp = (str_replace("-"," ",$name));
					if($temp == $itemName){
						echo $temp;
						return;
					}

			}
			echo "False.!";
			return false;
		}
		function checkIfLoggedIn($email,$token,$username){
				/**$url ="https://ae.rotf.io/guild/listMembers?guid=".urlencode($email)."&token=".urlencode($token);
				echo "Page: $url <br>";
				$page = file_get_contents($url);
				echo $page;
				if(strpos($page, "Bad Login") !== False){
					echo "Failed!";
					return False;
				}else{
					if(strpos($page,$username) !== False){
						echo "True";
						return True;

					}
				}**/
				return true;
		}
		function addTradeData($tradeId,$itemName,$quantity,$buySell,$conn,$data){

			$itemName = mysqli_real_escape_string ($conn,$itemName);
			$tradeId = mysqli_real_escape_string ($conn,$tradeId);
			$quantity = mysqli_real_escape_string ($conn,$quantity);
			$buySell = mysqli_real_escape_string ($conn,$buySell);
			$sql = "INSERT INTO  `tbl_tradesdata` (`tradeId`,`itemName`,`quantity`,`tradeMode`) VALUES ('$tradeId','$itemName','$quantity','$buySell')";
			//print_r($data);
			print_r($itemName);
			for($cur =0;$cur<sizeof($data);$cur++){
				$val  = $data[$cur];

				if(mysqli_real_escape_string($conn,$val[0]) == $itemName){
				if($buySell == "0"){
 					$val[1] = strval(intval($val[1])+1);
 					print_r($val[1]);
				}
				else if($buySell == "1"){
					$val[3] = strval(intval($val[3])+1);
				}
				$data[$cur] = $val;
			}
			}
			echo $sql."<br>";
			if (mysqli_query($conn, $sql)) {
			    echo "Successfully <br>";
			} else {
			    echo "Error inserting: " . mysqli_error($conn);
			    return false;
			}
			return $data;
		}
		function addToDb($accountName,$selling,$Selling_Qty,$Buying,$Buying_Qty,$time,$comment){
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
			$accountName = mysqli_real_escape_string ($conn,$accountName);
			$comment  = mysqli_real_escape_string ($conn,$comment);
			$time = mysqli_real_escape_string ($conn,$time);
			
			$sql = "INSERT INTO  `tbl_tradesinfo` (`AccountName`,`comment`,`expiry`) VALUES ('$accountName','$comment','$time')";
			echo $sql."<br>";
			if (mysqli_query($conn, $sql)) {
			    echo "Successfully <br>";
			} else {
			    echo "Error inserting: " . mysqli_error($conn);
			    $tradId = -1;
			    return false;
			}
			$data = explode("\n",file_get_contents('data.txt'));
			$parsed = array();
			foreach($data as $val){
				$temp = explode(",",$val);
				$temp[0] = str_replace("-"," ",$temp[0]);
				array_push($parsed,$temp);
			}
			//print_r($parsed); 
			$tradId = mysqli_insert_id($conn);
			echo $tradId."<br>";
			for($count = 0; $count<sizeof($selling);$count++){
				$val = addTradeData($tradId,$selling[$count],$Selling_Qty[$count],"0",$conn,$parsed);
				if($val==false){
					return false;
				}else{
					$parsed = $val;
				}


			}
			for($count = 0; $count<sizeof($Buying);$count++){
				$val = addTradeData($tradId,$Buying[$count],$Buying_Qty[$count],"1",$conn,$parsed);
				if($val == false){
					return false;
				}else{
					$parsed = $val;
				}


			}

			for($x = 0;$x<sizeof($parsed);$x++){
				$parsed[$x] = join(",",$parsed[$x]);

			}
			$write = join("\n",$parsed);
			$file = fopen("data.txt", "w") or die("Unable to open file!");
			fwrite($file, $write);
			fclose($file);+
			mysqli_close($conn);
			return true;



		}
		if(isset($_GET['email']) && isset($_GET['token']) && isset($_GET['accountName']) ){
			if(checkIfLoggedIn($_GET['email'],$_GET['token'],$_GET['accountName'])){
			//echo $_SERVER['REQUEST_URI'];

			$query  = explode('&', $_SERVER['QUERY_STRING']);
			$params = array();

			foreach( $query as $param )
			{
			  // prevent notice on explode() if $param has no '='
			  if (strpos($param, '=') === false) $param += '=';

			  list($name, $value) = explode('=', $param, 2);
			  $params[urldecode($name)][] = urldecode($value);
			}
			array_pop($params);
			array_pop($params);
			array_pop($params);
			array_pop($params);
			$comment = "";
			if(isset($_GET['comment'])){
				$comment = $_GET['comment'];
			}
			addToDb($_GET['accountName'],$params["sell"],$params["sellQuantity"],$params["buy"],$params["buyQuantity"],strval(date("Y-m-d H:i:s")),$comment);
			header('Location: '. explode("\n",file_get_contents('info.txt'))[0]."\Trading\Add Trade.php");
			}
			else{
				echo "Incorrect login.";
			}
		}
			//deleteFromDb("Jeff",3);
			//echo checkIfItem("Potion of Defense");
			?>
</html>