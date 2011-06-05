<?php
//Set page starter variables//
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Include hashing functions
	include($functions);

//Perform login
	$loginSuccess =  loginUser($_POST["username"], $_POST["password"]);

//Generate message
	if($loginSuccess == 1){
		$goodMessage = "Welcome back, Were redirecting you to the main page right meow. Just sit tight.";
	}

	if($loginSuccess == 0){
		$returnError = "Login failed - wrong username or password";
	}

	if($loginSuccess == -1){
		$returnError = " Login failed - You haven't authorised your email account yet";
	}
?>
<html>
	<head>
		<title><?php echo outputPageTitle();?> - Main Page</title>
		<!--This is the main style sheet-->
		<link rel="stylesheet" href="/css/mainstyle.css" type="text/css" /> 
		<?php
			//If user isn't logged in load the login.js
			if(!$loginSuccess){
		?>
			<script src="/js/login.js"></script>
		<?php
			}
		?>
		<meta http-equiv="refresh" content="1;url=/">
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
					<span class="returnError"><?php echo $returnError;?></span>
					<span class="goodMessage"><?php echo $goodMessage;?></span>
			</div>
		</div>
	</body>
</html>
