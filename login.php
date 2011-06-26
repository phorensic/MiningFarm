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
	$returnError = "";
	$goodMessage = "";
	$loginSuccess = 0;
}

//Preset refreshtime
$refreshTime = 1;

//Generate message
	if($loginSuccess == 1){
	$goodMessage = gettext("Welcome back, ").$_POST["username"];		
	
	}else if($loginSuccess == 0){
		$returnError = gettext("Database Failed to Query<br/>Please Contact the admin ASAP");
			$refreshTime = 10;
	
	}else if($loginSuccess == 3){
		$returnError = gettext("Login failed <br/> You haven't authorised your email account yet");
			$refreshTime = 3;
	
	}else  if($loginSuccess == 4){
		$returnError = gettext("Login failed <br/> Wrong Username Or Password");
			$refreshTime = 3;
	}else if ($loginSuccess == 5){
		$returnError = gettext("Login failed <br/> Your account has been suspended!");
	}
	
?>
<!--?xml version="1.0" encoding="iso-8859-1"?-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo outputPageTitle();?> - <?php echo gettext("Main Page");?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<link href="/css/mainstyle.css" rel="stylesheet" type="text/css">
		<meta http-equiv="refresh" content="<?php echo $refreshTime;?>;url=/">
	</head> 
	<body>
		<br/><br/>
		<div id="content">
			<?php
			//Include the header & slogan
			include($header);
			////////////////////////////

			?>
			<div id="mainbox">

				<div class="text">
					<h3 class="loginMessages">
						<span class="returnError"><?php echo $returnError;?></span>
						<span class="goodMessage"><?php echo $goodMessage;?></span>
					</h3>
				</div>
				<br><br>
			</div>
			<?php
			//Include Footer
			////////////////////
			include($footer);
			?>
		</div>
		<br/><Br/>

	</body>
</html>