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
	<title>FallenEye</title>

	<link id="themeStyle" rel="stylesheet" type="text/css" href=<?php print_r(explode("\n",file_get_contents('info.txt'))[0]."/");print_r(genMode());?>>
	<link rel="icon" type="image/png" href=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."\assets/favicon/favicon-96x96.png"."\"")?>>
	<script src=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."/jquery-3.4.1.js"."\"")?>></script>
	<script src=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."/script.js"."\"")?>></script>
	<script>getPath(<?php print_r( "\"".explode("\n",file_get_contents('info.txt'))[0]."\"");?>)</script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>


</head>
<?php
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
	<div class="mainWrapper" style="height:100%;">
		<div class='nav'>
			<div class="styleSwitcher" style="width:100%;text-align: center;">
			<label class="styleSwitch">
  					<input id="styleChkbx" type="checkbox">
  					<span class="slider round"></span>
			</label>
			</div>
			<a href=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."\index.php"."\"")?> class="navIco"><img class="navIcoImg" width="144px" height="48px"   alt="Home"></a>
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
		<div class="main" style="text-align:center;">
					<div style="z-index: 0;  position: fixed; top: 50%;left: 50%;margin-left: -145px;margin-top: -310px;" ><img class="textLogoMain"width="290px" height="290px" ></div>
					<div id="mainSearchBox" style=""> <form action="/Trading/Current Offers.php" ><input type="text" name="item" ></form></div>
					<p style="  position: fixed; top: 60%;left: 25%;width:50vw;text-align: left;" >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam quia quaerat tempora, molestias molestiae sequi minus deleniti repellendus, voluptatum cum hic! Dolores consectetur quam, delectus nam, vitae iure! Ab architecto itaque voluptatum dolorum ad veritatis, eveniet iure pariatur velit natus aliquid consectetur veniam quas et, sed exercitationem obcaecati cupiditate aliquam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore id distinctio, impedit quasi, quod, corporis voluptates quam harum quae eius provident at laboriosam pariatur. Unde impedit a repudiandae totam harum eos id quas atque illum natus repellendus in, ipsa expedita fugit. Repellat exercitationem facere maxime illo aliquid, aliquam voluptates repudiandae.</p>

			
		</div>
		<div style="grid-area: footer;"></div>


	</div>
	
</body>
</html>