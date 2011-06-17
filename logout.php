<?php
// Load Linkage Variables //
<<<<<<< HEAD
$dir = dirname(__FILE__);
$req 		= $dir."/req/";
$functions	= $req."functions.php";

//Load Functions
include($functions);

setcookie($cookieName, "", time()-9999);	
?>
<!--?xml version="1.0" encoding="iso-8859-1"?-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo outputPageTitle();?> - <?php echo gettext("Main Page");?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<link href="/css/mainstyle.css" rel="stylesheet" type="text/css">
		<meta http-equiv="refresh" content="3;url=/">
	</head> 
	<body>
		<br/><br/>
		<div id="content">

		<?php
		//Include the header & slogan
		include($header);
		////////////////////////////

		?><br/>
		<div id="mainbox">

			<div class="text">
				<span style="text-align:center">
					<h1 class="header">We'll Miss you!</h1>
					<h2>You are now logged out</h2>
				</span>
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
=======
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Load Functions
	include($functions);

setcookie($cookieName, "", time()-9999);
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
			<div id="bodyContent">				<?php 
				//Ouput the login or the users stats depending on weather or not they are logged in
				include($userInfoBox); 
				/////////////////////////////////////
				?>
				<div class="loginMessages">
					<span class="goodMessage">
					<?php echo gettext("Redirecting you to your regularly scheduled program");?>
					</span>
				</div>
			</div>
		</div>
	</body>
</html>
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
