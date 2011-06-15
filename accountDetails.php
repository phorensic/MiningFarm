<?php
// Load Linkage Variables //
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Include hashing functions
	include($functions);

//Include bitcoind functions
	include($bitcoind);

//Set user details for userInfo box
	$rawCookie		= "";
	if(isSet($_COOKIE[$cookieName])){
		$rawCookie	= $_COOKIE[$cookieName];
	}
	$getCredientials	= new getCredientials;
	$loginValid		= $getCredientials->checkLogin($rawCookie);

if($loginValid){
	//Check which action this user is trying to commence
		$act = $_POST["act"];

		if($act != ""){
			//Open a bitcoind connection
				$bitcoinController = new BitcoinClient($rpcType, $rpcUsername, $rpcPassword, $rpcHost);

			//Check to see if there authorisation pin matches the one in database
				$hashedInputPin = hash("sha256", $_POST["authPin"]);
				$hashedDbPin = $getCredientials->hashedAuthPin;
				if($hashedDbPin == $hashedInputPin){
					if($act == "editIdentity"){
						//Update identity information
							$payoutAddress = mysql_real_escape_string($_POST["payoutAddress"]);
							$threshHold = mysql_real_escape_string($_POST["payoutThreashHold"]);
							
							//Validate $payoutAddress is valid;
								$openBitcoinClient	= new Bitcoin();
								$isValidPayment	= $openBitcoinClient->checkAddress($payoutAddress);

								if(!$isValidPayment){
									//This isn't a valid bitcoin address delete before we stick it in the db
										$payoutAddress = "";
										$returnError = gettext("The bitcoin address you supplied was invalid and therefore not updated into the system");
								}else if($isValidPayment){
	
										$updateSuccess = mysql_query("UPDATE `accountBalance` SET `payoutAddress` = '".$payoutAddress."', `threshhold` = '".$threshHold."' WHERE `userId` = '".$getCredientials->userId."'")or die(mysql_error());
										if($updateSuccess){
											$goodMessage = gettext("Information was successfully updated!");
										}else if(!$updateSuccess){
											$returnError = gettext("Database Error | Contact the admin");
										}
								}
					}

					if($act == "manualCashout"){
						//Manually cashing out
					
							//Does this accountbalance meet the `cashoutMinimum`
								$accountBalance = $getCredientials->accountBalance;
								$cashOutAddress = $getCredientials->sendAddress;
								$userId		= $getCredientials->userId;
								$cashOutMin	= getCashoutMin();
								if($accountBalance >= $cashOutMin){
									//Subtract $accountBalance by 0.01 for the hardwired transaction fee
										$accountBalance -= 0.01;

										$successSend = $bitcoinController->sendtoaddress($cashOutAddress, $accountBalance);

									//Reset account balance to zero
										if($successSend){
											mysql_query("UPDATE `accountBalance` SET `balance` = '0' WHERE `userId` = '".$userId."'");
											$goodMessage = gettext("Successfully sent the amount of ").$accountBalance.gettext(" minus the 0.01 transaction fee to the bitcoin address of ").$cashOutAddress;
										}else{
											$returnError = gettext("Bitcoind Query Error | Contact admin!");
										}

								}else if($accountBalance < $cashOutMin){
									//No enough funds
									$returnError =  gettext("The operator thinks it is best to have atleaset <b>".$cashOutMin."BTC</b> to cashout.");
								}
					}
				}else{
					$returnError = gettext("Authorisation Pin number you entered didn't match our records");
				}

				
		}
?>
<html>
	<head>
		<title><?php echo outputPageTitle();?> - Account Details</title>
		<!--This is the main style sheet-->
		<link rel="stylesheet" href="/css/mainstyle.css" type="text/css" />
		<link rel="shortcut icon" href="/images/favicon.png" />
		<script type="text/javascript" src="/js/tooltipFollower.js"/>
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
					$getCredientials->getStats();
				?>
					<div id="tooltip">&nbsp;</div>
					<span class="goodMessage"><?php echo $goodMessage; ?></span><br/>
					<span class="returnError"><?php echo $returnError; ?></span><br/>
					<br/>
					<h3 class="accountHeader">Identity Details</h2>
					<?php echo gettext("Username");?>: <?php echo $getCredientials->username;?><br/>
					<?php echo gettext("Confirmed Email");?>: <?php echo $getCredientials->email;?><br/>
					<?php echo gettext("Confirmed Balance");?>: <?php setlocale(LC_MONETARY, 'en_US');
									echo money_format('%i', $getCredientials->accountBalance);?>BTC<br/><br/>
					<h3 class="accountHeader"><?php echo gettext("Edit your payout");?></h2>
					<form action="accountDetails.php" method="post">
						<input type="hidden" name="act" value="editIdentity">
						<?php echo gettext("Payout Address");?>:<input type="text" size="32" name="payoutAddress" value="<?php echo $getCredientials->sendAddress;?>"><br/>
						<?php echo gettext("Automatic Payout at");?>:<input type="text" size="5" name="payoutThreashHold" value="<?php if(!isSet($getCredientials->threashhold)){ echo "0.5";}else{ echo $getCredientials->threashhold;}?>"><b>BTC</b> (0 = <?php echo gettext("Disabled");?>)<br/>
						<i><?php echo gettext("Authorisation Pin");?>:</i> <input type="password" name="authPin" value="" size="4" maxlength="4"><br/>
						<input type="submit" value="<?php echo gettext("Update Payout Address");?>">
					</form>
					<hr size="1" width="500"><br/><br/>

					<h3 class="accountHeader">Manual Payout</h2>
					<form action="accountDetails.php" method="post">
						<input type="hidden" name="act" value="manualCashout">
						<i>Authorisation Pin:</i> <input type="password" name="authPin" value="" size="4" maxlength="4"><br/>
						You will be sending the amount of <b><?php echo $getCredientials->accountBalance;?>BTC</b>
						to the <br/>bitcoin address of <?php
								if(isSet($getCredentials->sendAddress)){
									echo $getCredientials->sendAddress;
								}else{
									echo "<b>".gettext("None")."</b>";
								}?><br/>
						<input type="submit" value="<?php echo gettext("Execute Payout");?>">
					</form>
					<hr size="1" width="500"><br/><br/>
					
					<h3 class="accountHeader"><?php echo gettext("Workers");?></h2>
					<iframe src="/workers.php" width="500" height="250" frameborder="0" allowtransparency="true"></iframe>

				<?php
					//Output Footer
					include($footer);
					///////////////
				?>
			</div>
			<div id="sideContent">
				<h3 class="accountHeader"><?php echo gettext("JSON Mining &amp; Worker Data");?></h3><br/>
				<input type="text" name="nothing" value="<?php echo $getCredientials->apiToken;?>" size="40" onMouseOver="showTooltip('<?php echo gettext("API token to give you <i>private</i> access to your worker status");?>');" onMouseOut="hideTooltip();"/><br/>
				<a href="/json/workerstatus.php"><?php echo gettext("Worker Status");?></a><br/>
				<a href="/json/poolstats.php"><?php echo gettext("Overall Stats");?></a>
			</div>
		</div>
	</body>
</html>

<?php
}else{
	header("Location: /");
}
?>