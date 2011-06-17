<?php
//Comment the following line when debuging this page.
//error_reporting(0);
<<<<<<< HEAD
set_time_limit(60);
=======

>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
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
<<<<<<< HEAD
$globalTime	= time();
$fiveMinutesAgo = time();
$fiveMinutesAgo -= 60*5;
/*
=======
$fiveMinutesAgo = time();
$fiveMinutesAgo -= 60*5;

>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
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
					$insertQuery = "'".$worker["username"]."', '$totalTimeBetweenShares', '".time()."'";
			}else if($numShares == 0){
				//Insert into stats as zero minutes per share
					$insertQuery = "'".$worker["username"]."', '0', '".time()."'";
			}
			
<<<<<<< HEAD
			mysql_query("INSERT INTO `stats_userSharesHistory` (`username`, `minutesPerShare`, `timestamp`) VALUES(".$insertQuery.")")or die(mysql_error());
}
*/
=======
			mysql_query("INSERT INTO `stats_userSharesHistory` (`username`, `minutesPerShare`, `timestamp`) VALUES(".$insertQuery.")");
}

>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

/////////////////////////////////////////////////////////////////////
/////////////// Generate Mhash/s ////////////////////////////////////
//Get all `pool_workers` and add there current MHash/s to the stats
$poolWorkersQ = mysql_query("SELECT `id`, `associatedUserId`, `username` FROM `pool_worker`");
<<<<<<< HEAD
=======
$recordedTime = time();
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
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
<<<<<<< HEAD
				mysql_query("INSERT INTO `stats_userMHashHistory` (`username`, `mhashes`, `timestamp`) VALUES('".$worker["username"]."', '".$hashesPerSecond."', '".$globalTime."')")or die(mysql_error());
		}else if($numShares == 0){
			//Insert into database
			mysql_query("INSERT INTO `stats_userMHashHistory` (`username`, `mhashes`, `timestamp`) VALUES('".$worker["username"]."', '0', '".$globalTime."')")or die(mysql_error());
=======
				mysql_query("INSERT INTO `stats_userMHashHistory` (`username`, `mhashes`, `timestamp`) VALUES('".$worker["username"]."', '".$hashesPerSecond."', '".time()."')")or die(mysql_error());
		}else if($numShares == 0){
			//Insert into database
				mysql_query("INSERT INTO `stats_userMHashHistory` (`username`, `mhashes`, `timestamp`) VALUES('".$worker["username"]."', '0', '".$recordedTime."')")or die(mysql_error());
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
			
		}
	
}

<<<<<<< HEAD
//Get average Mhash for the entire pool
$poolAverageHashQ = mysql_query("SELECT `mhashes` FROM `stats_userMHashHistory` WHERE `mhashes` > 0 AND `timestamp` = '".$globalTime."'");
$numPoolHashRows = mysql_num_rows($poolAverageHashQ);
$averagePoolHash = 0;
while($poolHash = mysql_fetch_array($poolAverageHashQ)){
	$averagePoolHash += $poolHash["mhashes"];
}
if($averagePoolHash > 0 && $numPoolHashRows > 0){
	$averagePoolHash = $averagePoolHash/$numPoolHashRows;
}
//Add pool average to table
mysql_query("INSERT INTO `stats_poolMHashHistory` (`timestamp`, `averageMhash`)
						VALUES('$globalTime', '$averagePoolHash')");


=======




///////////////////////////////////////////////////////////////////////
///////////////// Generate Graphs for display//////////////////////////

//This page will generate graphs
// Standard inclusions      
include($dir."/req/cronjob/pChart/pData.class");   
include($dir."/req/cronjob/pChart/pChart.class");


//Generate the Minutes Per One Share

//Add points on graph
//Get data by the last 5 minutes
/*
 * Feature in progress * * * * *
$lastFiveMinutes = time();
$lastFiveMinutes -= 60*5;
echo "FIVE MINUTES AGO:(".$lastFiveMinutes.")";
$selectTimestamps = mysql_query("SELECT DISTINCT `timestamp` FROM `stats_userSharesHistory` WHERE `timestamp` >= '$lastFiveMinutes' ORDER BY `id` DESC");
$numTimestamps = mysql_num_rows($selectTimestamps);	
if($numTimestamps){
	// Dataset definition    
	$DataSet = new pData;   
	
	while($dTimestamp = mysql_fetch_array($selectTimestamps)){
		$totalMinutesPerShare = 0;
		$averageMinutesPerShare = 0;
		//get all workers that are working in this selected timestamp
		$getWorkers = mysql_query("SELECT `username`, `minutesPerShare`, `id` FROM `stats_userSharesHistory` WHERE `minutesPerShare` > 0 AND `timestamp` = '".$dTimestamp["timestamp"]."'");
		$numWorkers = mysql_num_rows($getWorkers);
		while($worker = mysql_fetch_array($getWorkers)){
		//add data point for this worker
		echo $worker["minutesPerShare"]."-".$worker["username"]."<br/>";
		$totalMinutesPerShare += $worker["minutesPerShare"];
		}
		
		//Divide totalMinutesPerShare by total workers/usernames
		if($numWorkers > 0 && $totalMinutesPerShare > 0){
			$averageMinutesPerShare = $totalMinutesPerShare/$numWorkers;
		}

	//Add point to data
	$DataSet->AddPoint($averageMinutesPerShare, "Pool Average");
	}

	$DataSet->AddAllSeries();  
	$DataSet->setXAxisName("5 Minute Time Period");
	// Initialise the graph  
	$Test = new pChart(550,250);  
	//Set graph labels text font and size
	$Test->setFontProperties("/usr/share/fonts/truetype/freefont/FreeSansBold.ttf",8); 
	//Graph Lines size and position;
	$Test->setGraphArea(35,30,530,200);  
	//???
	$Test->drawFilledRoundedRectangle(7,7,500,223,5,18,127,177);  
	$Test->drawGraphAreaGradient(0,81,119,40,TARGET_BACKGROUND);  
	//Outline rectangle
	$Test->drawRoundedRectangle(5,5,540,225,5,132,115,32);  
	$Test->drawGraphArea(0,81,119,TRUE);  
	$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_ADDALL,150,150,150,TRUE,1,2);     
	$Test->drawGrid(4,TRUE,230,230,230,50); 
	$DataSet->SetYAxisFormat("time");  

	// Draw the cubic curve graph  
	$Test->drawFilledCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription(),.01,50);  

	// Finish the graph  
	$Test->drawTitle(50,22,"Average time in minutes it takes to submit a share",183,183,183,TRUE);  
	$Test->Render($dir."/images/graphs/poolOverview.png");

}
*/
//Generate The Average Pool MHashe/s
//Add points on graph
//Get data by the last 5 minutes
$lastFiveMinutes = time();
$lastFiveMinutes -= 60*6;
$workerList = mysql_query("SELECT DISTINCT `timestamp` FROM `stats_userMHashHistory` WHERE `timestamp` >= '$lastFiveMinutes' ORDER BY `id` DESC");
$numWorkers = mysql_num_rows($workerList);
if($numWorkers){
// Dataset definition    
	$DataSet = new pData;   
	
	
	while($worker = mysql_fetch_array($workerList)){
		//Get Mhash scores for this timestamp, and average them out
		$history = mysql_query("SELECT `id`, `mhashes` FROM `stats_userMHashHistory` WHERE `timestamp` = '".$worker["timestamp"]."'");
		$numHistory = mysql_num_rows($history);
		$averageHashes = 0;
		$totalHashes = 0;
		if($numHistory > 0){
			while($hashHistory = mysql_fetch_array($history)){
				//Add this has to the average variables
				$totalHashes += $hashHistory["mhashes"];
			}
				
			//Calculate average
				$averageHashes = $totalHashes/$numHistory;
		}else if($numHistory == 0){
			$averageHashes = 0;
		}
				
	//Add point to data
	$DataSet->AddPoint($averageHashes, "Pool Average");
	}
}else if ($numWorkers == 0){
		$DataSet->AddPoint(0.1, "Pool Average");
		$DataSet->AddPoint(0.1, "Pool Average");
		$DataSet->AddPoint(0.1, "Pool Average");
}

		
	$DataSet->AddAllSeries();  
	$DataSet->setXAxisName("5 Minute Time Period");
	// Initialise the graph  
	$Test = new pChart(550,160);  
	//Set graph labels text font and size
	$Test->setFontProperties("/usr/share/fonts/truetype/freefont/FreeSansBold.ttf",8); 
	//Graph Lines size and position;
	$Test->setGraphArea(60,30,530,135);  
	//???
	$Test->drawFilledRoundedRectangle(7,7,500,223,5,18,127,177);  
	$Test->drawGraphAreaGradient(0,81,119,40,TARGET_BACKGROUND);  
	//Outline rectangle
	$Test->drawRoundedRectangle(5,5,540,155,5,132,115,32);  
	$Test->drawGraphArea(0,81,119,TRUE);  
	$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_ADDALLSTART0,150,150,150,TRUE,1,2);     
	$Test->drawGrid(4,TRUE,230,230,230,50); 
	$DataSet->SetYAxisFormat("Minutes");  

	// Draw the cubic curve graph  
	$Test->drawFilledCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription(),.01,50);  

	// Finish the graph   
	$Test->setFontProperties("/usr/share/fonts/truetype/freefont/FreeSansBold.ttf",8); 
	$Test->drawTitle(50,22,"Average Mhashes over the course of 5 mintues",183,183,183,TRUE);  
	$Test->Render($dir."/images/graphs/poolOverview-Mhashes.png");
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
?>