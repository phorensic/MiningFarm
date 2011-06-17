<?php
// Load Linkage Variables //
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