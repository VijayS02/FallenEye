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
	<title>Add Trade</title>
	<script>var reqLogin = true;</script>
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
					$temp1 = (str_replace("_",":",$temp));
    				print_r('
				<div title="');
				print_r($temp1);
				print_r('" class="itemSelectorItem" id="');
    				print_r($temp);
    				print_r('"><img class="itemSelectorImage"  src="'.$curLoc.'\src\items\\');
				print_r($name);
				print_r('.png"></div>');
					}
				}
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
						<div id="itemSelector" class="itemSelector">

							  
							  <div class="itemSelector-content">
							  	<input id="itemSelectorSearch" type="text" placeholder="Search.." onkeyup="itmSelSearchItems()">
							  	<button class="itemSelectorRefresh">Refresh</button> 
							    <span class="itemSelectorClose">&times;</span>
							    <div class="itemSelectorImages">
							    <?php createIcons(explode("\n",file_get_contents('info.txt'))[0])?>
							</div>
							  </div>

						</div>
					<h1>Add a Trade
</h1>				
					<p> Some items may be greyed out from the other selectors. Use the button to reset the grayed out items.</p>
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
			<div class="store" id="optionStore" style="display:none;"><?php createOptions(explode("\n",file_get_contents('info.txt'))[0]); ?>);
			</div>

			<div id="addTradForm" style="height:100vh;">
							
				<form id="addTrade" action="~addTradeHidden.php">

					 		<h1 style="float:left;"> I want (Buying):  </h1>
					 		<div class="tradeItemStore" style="grid-area:buyItems;">
						 		<div id="buy" class="addItemSelector">	
										Add Item

						 		</div>
							</div>
							
							<h1 style="float:left;"> I have (Selling):  </h1>
							<div class="tradeItemStore" style="grid-area:sellItems;">
							<div id="sell" class="addItemSelector">	
										Add Item

						 		</div>
							</div>
							<p1><b>Comment:</b> </p1>
							<input  id="comment" type="text" name="comment" maxlength="250">
							<input class="hidden" id="accountName" type="text" name="accountName" >
							<input class="hidden" id="email" type="text" name="email" >
							<input class="hidden" id="token"type="text" name="token" >
							<button id="addTradSubmit" type="button">Submit</button>
				</form>
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