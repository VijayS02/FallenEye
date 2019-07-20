<html>
<head>
	<meta charset="UTF-8">
	<title>FallenEye</title>
	<link rel="stylesheet" type="text/css" href=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."\style.css"."\"")?>>
	<link rel="icon" type="image/png" href=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."\assets/favicon/favicon-96x96.png"."\"")?>>
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
	<div class="mainWrapper">
		<div class='nav'>
			<a href=<?php print_r("\"".$curLoc."\index.php"."\"")?> class="navIco"><img width="144px" height="48px"  src=<?php print_r("\"".$curLoc."\assets\NavLink.png"."\"")?> alt="Home"></a>
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
				<a href=<?php print_r("\"".explode("\n",file_get_contents('info.txt'))[0]."\login.php"."\"")?> class="nvLgnBtn bounceTrans">LOGIN</a>


			</div>
			<div class="navSrch" style="width:50px;">
					<form action="/src/search.php">
					<input type="text" name="search" placeholder="&#xF002; Search">
				</form>
			</div>


		</div>
		<div class="main">
					<h1>Current Offers</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis incidunt dignissimos error est ut rem ea quibusdam? A vitae consequuntur accusantium beatae ipsam culpa nemo nisi quia, eaque perferendis! Minima!</p>
					
		</div>
		<div style="grid-area: footer;"></div>
		

	</div>
	
</body>
</html>