<?php
// Load Linkage Variables //
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
					Redirecting you to your regularly scheduled program</span>
				</div>
			</div>
		</div>
	</body>
</html>
