<?php
// Load Linkage Variables //
	$dir = dirname(__FILE__);
	$dir		= str_replace("/req/cronjob", "", $dir);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Load Functions
	include($functions);

//Load bitcoind function
	include($bitcoind);

//Connect to database
	connectToDb();

//This watches the blocks the bitcoin network is solving and inserts the newly found block number into the `networkBlocks`
	//Open a bitcoind connection
		$bitcoinController = new BitcoinClient($rpcType, $rpcUsername, $rpcPassword, $rpcHost);

	//Get some variables
		$currentBlockNumber = $bitcoinController->getblocknumber();
	
	//Is this block number in the database already
		$inDatabaseQ = mysql_query("SELECT `id` FROM `networkBlocks` WHERE `blockNumber` = '$currentBlockNumber' LIMIT 0,1");
		$inDatabase = mysql_num_rows($inDatabaseQ);

		if(!$inDatabase){
			//Add this block into the `networkBlocks` log
				$currentTime = time();
				mysql_query("INSERT INTO `networkBlocks` (`blockNumber`, `timestamp`)
									VALUE('$currentBlockNumber', '$currentTime')");
		}



//The following has nothing to do with updating the blocks but it DOES go through all the account balances of more then the minimumCashout 
	//Get minimum cashout
		$minimumCashoutQ = mysql_query("SELECT `cashoutMinimum` FROM `websiteSettings`");
		$minimumCashoutObj = mysql_fetch_object($minimumCashoutQ);
		$minimumCashout = $minimumCashoutObj->cashoutMinimum;

		//Get list of `balances` FROM `accountBalance` that are greater then the cashoutMinumum
			$getListOfAccountsQ = mysql_query("SELECT `id`, `balance`, `userId`, `threshhold` `payoutAddress` FROM `accountBalance` WHERE `balance` > $minimumCashout");
			while($accounts = mysql_fetch_array($getListOfAccountsQ)){
				//Only send balance if there balance exceeds their threashhool
					if($accounts["threshhold"] < $accounts["balance"]){
						//Send `balance` to `payoutAddress`
							$bitcoinController->sendtoaddress($accounts["payoutAddress"], $accounts["balance"]);
					
						//Reset balance to zero
							mysql_query("UPDATE `accountBalance` SET `balance` = '0' WHERE `id` = '".$accounts["id"]."'");
					}
			}
?>



