<?php
//Define the undefined
	$returnError = "";
	$goodMessage = "";
	$loginSuccess = 0;
//Set page starter variables//
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Include hashing functions
	include($functions);

//Perform login
	$loginSuccess = loginUser($_POST["username"], $_POST["password"]);

//Set user details for userInfo box
	$rawCookie = "";
	if(isSet($_COOKIE[$cookieName])){
		$rawCookie = $_COOKIE[$cookieName];
	}
	$getCredientials = new getCredientials;
	$getCredientials->checkLogin($rawCookie);
	$loginValid	= $getCredientials->validCookie;


//Generate message
	if($loginSuccess == 1){
		$goodMessage = "Welcome back!, <br/>".$_POST["username"];		

	}else if($loginSuccess == 0){

		$returnError = "LOGIN FAILED | WHAT DID YOU DO!?";

	}else if($loginSuccess == 3){

		$returnError = "Login failed - You haven't authorised your email account yet";

	}else  if($loginSuccess == 4){

			$returnError = "Login failed | You forgot your user name or password";
	}


?>
<html>
	<head>
		<title><?php echo outputPageTitle();?> - Main Page</title>
		<!--This is the main style sheet-->
		<link rel="stylesheet" href="/css/mainstyle.css" type="text/css" /> 
		<meta http-equiv="refresh" content="3;url=/">
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
				<div class="loginMessages">
					<span class="returnError"><?php echo $returnError;?></span>
					<span class="goodMessage"><?php echo $goodMessage;?></span>
				</div>
			</div>
		</div>
	</body>
</html>
