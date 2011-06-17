{
<?php
// Load Linkage Variables //
$dir = dirname(__FILE__);
$dir		= str_replace("/json", "", $dir);
$req 		= $dir."/req/";
$functions	= $req."functions.php";

//Include hashing functions
include($functions);

connectToDb();
//Get worker status and output them in JSON format
	//Find out which workers belong to this API token
		$apiToken = $_GET["apiToken"];
		$userApiTokenQ = mysql_query("SELECT `id` FROM `websiteUsers` WHERE `apiToken` = '".$apiToken."' LIMIT 0,1");
		$userApiToken = mysql_fetch_object($userApiTokenQ);
		
	//List workers
		//Get time 5 minutes ago
			$timeFiveMinutesAgo = time();
			$timeFiveMinutesAgo -= 60*5;
			
		$workers = mysql_query("SELECT `username` FROM `pool_worker` WHERE `associatedUserId` = '".$userApiToken->id."'");
		while($worker = mysql_fetch_array($workers)){
			//Get this workers infomation
				//Retireve Average Mhash/s
					$getMhashes = mysql_query("SELECT `mhashes` FROM `stats_userMHashHistory` WHERE `username` = '".$worker["username"]."' AND `timestamp` >= '$timeFiveMinutesAgo' ORDER BY `timestamp` DESC");
					$numHashes = mysql_num_rows($getMhashes);
					$totalMhashes = 0;
					while($mhashes = mysql_fetch_array($getMhashes)){
						$totalMhashes += $mhashes["mhashes"];
					}
					
					//Prevent division by zero
					if($totalMhashes > 0 && $totalMhashes > 0){
						$averageHashes = $toatlMhashes/$numHashes;
					}else if($totalMhashes == 0 || $totalMhashes == 0){
						$averageHashes = "0";
					}
					
				//Active
					if($averageHashes == 0){
						$workerActive = "Connected";
					}else if($averageHashes == 1){
						$workerActive = "Dissconnected";
					}
?>
		"User":{
			"username":"<?php echo $worker["username"];?>",
			"currSpeed":"<?php echo $averageHashes;?>",
			"status":"<?php echo $workerActive?>"			
		},
<?php
		}
?>
		"Pool":{
			
		}
}