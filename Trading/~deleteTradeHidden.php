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
		//Not used because not a proper login check 
		/**function checkIfLoggedIn($email,$token,$username){
				$url ="https://ae.rotf.io/guild/listMembers?guid=".urlencode($email)."&token=".urlencode($token);
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
				}
		}**/
		function addTradeData($tradeId,$itemName,$quantity,$buySell,$conn,$data){

			$itemName = mysqli_real_escape_string ($conn,$itemName);
			$tradeId = mysqli_real_escape_string ($conn,$tradeId);
			$quantity = mysqli_real_escape_string ($conn,$quantity);
			$buySell = mysqli_real_escape_string ($conn,$buySell);
			$sql = "INSERT INTO  `tbl_tradesdata` (`tradeId`,`itemName`,`quantity`,`tradeMode`) VALUES ('$tradeId','$itemName','$quantity','$buySell')";
			//print_r($data);
			for($cur =0;$cur<sizeof($data);$cur++){
				$val  = $data[$cur];
				if($val[0] == $itemName){
				if($buySell == "0"){
 					$val[1] = strval(intval($val[1])+1);
 					print_r($val[1]);
				}
				else if($buySell == "1"){
					$val[3] = strval(intval($val[3]) +1);
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
		function deleteFromDb($accountName,$tradeId){
			$servername = "localhost";
			$username = "rotfWebsite";
			$password = "rotfiscool101";
			$dbname = "rotfdata";

			$data = explode("\n",file_get_contents('data.txt'));
			$parsed = array();
			foreach($data as $val){
				$temp = explode(",",$val);
				$temp[0] = str_replace("-"," ",$temp[0]);
				array_push($parsed,$temp);
			}

			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
			} else{
				echo "Connection success.";
			}
			$accountName = mysqli_real_escape_string ($conn,$accountName);
			$tradeId = mysqli_real_escape_string ($conn,$tradeId);
			
			$sql = "DELETE FROM `tbl_tradesinfo` WHERE accountName='$accountName' AND id='$tradeId'";
			echo $sql."<br>";
			if (mysqli_query($conn, $sql)) {
			    echo "Successfully <br>";
			} else {
			    echo "Error deleting: " . mysqli_error($conn);
			    return false;
			}
			$sql = "SELECT * FROM `tbl_tradesdata` WHERE tradeId='$tradeId'";
			$resulta = mysqli_query($conn,$sql);
			if($resulta){
				while($rowa = mysqli_fetch_assoc($resulta)){
					$buySell = $rowa["tradeMode"];
					$name = $rowa["itemName"];
					print_r($name);
					for($cur =0;$cur<sizeof($parsed);$cur++){
						if(mysqli_real_escape_string($conn,$parsed[$cur][0]) == mysqli_real_escape_string($conn,$name)){
							if($buySell == "0"){
								if(intval($parsed[$cur][1])>0){
									$parsed[$cur][1] = strval(intval($parsed[$cur][1]) - 1);
								}

							}else{
								if(intval($parsed[$cur][3])>0){
									$parsed[$cur][3] = strval(intval($parsed[$cur][3]) - 1);
							}
							}
						}
					}
				}
			}
			//print_r($parsed); 
			$sql = "DELETE FROM `tbl_tradesdata` WHERE tradeId='$tradeId'";
			$resulta = mysqli_query($conn,$sql);
			if($resulta){
				echo "WORKED...";
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
		if(isset($_GET['email']) && isset($_GET['token']) && isset($_GET['accountName']) && isset($_GET["tradeId"]) )
			//echo $_SERVER['REQUEST_URI']
			deleteFromDb($_GET['accountName'],$_GET["tradeId"]);
			header('Location: '. explode("\n",file_get_contents('info.txt'))[0]."\Trading\Delete Trade.php");
			die();
			//deleteFromDb("Jeff",3);
			//echo checkIfItem("Potion of Defense");
			?>
</html>