<?php
// Load Linkage Variables //
$dir = dirname(__FILE__);
$dir		= str_replace("/req/cronjob", "", $dir);
$req 		= $dir."/req/";
$functions	= $req."functions.php";

//Load Functions
include($functions);


//This page will generate stats data and plug it into the database
connectToDb();


//Update timestamps in `shares`//
$listSharesQ = mysql_query("SELECT `time`, `id` FROM `shares` WHERE `epochTimestamp` = '0' ORDER BY `id` DESC")or die(mysql_error());
while($share = mysql_fetch_array($listSharesQ)){
		//Update epochTimestamp
		//Split the wierd timestamp set by MySql
		$splitInputTimeDate = explode(" ", $share["time"]);
		$splitInputDate = explode("-", $splitInputTimeDate[0]);
		$splitInputTime = explode(":", $splitInputTimeDate[1]);
		
		//Make wierd timestamp into a regular Unixtimestamp
		$unixTime = mktime($splitInputTime[0], $splitInputTime[1], $splitInputTime[2], $splitInputDate[1], $splitInputDate[2], $splitInputDate[0]);
		//Update
		mysql_query("UPDATE `shares` SET `epochTimestamp` = '".$unixTime."' WHERE `id` = '".$share["id"]."' LIMIT 1");
		
}


/////////////////////////////////////////////////////////////////
//////////////// Generate User Shares History ///////////////////

//Get all users that are connected, or specificly has sent atleast one share in the past five minutes
$fiveMinutesAgo = time();
$fiveMinutesAgo -= 60*5;

//Get all `pool_workers` and add there current shares data to stats
$poolWorkersQ = mysql_query("SELECT `id`, `associatedUserId`, `username` FROM `pool_worker`");
while($worker = mysql_fetch_array($poolWorkersQ)){
		//Check to see if this worker has subbmitted any shares within the last 5 minutes
			$sharesQ = mysql_query("SELECT `id`, `epochTimestamp` FROM `shares` WHERE `username` = '".$worker["username"]."' AND `epochTimestamp` >= $fiveMinutesAgo");
			$numShares = mysql_num_rows($sharesQ);
			
			if($numShares >= 1){
				//calculate how many shares they subbmitted in the last 5 minutes
				//and at the same time figure out how many seconds it took to subbmit each share
					$lastShare = 0;
					$totalTimeBetweenShares = 0;
					while($share = mysql_fetch_array($sharesQ)){						
						if($lastShare > 0){
							//Subtract $lastShare with $share["epochTimestamp"] = Amount of time between shares
							$timeBetweenShares = $share["epochTimestamp"]-$lastShare;
							$lastShare = $share["epochTimestamp"];
							//Add it to total time between shares
							$totalTimeBetweenShares += $timeBetweenShares;
						}
						
						if($lastShare == 0){
							$lastShare = $share["epochTimestamp"];
						}
					}
					
					//Convert total time between shares in minutes
					$totalTimeBetweenShares /= 60;
					$totalTimeBetweenShares = round($totalTimeBetweenShares, 2);
					echo $worker["id"]."-".$totalTimeBetweenShares."<br/>";
					$insertQuery = "'".$worker["username"]."', '$totalTimeBetweenShares', '".time()."'";
			}else if($numShares == 0){
				//Insert into stats as zero minutes per share
					$insertQuery = "'".$worker["username"]."', '0', '".time()."'";
			}
			
			mysql_query("INSERT INTO `stats_userSharesHistory` (`username`, `minutesPerShare`, `timestamp`) VALUES(".$insertQuery.")");
}


/////////////////////////////////////////////////////////////////////
/////////////// Generate Mhash/s ////////////////////////////////////
//Get all `pool_workers` and add there current MHash/s to the stats
$poolWorkersQ = mysql_query("SELECT `id`, `associatedUserId`, `username` FROM `pool_worker`");
$recordedTime = time();
while($worker = mysql_fetch_array($poolWorkersQ)){
	//Calculate Mhash/s based on the share information in the last give minutes
		$sharesQ = mysql_query("SELECT `id`, `epochTimestamp` FROM `shares` WHERE `username` = '".$worker["username"]."' AND `epochTimestamp` >= $fiveMinutesAgo");
		$numShares = mysql_num_rows($sharesQ);
		if($numShares > 0){
			//Get first share timestamp from the last five minutes
				$firstTimestamp = mysql_query("SELECT `epochTimestamp` FROM `shares` WHERE `id` = '".$worker["id"]."' AND `epochTimestamp` >= $fiveMinutesAgo");
				
			//Hashes per second = Number of shares / timedelta * hashspace
				$hashesPerSecond =  $numShares / (60*5.1) * 4294967296;
				
			//Convert to Mhashes, round then upload to server
				$hashesPerSecond /= 1024;
				$hashesPerSecond /= 1024;
				$hashesPerSecond = ceil($hashesPerSecond);
			//Insert into database
				mysql_query("INSERT INTO `stats_userMHashHistory` (`username`, `mhashes`, `timestamp`) VALUES('".$worker["username"]."', '".$hashesPerSecond."', '".time()."')")or die(mysql_error());
		}else if($numShares == 0){
			//Insert into database
				mysql_query("INSERT INTO `stats_userMHashHistory` (`username`, `mhashes`, `timestamp`) VALUES('".$worker["username"]."', '0', '".$recordedTime."')")or die(mysql_error());
			
		}
	
}





///////////////////////////////////////////////////////////////////////
///////////////// Generate Graphs for display//////////////////////////

//This page will generate graphs
// Standard inclusions      
include("pChart/pData.class");   
include("pChart/pChart.class");

include("graph_mhash.php");
include("graph_minutesPerShare.php");

?>