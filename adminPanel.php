<?php
// Load Linkage Variables //
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Load Functions
	include($functions);

//Include bitcoind functions
	include($bitcoind);

//Perform login
	$getCredientials	= new getCredientials;
	$loginSuccess		= $getCredientials->checkLogin($_COOKIE[$cookieName]);

	$isAdmin = $getCredientials->isAdmin;
if($loginSuccess && $isAdmin){
		//Check if there was an action
		$act = $_POST["act"];
		$hashedAuthInput = hash("sha256", $_POST["authPin"]);
		if($act &&  $hashedAuthInput == $getCredientials->hashedAuthPin){
			if($act == "websiteSettings"){
				//Update websiteSettings
					$postHeader = mysql_real_escape_string($_POST["header"]);
					$postEmail	= mysql_real_escape_string($_POST["confirmEmail"]);
					$postSlogan = mysql_real_escape_string($_POST["slogan"]);
					$postBrowserTitle = mysql_real_escape_string($_POST["browserTitle"]);
					$postCashOut = mysql_real_escape_string($_POST["cashoutMin"]);

					mysql_query("UPDATE `websiteSettings` 
							SET `header` = '".$postHeader."',
								`noreplyEmail` = '".$postEmail."',
								`slogan` = '".$postSlogan."',
								`browserTitle` = '".$postBrowserTitle."',
								`cashoutMinimum` = '".$postCashOut."'")or die(mysql_error());
			
			}
		}else if($act && $hashAuthInput != $getCredientials->hashedAuthPin){
			$returnError = "Auth pin was not valid!";
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
		<script type="text/javascript">
			function updateBrowserTitle(){
				document.title = document.getElementById("browserTitleInput").value;
			}

			function updateHeader(){
				document.getElementById("headerTitle").innerHTML = document.getElementById("headerInput").value;
			}

			function updateSlogan(){
				document.getElementById("sloganTitle").innerHTML = document.getElementById("sloganInput").value;
			}
		</script>
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
					$getCredientials->getAdminSettings();
				?>
					
					<span class="goodMessage"><?php echo $goodMessage; ?></span><br/>
					<span class="returnError"><?php echo $returnError; ?></span><br/>
					<h2 style="text-decoration:underline;">Website Settings</h2>
						<form action="?" method="post">
							<input type="hidden" name="act" value="websiteSettings">
							Browser Title:<input type="text" id="browserTitleInput" name="browserTitle" value="<?php echo $getCredientials->adminBrowserTitle;?>" onKeyPress="updateBrowserTitle();" onKeyUp="updateBrowserTitle();" onKeyDown="updateBrowserTitle();"><br/>
							Header:<input type="text" name="header" value="<?php echo $getCredientials->adminHeader;?>" id="headerInput" onKeyPress="updateHeader();" onKeyUp="updateHeader();" onKeyDown="updateHeader();"><br/>
							Slogan:<input type="text" name="slogan" value="<?php echo $getCredientials->adminSlogan;?>" id="sloganInput" onKeyPress="updateSlogan();" onKeyUp="updateSlogan();" onKeyDown="updateSlogan()"><br/>
							Cashout Minimum:<input type="text" name="cashoutMin" value="<?php echo $getCredientials->adminCashoutMin;?>" size="4" maxlength="10"><br/>
							Confirmation Email: <input type="text" name="confirmEmail" value="<?php echo $getCredientials->adminEmail;?>"><br/>
							<br/>
							Auth Number:<input type="password" name="authPin" value="" size="4" maxlength="4"><br/>
							<input type="submit" value="Update Website Settings"/>
						</form>
					<hr size="1" width="100%"><br/><br/>
					<h2 style="text-decoration:underline;">In-Depth Graphs (Comming v3.1)</h2>
				<?php
					//Output Footer
					include($footer);
					///////////////
				?>
			</div>
		</div>
	</body>
</html>

<?php
}else{
	header("Location: /");
}
?>