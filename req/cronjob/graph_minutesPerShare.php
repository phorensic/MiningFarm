<?php 


 // Dataset definition    
 $DataSet = new pData;   

 //Add points on graph
 //Get data by the last 5 minutes
 $lastFiveMinutes = time();
 $lastFiveMinutes -= 60*6;
 $selectTimestamps = mysql_query("SELECT DISTINCT `timestamp` FROM `stats_userSharesHistory` WHERE `timestamp` >= '$lastFiveMinutes' ORDER BY `id` DESC");
 
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
?>