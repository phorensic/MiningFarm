<?php
// Load Linkage Variables //
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Load Functions
	include($functions);


//Check if supplied deatils match those in the databse
	$act = $_POST["act"];
	if($act == "activate"){
		$userId = $_POST["username"];
		$authPin = $_POST["authNumber"];
		$activateSuccess = activateAccount($userId, $authPin);
		if($activateSuccess > 0){
			$goodMessage = "Your acount is activated, You can login to your account now";
		}else{
			$returnError = "Sorry we couldn't find the account you were looking for";
		}
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
						<span class="goodMessage"><?php echo $goodMessage; ?></span><br/>
						<span class="returnError"><?php echo $returnError; ?></span><br/>
						<div id="activateEmail">
							<?php
								$authNumber = "";
								$username = "Username";
								if($_POST["authNumber"]){
									$authNumber = $_POST["authNumber"];
								}
								if($_POST["username"]){
									$username = $_POST["username"];
								}
							?>
							<form action="activateAccount.php" method="post">
								<input type="hidden" name="act" value="activate"/>
								<span class="activateEmail">Type in your username &amp; authorization number below</span><br/>
								<input type="text" value="<?php echo $authNumber; ?>" name="authNumber" value="" size="56"><br/>
								<input type="text" value="<?php echo $username; ?>" name="username"><br/>
								<input type="submit" value="Authorise Email">
							</form>
						</div>
				</div>
				<?php
					//Output Footer
					include($footer);
					///////////////
				?>
			</div>
		</div>
	</body>
</html>