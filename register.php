<?php
//Define the undefined
	$goodMessage = "";
	$returnError = "";
	$tmpUsername = "";
	$tmpPassword = "";
	$tmpPassword2	= "";
	$tmpEmail	= "";
	$tmpEmail2	= "";
	$tmpAuthPin	= "";

// Load Linkage Variables //
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Load Functions
	include($functions);

//Perform login
	$getCredientials	= new getCredientials;
	$loginSuccess		= $getCredientials->checkLogin($_COOKIE[$cookieName]);

//Connect to Db
	connectToDb();

//Perform register if the user isn't already logged in
	$act =  $_POST["act"];
	
	if($act == "signup"){
		if($loginSuccess == 0){
			//Check inputted details make sure they are okay
				$validCredentials = 1;
				if($_POST["password"] != $_POST["password2"]){
					$validCredentials = 0;
					echo "password fail";
				}
				if($_POST["email"] != $_POST["email2"]){
					$validCredentials = 0;
					echo "email fail";
				}

				if(strlen($_POST["authPin"]) < 4){
					$validCredentials = 0;
				}

				//If $validCredientials is still true, then send the user an email
				if($validCredentials == 1){
					//Mysql Injection Protection Agency
						$email = mysql_real_escape_string($_POST["email"]);
						$username = mysql_real_escape_string($_POST["username"]);
						$password = mysql_real_escape_string($_POST["password"]);
						$authPin = mysql_real_escape_string($_POST["authPin"]);

					//Make sure the username isn't already in the databse
						$usernameExistsQ = mysql_query("SELECT `id` FROM `websiteUsers` WHERE `username` = '".$username."'");
						$usernameExists = mysql_num_rows($usernameExistsQ);

						if($usernameExists == 0){
								//Hash password
									
									$hashedPassword = hash("sha256", $password);

								//Generate an authoriseEmailPin
									$authoriseEmailPin = genRandomString(64);
									
								//Hash auth pin
									$authPin = hash("sha256", $authPin);
								//Insert user into the `websiteUsers` database and retireve the `id`
									$insertSuccess = mysql_query("INSERT INTO `websiteUsers`
														(`username`, `password` , `emailAuthorisePin`, `email`, `authPin`)
													VALUES('$username', '$hashedPassword', '$authoriseEmailPin', '$email', '$authPin')") or die(mysql_error());
									
									//Get userId
									$insertId = mysql_insert_id();

									//If user was successfully added to database
									if(isSet($insertSuccess) && $insertId > 0){
										//Send confirmation email
												//Get prefix message to write the user
													$emailMessageQ = mysql_query("SELECT `noreplyEmail`, `confirmEmailPrefix` FROM `websiteSettings` LIMIT 0,1");
													$emailMessageObj = mysql_fetch_object($emailMessageQ);
													$noreplyEmail = $emailMessageObj->noreplyEmail;
													$message = $emailMessageObj->confirmEmailPrefix;
												
													//Add suffix to the activation link
														$serverAddress = $_SERVER['HTTP_HOST'];
														$message .= "\n<br/>Authorization #\n<br/>".$authoriseEmailPin."\n<br/>http://$serverAddress/activateAccount.php";
											
												//Send an email with all the information
													$to      = $email;
													$subject = "Account Activation For ".$username;
													$headers = "From: ".$noreplyEmail;

													mail($to, $subject, $message, $headers);

												$goodMessage = "Registration was a success! | Login to your email, ".$_POST["email"]." and click on link to activate your account!";
											

										//Add a zero balance to `accountBalance`
											mysql_query("INSERT INTO `accountBalance` (`userId`, `balance`)
																VALUES('".$insertId."', '0.00')");
									}else{
										$returnError = "Database error | User was not added to database, Please contact the admin.";
									}
							}else if($usernameExists > 0){
								$returnError = "That username is already registered with us";
							}
				}else if($validCredentials == 0){
					$returnError = "Please check that you passwords match as well as your email; Auth Pin must be numbers only and 4 digits long no more, no less.";
				}
		}else{
			$returnError = "You are already have an account with us.";
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
					<?php if($goodMessage || $returnError){?>
					<span class="goodMessage"><?php echo $goodMessage; ?></span><br/>
					<span class="returnError"><?php echo $returnError; ?></span><br/><br/>
					<?php }

						if($goodMessage == ""){
					?>
							<h2 id="registerHeader">We just need a few details</h2><br/>
							
							<form action="/register.php" method="post">
								<input type="hidden" name="act" value="signup"/>
								<?php
									if(isSet($_POST["username"])){
										$tmpUsername	= $_POST["username"];
									}else{
										$tmpUsername 	= "";
									}
									if(isSet($_POST["password"])){
										$tmpPassword	= $_POST["password"];
									}else{
										$tmpPassword	= NULL;
									}
									if(isSet($_POST["password2"])){
										$tmpPassword2	= $_POST["password2"];
									}else{
										$tmpPassword2	= "";
									}
									if(isSet($_POST["email"])){
										$tmpEmail	= $_POST["email"];
									}else{
										$tmpEmail	= "";
									}
									if(isSet($_POST["email2"])){
										$tmpEmail2	= $_POST["email2"];
									}else{
										$tmpEmail2	= "";
									}
									if(isSet($_POST["authPin"])){
										$tmpAuthPin	= $_POST["authPin"];
									}else{
										$tmpAuthPin	= "";
									}
								?>
								Username:<input type="text" name="username" value="<?php echo $tmpUsername; ?>" maxlength="20" size="10"/><br/>
								Password:<input type="password" name="password" value="<?php echo $tmpPassword;?>" maxlength="45" size="10"/><br/>
								Retype Password:<input type="password" name="password2" value="<?php echo $tmpPassword2;?>" maxlength="45" size="10"/><br/>
								<hr size="1" width="100%"><br/>
								Real Email: <input type="text" name="email" value="<?php echo $tmpEmail;?>" size="15"/><br/>
								Retype Email: <input type="text" name="email2" value="<?php echo $tmpEmail2;?>" size="15"/><br/>
								<hr size="1" width="100%"><br/>
								Authorization Pin: <input type="password" name="authPin" value="<?php echo $tmpAuthPin;?>" size="4" maxlength="4">(Memorize this 4 digit pin #)<br/>
								<input type="submit" value="Register">
							</form>
					<?php
						}
					?>
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
