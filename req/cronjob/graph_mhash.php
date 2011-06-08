<?php
 // Dataset definition    
 $DataSet = new pData;   

 //Add points on graph
 //Get data by the last 5 minutes
 $lastFiveMinutes = time();
 $lastFiveMinutes -= 60*6;
 $workerList = mysql_query("SELECT DISTINCT `timestamp` FROM `stats_userMHashHistory` WHERE `timestamp` >= '$lastFiveMinutes' ORDER BY `id` DESC");
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
					echo $totalHashes."<br/>";
			}
			
			//Calculate average
				$averageHashes = $totalHashes/$numHistory;
		}else if($numHistory == 0){
				$averageHashes = 0;
		}
		
	echo $averageHashes;
	//Add point to data
	$DataSet->AddPoint($averageHashes, "Pool Average");
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
   $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_ADDALL,150,150,150,TRUE,1,2);     
   $Test->drawGrid(4,TRUE,230,230,230,50); 
    $DataSet->SetYAxisFormat("Minutes");  
   
   // Draw the cubic curve graph  
   $Test->drawFilledCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription(),.01,50);  
   
   // Finish the graph   
   $Test->drawTitle(50,22,"Average Mhashes over the course of 5 mintues",183,183,183,TRUE);  
   $Test->Render($dir."/images/graphs/poolOverview-Mhashes.png");
?>