<?php
//Fit to your need variables // These should be the only variables you need to edit
$mysqlUsername	= "root";
$mysqlPassword	= "13linux13";
$mysqlDatabase	= "mp3";
$mysqlHost	= "localhost";

//Linkage
$header		= $req."header.php";
$menu		= $req."menu.php";
$userInfoBox	= $req."loginAndStats.php";
$footer		= $req."footer.php";
$bitcoind	= $req."/bitcoinWallet/bitcoin.inc.php";

//Cookies!
$cookieName = "miningpool2";
$cookiePath = "/";
$cookieDomain = "";

//Email
$fromAddress = "Localhost@Localhost.com";

//Bitcoind RPC information
$rpcType	= "http";
$rpcUsername	= "xenland";
$rpcPassword 	= "fuckyou"; //I dont purposely put this to offend anyone, its just easy to remember
$rpcHost	= "localhost";


//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////   START   ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

//Random string Generator
function genRandomString($length=10){
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}

///////////////Internal functions ////////////////////////////////////////////////////////
function connectToDb(){
	//Make global
		global $mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase;

	//Connect
		mysql_connect($mysqlHost, $mysqlUsername, $mysqlPassword);
		mysql_select_db($mysqlDatabase);
}


function loginUser($username, $password){
		$loginSuccess = 0;
	//Make global
		global $cookieName, $cookiePath, $cookieDomain;

	//Connect to db
		connectToDb();

	//mysql injection protection
		$username = mysql_real_escape_string($username);

	//Hash password for password checking
		$password = hash("sha256", $password);
	//Check if this login an username is correct

		$loginCheckQ	= mysql_query("SELECT `id`, `emailAuthorised` FROM `websiteUsers` WHERE `username` = '".$username."' AND `password` = '".$password."' LIMIT 0,1")or die(mysql_error());
		$loginObj	= mysql_fetch_object($loginCheckQ);
		$userId 	= $loginObj->id;
		$emailAuthorised = $loginObj->emailAuthorised;

	//Set cookie; If validlogin is true
			if($emailAuthorised == 1){
				//Get ip address so we can hash with the cookie
					$ip = $_SERVER['REMOTE_ADDR'];
					$timeoutStamp = time()+60*30; //30 minute session

				//Update logged in ip address so no one can steal this cookie hash unless
					mysql_query("UPDATE `websiteUsers` SET `sessTimestamp` = ".$timeoutStamp.", `loggedIp` = '".$ip."' WHERE `id` = '".$userId."'");

				//Generate random secret
					$randomSecret = genRandomString(10);
					//Update random string to database so we can hash it into the cookie
						mysql_query("UPDATE `websiteUsers` SET `randomSecret` = '".$randomSecret."' WHERE `id` = '".$userId."'");

				//Set cookie in browser for session
					//Get hashed password for hashing the cookie
						$getPassQ = mysql_query("SELECT `password` FROM `websiteUsers` WHERE `id` = '".$userId."'");
						$getPassObj = mysql_fetch_object($getPassQ);

					//Make cookie :)
						$hash	= $randomSecret.$password.$ip.$timeoutStamp;
						$hash = hash("sha256", $hash);
						setcookie($cookieName, $userId."-".$hash, $timeoutStamp, $cookiePath, $cookieDomain);

				//Successfull login code
					$loginSuccess = 1;

			}else if($emailAuthorised == 0){

				$loginSuccess = 3;
			}
	//Return Boolean;
		return $loginSuccess;
}

class getCredientials{
	//Validation variables (Don't change)
		public $validCookie = 0;
		public $userId = 0;
		public $hashedAuthPin = "";
		public $isAdmin = 0;

	//Stats variables
		public $username = "";
		public $totalShares = 0;
		public $totalPoolShares = 0;
		public $estimatedReward = 0;
		public $accountBalance = 0;
		public $email = "";
		public $sendAddress = "";
		public $threshHold = 0;

	//Admin variables
		public $adminHeader = "";
		public $adminSlogan = "";
		public $adminBrowserTitle = "";
		public $adminCashoutMin = 0;
		public $adminEmail = "";

	function checkLogin($rawCookie){
		//Make global
			global $cookieName, $cookiePath, $cookieDomain;

		//Preset vars
			$validCookie = 0;
			$ip = $_SERVER['REMOTE_ADDR'];

		//Connect to db
			connectToDb();
		
		//Split cookie into 2
			$splitCookie = explode("-", $rawCookie);
			$cookieUserid = mysql_real_escape_string($splitCookie[0]);
			$cookieHash = $splitCookie[1];
		
		//Get database information to match the cookie hash with
			$dbHashInfoQ = mysql_query("SELECT `sessTimestamp`, `randomSecret`, `loggedIp`, `password`, `authPin`, `isAdmin` FROM `websiteUsers` WHERE `id` = '".$cookieUserid."'");
			$dbHashInfoObj = mysql_fetch_object($dbHashInfoQ);
			
			$dbTimestamp	= $dbHashInfoObj->sessTimestamp;
			$dbrandomSecret	= $dbHashInfoObj->randomSecret;
			$dbIp		= $dbHashInfoObj->loggedIp;
			$dbPassword	= $dbHashInfoObj->password;
			$dbAuth		= $dbHashInfoObj->authPin;
			$dbisAdmin	= $dbHashInfoObj->isAdmin;

		//Hash database information to check against the already hash cookie.
			$dbHash = $dbrandomSecret.$dbPassword.$dbIp.$dbTimestamp;
			$dbHash = hash("sha256", $dbHash);

		//Make sure the supplied $ip == $dbIp;
			if($ip == $dbIp){
				//Ip address matches now check forthe cookie and database hashes *Cross your fingers :)
					if($dbHash == $cookieHash){
						$validCookie = 1;
						$this->validCookie = 1;
						$this->userId = $cookieUserid;
						$this->hashedAuthPin = $dbAuth;
						$this->isAdmin	= $dbisAdmin;
					}
			}

		return $validCookie;
	}


	function getStats(){
		//Connect to db
			connectToDb();

		//Get username for prefix searching
			$getUsernameQ = mysql_query("SELECT `username`, `email` FROM `websiteUsers` WHERE `id` = '".$this->userId."'");
			$getUsernameObj = mysql_fetch_object($getUsernameQ);
			$username	= $getUsernameObj->username;
			$email		= $getUsernameObj->email;

		//Get number of shares this user has inputted
			$shareCountQ = mysql_query("SELECT `id` FROM `shares` WHERE `username` LIKE '$username.%'");
			$numShares = mysql_num_rows($shareCountQ);

		//Get number of total pool shares
			$totalPoolSharesQ = mysql_query("SELECT `id` FROM `shares`");
			$totalPoolShares = mysql_num_rows($totalPoolSharesQ);

		//Get estimated earnings
			$estReward = 0;
			if($totalPoolShares > 0 && $totalShares > 0){
				$estReward = $totalPoolShares/$numShares;
				$estReward = 50*$estReward;
			}

		//Get account balance
			$balanceQ = mysql_query("SELECT `payoutAddress`, `balance`, `threshhold` FROM `accountBalance` WHERE `userId` = ".$this->userId)or die(mysql_error());
			$balanceObj = mysql_fetch_object($balanceQ);
			$balance = $balanceObj->balance;

		//Set stats variables
			$this->username = $username;
			$this->totalShares = $numShares;
			$this->totalPoolShares = $totalPoolShares;
			$this->estimatedReward = $estReward;
			$this->accountBalance = $balance;
			$this->email		= $email;
			$this->threashhold	= $balanceObj->threshhold;
			$this->sendAddress	= $balanceObj->payoutAddress;

		return true;
	}

	function getAdminSettings(){
			//Connect to db
				connectToDb();

			//Get website settings
				$websiteSettingsQ = mysql_query("SELECT `header`, `confirmEmail`, `slogan`, `browserTitle`, `cashoutMinimum` FROM `websiteSettings`");
				$websiteSettings = mysql_fetch_object($websiteSettingsQ);

				$this->adminHeader		= $websiteSettings->header;
				$this->adminSlogan		= $websiteSettings->slogan;
				$this->adminBrowserTitle	= $websiteSettings->browserTitle;
				$this->adminCashoutMin		= $websiteSettings->cashoutMinimum;
				$this->adminEmail		= $websiteSettings->confirmEmail;
		}
}

function getCashoutMin(){
	//Connect to db
		connectToDb();

	//Get cash out minimum
		$cashOutMinQ = mysql_query("SELECT `cashoutMinimum` FROM `websiteSettings`");
		$cashOutMinObj = mysql_fetch_object($cashOutMinQ);
	
		return (int)$cashOutMinObj->cashoutMinimum;
}



function activateAccount($userId, $authPin){
		$detailsMatch = 0;

	//Connect to database
		connectToDb();

	//Mysql injection protection
		$email = mysql_real_escape_string($email);
		$emailAuthPin = mysql_real_escape_string($authPin);


	//Check if details match
		$detailsMatchQ = mysql_query("SELECT `email` FROM `websiteUsers` WHERE `id` = '$userId' AND `emailAuthorisePin` = '$emailAuthPin'")or die(mysql_error());
		$detailsMatch = mysql_num_rows($detailsMatchQ);


		if($detailsMatch > 0){
			//Activate this account
				mysql_query("UPDATE `websiteUsers` SET `emailAuthorised` = '1' WHERE `id` = '$userId'");
		}
	return $detailsMatch;
}

////////////// Content Output ////////////////////////////////////////////////////////////
//Output the browser title bar

function outputPageTitle(){
	//Connect to database
		connectToDb();

	//Get browser title
		$browserTitleQ = mysql_query("SELECT `browserTitle` FROM `websiteSettings`");
		$browserTitle = mysql_fetch_object($browserTitleQ);

	//Output browser title
		return $browserTitle->browserTitle;
}

function outputHeaderTitle(){
	//Connect to database
		connectToDb();
	
	//Get header
		$headerQ = mysql_query("SELECT `header` FROM `websiteSettings`");
		$headerObj = mysql_fetch_object($headerQ);

	//Output header
		return $headerObj->header;
}

function outputHeaderSlogan(){
	//Connect to database
		connectToDb();
	
	//Get header
		$sloganQ = mysql_query("SELECT `slogan` FROM `websiteSettings`");
		$sloganObj = mysql_fetch_object($sloganQ);

	//Output header
		return $sloganObj->slogan;
}

//Output the blog
function blogPosts(){
	//Connect to databse
		connectToDb();

	//Get blog posts
		$blogPostsQ = mysql_query("SELECT `timestamp`, `title`, `message` FROM `blogPosts` ORDER BY `timestamp` DESC");
		while($blog = mysql_fetch_array($blogPostsQ)){
	?>
			<div class="blogPost">
				<h2 style="text-decoration:underline;"><?php echo $blog["title"]." | ".date("M,d Y g:ja", $blog["timestamp"]);?></h2><br/>
				<?php echo $blog["message"]?>
			</div>
	<?php
						}
}
?>