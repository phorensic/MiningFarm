<?php

// Load Linkage Variables //
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Include hashing functions
	include($functions);
	
//Set user details for userInfo box
	$rawCookie		= "";
	if(isSet($_COOKIE[$cookieName])){
		$rawCookie	= $_COOKIE[$cookieName];
	}
	$getCredientials	= new getCredientials;
	$loginValid	= $getCredientials->checkLogin($rawCookie);
?>
<html>
	<head>
		<title><?php echo outputPageTitle();?> - Main Page</title>
		<!--This is the main style sheet-->
		<link rel="stylesheet" href="/css/mainstyle.css" type="text/css" />
		<link rel="shortcut icon" href="/images/favicon.png" />
		<?php
			//If user isn't logged in load the login.js
			if(!$loginValid){
		?>
			<script src="/js/login.js"></script>
		<?php
			}
		?>
		<script type="text/javascript" src="/js/swfobject/swfobject.js"></script>
	</head>
	<body>
		<div id="content">
			<?php
			//Include the header & slogan
			include($header);
			////////////////////////////
			
			//Include the menuLocation
			include($menu);
			////////////////////////////
			?>
			<div id="bodyContent">
				<?php 
					//Ouput the login or the users stats depending on weather or not they are logged in
					include($userInfoBox); 
					/////////////////////////////////////
				?>
				<div id="blogContainer">
					<?php 
					//Output blog posts from the database
					blogPosts(); 
					/////////////////////////////////////
					?>

					<!--Flash charts | Workers to Hash ratio-->
					<script type="text/javascript">
					swfobject.embedSWF("/open-flash-chart.swf", "workerTohashRatio", "500", "200","9.0.0", "expressInstall.swf",{"data-file":"/chartData/hashRateRecent.php"});
					</script>
					 
				</div><br/>
	
				<?php
					//Output Footer
					include($footer);
					///////////////
				?>
			</div>
		</div>
	</body>
</html>
