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
		
		
		
		//print_r( $file);
			?>
<body style="margin:0px;">
	<div id="page-mask"></div>
	<div id="loader" class="loader"></div>
	<div class="mainWrapper" style="min-height:100%;">
		<div class='nav'>
			<div class="styleSwitcher" style="width:100%;text-align: center;">
			<label class="styleSwitch">
  					<input id="styleChkbx" type="checkbox">
  					<span class="slider round"></span>
			</label>
			</div>
			<a href=<?php print_r("\"".$curLoc."\index.php"."\"")?> class="navIco"><img class="navIcoImg" width="144px" height="48px"   alt="Home"></a>
			<div class="navLinks"  >
			<?php
	
  				$file = explode("\n",file_get_contents('info.txt'));
  				//print_r($file[0]);
				if(empty($file[0])){
					$file = array(getcwd()."/");
				}
  				$arr = scands($file[0],$file[0]);
  				$count = 0;	 
  				foreach($arr as $v){
  					if(is_array($v)){if(arrCont($v)){$count = $count + 1;}}
  					else{
  						$count = $count +1;
  					}
  				}
  		arrRead($arr,60/($count-1),False);

		?>

  			</div>
			<div class="navLogin" >
				<a href=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."\~login.php"."\"")?> class="nvLgnBtn bounceTrans">LOGIN</a>


			</div>
			<script>loadLoginDiv();</script>
			<div class="navSrch" style="width:50px;">
				<form  id="searchFrm" action=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."/Trading/Current Offers.php"."\"")?>>
					<input type="text" name="item" placeholder="&#xF002; Search">
				</form>
			</div>


		</div>
		<div class="main">
					<h1><?php if(isset($_GET['item'])){

				echo $_GET['item'];

			}?>
</h1>
					<p id="avgFame">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis incidunt dignissimos error est ut rem ea quibusdam? A vitae consequuntur accusantium beatae ipsam culpa nemo nisi quia, eaque perferendis! Minima!</p>
					<p> <b> There is a 1 second delay before confirming  purchase to prevent accidents.</b></p>
					<form class="tradItemSearch" action=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."/Trading/Current Offers.php"."\"")?>>
					<h1>Search for an item</h1>
					<div class="tradItemSearchMain">
					<div class="tradItemSearchBox" style="float:left;"> <input type="text" name="item" ></div>
					<label class="radioCont" style="margin-left:20px;"><input type="radio" id="radioBuy" name="radios" value="buy"><div class="radioStyle" style="border:1px black solid; border-right:none;border-top-left-radius: 5px;border-bottom-left-radius: 5px;"> Buy</div></label>
					<label class="radioCont"><input type="radio" id="radioSell" name="radios" value="sell"> <div class="radioStyle" style="border:1px black solid;">Sell</div></label>
					<label class="radioCont" style="margin-right:20px;"><input type="radio" id="radioFame" name="radios" value="fame" checked> <div class="radioStyle" style="border:1px black solid; border-left:none;border-top-right-radius: 5px;border-bottom-right-radius: 5px;">Fame</div></label>  
					<input class="tradSubmitBtn" type="submit" value="Search" style="margin-left:10px;">
					</div>
					</form>
					<br>
			
			<script>	
				window.onload = function () {
					main();
					searchMarket(<?php 
						if(isset($_GET['item'])){

					echo '"'.$_GET['item'].'"';

				}?>,<?php 
			if(isset($_GET['item'])){

				echo '"'.$curLoc.'/src/items/'.str_replace(" ","-",$_GET['item']).'"';

			}

			?>);}
			
			</script>
			<div id="tradCont">	
			<div class="searchHeader" style="text-align:center;padding-bottom:5px;border-bottom:2px solid #a3a3a3;display:grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr;color:#363636;"><p1>	<b>Item</b></p1><p1><b>	Seller</b></p1><p1><b>Price</b></p1><p1><b>Time Left</b></p1><p1><b>Buy</b></p1></div>
			
			</div>

		</div>
		<div style="grid-area: footer;"></div>
		

	</div>
	<script>	
	var x = document.getElementsByClassName("dropdown");
	for (index = 0; index < x.length; ++index) {
		console.log(x[index].innerHTML);
		var siblings = document.getElementsByClassName("dropdown-content");
	

	for (index = 0; index < siblings.length; ++index) {
		console.log((x[index].offsetWidth/window.screen.width));
    	siblings[index].style.width = (x[index].offsetWidth/window.screen.width)*100+"%";
	}
	}
	
</script>
</body>
</html>