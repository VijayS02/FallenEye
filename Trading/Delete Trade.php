<html>
<?php
			function genMode(){
				if(isset($_COOKIE['mode'])){
					if($_COOKIE['mode'] == "0"){
					print_r("style.css");
				}else{
					print_r("styleDark.css");
				}
				}

			}

?>
<head>
	<meta charset="UTF-8">
	<title><?php if(isset($_GET['item'])){

				echo $_GET['item'];

			}?></title>
	<script src=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."/jquery-3.4.1.js"."\"")?>></script>
	<link id="themeStyle" rel="stylesheet" type="text/css" href=<?php print_r(explode("\n",file_get_contents('info.txt'))[0]."/");print_r(genMode());?>>
	<link rel="icon" type="image/png" href=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."\assets/favicon/favicon-96x96.png"."\"")?>>
			<script>
	var reqLogin = true;



</script>
	<script src=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."/script.js"."\"")?>></script>
	<script>getPath(<?php print_r( "\"".explode("\n",file_get_contents('info.txt'))[0]."\"");?>)</script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>


</head>
<?php
		$curLoc = explode("\n",file_get_contents('info.txt'))[0];
		//include '../src/template/info.txt';
		$temp = 0;
		function scands($a,$o) {
			$files = scandir($a);
			$arr=array("");
			foreach($files as $x){
				if(is_dir($a."/".$x) && $x != "." && $x != ".." && $x != "..."  && $x!="src" && $x!="index.php" && $x != ".htaccess" ){
					
					array_push($arr,scands($a."/".$x,$o));
					
				}
				else if($x != "." && $x != ".."){
					
					if((strpos($x, "~") !== false) == false && $x!="src" && $x!="index.php" && $x!=".htaccess"){
						if(substr($x,strripos($x,"."))==".html" || substr($x,strripos($x,"."))==".php" ){
							array_push($arr,str_replace($o,"",$a)."/".$x);
						}
					}
				}
			}
			return $arr;
			}
			
		function arrCont($arr){
			foreach($arr as $val){
				if(is_array($val)){
					if(arrCont($val)){
						return true;
					}
				}else if(substr($val,strripos($val,"."))==".html" || substr($val,strripos($val,"."))==".php" ){
					return true;
				}
			}
			
		}
		function getBuying($item,$item2){
			$servername = "localhost";
			$username = "rotfWebsite";
			$password = "rotfiscool101";
			$dbname = "rotfdata";
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
			} else{
				//echo "Connection success.";
			}
			$item = mysqli_real_escape_string($conn,$item);
			$sql = "SELECT tradeId FROM `tbl_tradesdata` WHERE tradeMode='1' AND itemName='$item' ORDER BY tradeId DESC";
			$resulta = mysqli_query($conn,$sql);
			if($resulta){
			while($rowa = mysqli_fetch_assoc($resulta)){
				$tradeId = $rowa["tradeId"];
				$sql = "SELECT itemName,quantity,tradeMode FROM tbl_tradesdata WHERE `tradeId`='$tradeId'";
				$result = mysqli_query($conn,$sql);
				$arr = array();
				$contRes = false;
				while($row = mysqli_fetch_assoc($result)){
					array_Push($arr,$row);
					if($item2 != null){
					if($row['itemName']==$item2 && $row['tradeMode'] == "0"){
						$contRes = true;
					}
					}
				}
				if(($item2 != null && $contRes == true )|| ($item2 == null)){
				mysqli_free_result($result);
				$sql = "SELECT AccountName,comment,expiry FROM tbl_tradesinfo WHERE `id`=$tradeId";
				$resultb = mysqli_query($conn,$sql);
				$data = mysqli_fetch_assoc($resultb);
				createTrade($arr,$data["AccountName"],$data['expiry'],$data['comment']);
				}
			}}else{
				echo mysqli_error($conn);
			}
			

		}
		function createTrade($data,$seller,$time,$comment){
			$sell = "";
			$buy = "";

			foreach ($data as $var) {
				if($var['tradeMode']==0){
						$sell = $sell . "<div class=\"srchResItem\">";
						$sell = $sell . "<img src=\"".explode("\n",file_get_contents('info.txt'))[0]."/src/items/".str_replace(" ", "-", $var['itemName']).".png\" class=\"srchResImg\" >";
						$sell = $sell ."<p1><b>x ".$var['quantity']."</b></p1>";
						$sell = $sell . "</div>";
				}
				if($var['tradeMode']==1){
						$buy = $buy ."<div class=\"srchResItem\">";
						$buy = $buy . "<img src=\"".explode("\n",file_get_contents('info.txt'))[0]."/src/items/".str_replace(" ", "-", $var['itemName']).".png\" class=\"srchResImg\" >";
						$buy = $buy ."<p1><b>x ".$var['quantity']."</b></p1>";
						$buy = $buy . "</div>";
				}
			}
			print_r('<div class="srchResBuy">');
			print_r('<div id="buy" class="srchResCont">');
			print_r($buy);
			print_r('</div>');
			print_r('<div id="sell" class="srchResCont">');
			print_r($sell);
			print_r("</div>");
			$date1 = time();  
			$date2 = strtotime($time); 
			$diff = abs($date2 - $date1); 
			$years = floor($diff / (365*60*60*24));  
			$months = floor(($diff - $years * 365*60*60*24) 
                               / (30*60*60*24));  
			$days = floor(($diff - $years * 365*60*60*24 -  
             $months*30*60*60*24)/ (60*60*24)); 
			$hours = floor(($diff - $years * 365*60*60*24  
       			- $months*30*60*60*24 - $days*60*60*24) 
                                   / (60*60));  
			$minutes = floor(($diff - $years * 365*60*60*24  
         - $months*30*60*60*24 - $days*60*60*24  
                          - $hours*60*60)/ 60); 
			$seconds = floor(($diff - $years * 365*60*60*24  
         - $months*30*60*60*24 - $days*60*60*24 
                - $hours*60*60 - $minutes*60));
			if($years != 0 ){
					$time = strval($years)." years ago";
			}else if($months != 0){
					$time = strval($months)." months ago";
			}else if($days != 0){
					$time = strval($days)." days ago";
			}else if($hours != 0){
					$time = strval($hours)." hours ago";
			}else if($minutes !=0){
					$time = strval($minutes)." minutes ago";
			}else if($seconds !=0){
				$time = "a few seconds ago";

			}
			print_r('
				<p1 class="text">'.$time.'</p1>');
			if($comment == null || trim($comment) == ""){

			}else{
				print_r('<p1 class="description">'.$comment.'</p1>');
			}
			print_r('</div>');

			
		}
		function arrRead($arr,$temp,$check){
			foreach($arr as $val){
				if(is_array($val)){
				 if(arrCont($val)){
				 	if($check){
				 		return arrRead($val,$temp,$check);
				 	}
					print_r("<div class=\"dropdown\" ><button class=\"dropbtn\">".arrRead($val,$temp,True)." <i class=\"fa fa-caret-down\"></i></button><div class=\"dropdown-content \">");
					arrRead($val,$temp,False);
					print_r("</div></div>");
				 }
				}else{
					if($val != "\index.php"){
						if($check){
							$arr = explode("/",$val);
						if(count($arr)>1){
							return $arr[count($arr)-2];
						}
						}
						$arr = explode ("/",$val);
						if(count($arr)>2){
						print_r("<a href=\"".$val."\">".str_replace(".html","",str_replace(".php","",$arr[count($arr)-1]))."</a>" );
					}elseif(count($arr)>1){
						print_r("<a href=\"".$val."\">".str_replace(".html","",str_replace(".php","",$arr[count($arr)-1]))."</a>" );
					}
					//print_r($val." "); 

				}
				}
				
			};
		}
		function createOptions($curLoc){
			$data = explode("\n",file_get_contents(explode("\n",file_get_contents('info.txt'))[0]."\src\items\data.txt"));

			$parsed = array();
			foreach($data as $val){
				$temp = explode(",",$val);
				array_push($parsed,$temp);

			}
			foreach($parsed as $item){
				if(strpos($item[0], 'Dye') == false  && strpos($item[0], 'Cloth') == false){
						$name = $item[0];
						$temp = (str_replace("-"," ",$name));
						print_r("<option value=\"".$temp."\"></option>");
					}

				}
		}
		function createIcons($curLoc){
			$data = explode("\n",file_get_contents(explode("\n",file_get_contents('info.txt'))[0]."\src\items\data.txt"));

			$parsed = array();
			foreach($data as $val){
				$temp = explode(",",$val);
				array_push($parsed,$temp);

			}
			foreach($parsed as $item){
					if(strpos($item[0], 'Dye') == false  && strpos($item[0], 'Cloth') == false){
						$name = $item[0];
					$temp = (str_replace("-"," ",$name));
    				print_r('
				<div title="');
				print_r($temp);
				print_r('" class="itemSelectorItem" id="');
    				print_r($temp);
    				print_r('"><img class="itemSelectorImage"  src="'.$curLoc.'\src\items\\');
				print_r($name);
				print_r('.png"></div>');
					}
				}
			}
		
		
		
		//print_r( $file);
			?>
<body style="margin:0px;">

	<script>
		window.location.href = curPath+"\\Trading\\~Delete Trade.php?email=" + encodeURI(getCookie("email")) + "&token="+ encodeURI(getCookie("token"))+"&name="+encodeURI(getCookie("name"));


	</script>
</body>
</html>