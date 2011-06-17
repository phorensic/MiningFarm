<<<<<<< HEAD
<?php
// Load Linkage Variables //
$dir = dirname(__FILE__);
$req 		= $dir."/req/";
$functions	= $req."functions.php";

//Include hashing functions
include($functions);


//Set user details for userInfo box
$rawCookie		= "";
if(isSet($_COOKIE[$cookieName])){
	$rawCookie	= $_COOKIE[$cookieName];
	}
	$getCredientials	= new getCredientials;
	$loginValid	= $getCredientials->checkLogin($rawCookie);
?>
<!--?xml version="1.0" encoding="iso-8859-1"?-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo outputPageTitle();?> - <?php echo gettext("Main Page");?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<link href="/css/mainstyle.css" rel="stylesheet" type="text/css">
	</head> 
	<body>
	<br/><br/>
		<div id="content">
			
				<?php
				//Include the header & slogan
				include($header);
				////////////////////////////
				
				?>
			<div id="mainbox">
				<?php
					//Get credentials
						$getCredientials->getStats();
						
					//generate graph information
						//Get this individuals mhash
							$fiveMinutesAgo = time();
							$fiveMinutesAgo -= 60*5;
							$userHashHistoryQ = mysql_query("SELECT DISTINCT `timestamp` FROM `stats_userMHashHistory` WHERE `username` LIKE '".$getCredientials->username.".%' AND `timestamp` >= '$fiveMinutesAgo' ORDER BY `timestamp` DESC");
							$numRows = mysql_num_rows($userHashHistoryQ);
							
							//Go through every time stamp and average out all the workers per timestamp
								$userHashArray = "";
								$timeHashArray = "";
								$poolHashArray = "";
								
							if($numRows > 0){
								$i=0;
								while($time = mysql_fetch_array($userHashHistoryQ)){
									$tmpHashAverage = 0;
									//Get all mhash results with this timestamp and average them up
										$getAllWorkerHash = mysql_query("SELECT `mhashes` FROM `stats_userMHashHistory` WHERE `username` LIKE '".$getCredientials->username.".%' AND `timestamp` = '".$time["timestamp"]."'");
										$numWorkersThisTime = mysql_num_rows($getAllWorkerHash);
										while($workerHash = mysql_fetch_array($getAllWorkerHash)){
											$tmpHashAverage += $workerHash["mhashes"];
										}
										$tmpHashAverage = $tmpHashAverage/$numWorkersThisTime;
										
									//Get pool average results
										$getPoolAverageResult = mysql_query("SELECT `averageMhash` FROM `stats_poolMHashHistory` WHERE `timestamp` = '".$time["timestamp"]."' LIMIT 0,1");
								
											$poolAverage = mysql_fetch_object($getPoolAverageResult);
											$poolAverage = $poolAverage->averageMhash;
										
									//Add points to graph
										if($i > 0){
											$userHashArray .= ",";
											$timeHashArray .= ",";
											$poolHashArray .= ",";
										}
										$i++;
										$timeHashArray .= "'".date("G:i:s", $time["timestamp"])."'";
										$userHashArray .= $tmpHashAverage;
										$poolHashArray .= $poolAverage;
								}
							}else if($numRows == 0){
								$i=0;
								//Go through the pool history and display that
									$poolHistory = mysql_query("SELECT `averageMhash`, `timestamp` FROM `stats_poolMHashHistory` WHERE `timestamp` >= '".$fiveMinutesAgo."' ORDER BY `timestamp` DESC");
									while($poolHash = mysql_fetch_array($poolHistory)){
										if($i > 0){
											$poolHashArray .=",";
											$timeHashArray .=",";
										}
										$i++;
										$poolHashArray .= $poolHash["averageMhash"];
										$timeHashArray .= "'".date("G:i:s", $time["timestamp"])."'";
									}
							}
				?>
				<script type="text/javascript">
					var chart1; // globally available
					$(document).ready(function() {
						chart1 = new Highcharts.Chart({
							chart: {
								renderTo: 'graph',
								defaultSeriesType: 'line',
								width:750,
								height:250
							},
							title: {
								text: 'Average Hashes (Up to date by the minute)'
							},
							xAxis: {
								categories: [<?php echo $timeHashArray;?>]
							},
							yAxis: {
								title: {
									text: 'Mega-Hashes'
								}
							},
							series: [{
								name: 'Pool Average',
								data: [<?php echo $poolHashArray; ?>]
								}
								<?php
									if($userHashArray != ""){
								?>, 
								{
								name: 'Your Average',
								data: [<?php echo $userHashArray?>]
								}
								<?php
									}
								?>]
						});
					});
				</script>
				<div id="graph" align="center">
					<img src="/images/placeholder.jpg" alt="placeholder">
				</div><br/><br/>

				<table align="center" cellpadding="5" cellspacing="5">
					<tbody>
						<tr>
							<td class="boxleft">
								<h1 class="headerbox">Title 1</h1>
								<div class="boxtext" align="center">Lorem ipsum dolor sit amet, 
								consectetur adipiscing elit. Proin tempor dictum velit, eget ullamcorper
								 nunc sodales auctor. Sed tempor consequat sapien eget consequat. 
								Suspendisse iaculis 
								</div>
							</td>
							<td class="boxleft">
								<h1 class="headerbox">Title 2</h1>
								<div class="boxtext" align="center">Lorem ipsum dolor sit amet, 
								consectetur adipiscing elit. Proin tempor dictum velit, eget ullamcorper
								 nunc sodales auctor. Sed tempor consequat sapien eget consequat. 
								Suspendisse iaculis 
								</div>
							</td>
							<td class="boxleft">
								<h1 class="headerbox">Title 3</h1>
								<div class="boxtext" align="center">Lorem ipsum dolor sit amet, 
								consectetur adipiscing elit. Proin tempor dictum velit, eget ullamcorper
								 nunc sodales auctor. Sed tempor consequat sapien eget consequat. 
								Suspendisse iaculis 
								</div>
							</td>
						</tr>
					</tbody>
				</table>


				<div class="text">
					<h1 class="header">We Mine Coins!</h1>
					Welcome to the <b>Mining farm</b>, if you've stumbled across here by accident, You are in for a treat. You can use your computer to help the community mine an Internet commodity known as Bitcoins. You can buy all sorts of stuff with bitcoins like Amazon giftcards, web servers, MMORPG game, or even trade it for cash!
					<br/>
					<br/>
					<h3>Okay, So how do I get BitCoins?</h3>
					Bitcoins are obtained by a term known as <i>Mining</i>, which is just an easier way to say <i><b>Hashing transactions across the network with Cryptographic algorithims</i></b>. Mining involves your computer to run a program to encrypt transactions with either an on-board processor or your Video Card(Recommended). When there are enough transactions encrypted you obtain a virtual object called a <i>Block</i> which will then be sent out to the network for verification. After a Mining Pool has found a <i>block</i> they will split up the reward according to how many transactions your CPU or GPU(Video Card) executed.
					<br/><br/>
					<h3>And I use them, how?</h3>
					You can use Bitcoins by downloading a Bitcoin wallet for free over at <a href="http://bitcoin.org">www.BitCoin.org</a>. After you've obtained a free Bitcoin wallet you can login to your account here and type in one of your many assigned <i>wallet address</i> to have the payment sent to. Upon payment you are free do to what you want with your Bitcoins. Here is a rough list of websites that accept Bitcoins as payment. <a href="https://en.bitcoin.it/wiki/Trade" target="_BLANK">Sites that accept bitcoins</a>
				</div>
				<br><br>
			</div>
			<?php
			//Include Footer
			////////////////////
			include($footer);
			?>
		</div>
		<br/><Br/>

	</body>
</html>
=======
<?php

// Load Linkage Variables //
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Include hashing functions
	include($functions);


	
//Set user details for userInfo box
	$rawCookie		= "";
	if(isSet($_COOKIE[$cookieName])){
		$rawCookie	= $_COOKIE[$cookieName];
	}
	$getCredientials	= new getCredientials;
	$loginValid	= $getCredientials->checkLogin($rawCookie);
?>
<html>
	<head>
		<title><?php echo outputPageTitle();?> - <?php echo gettext("Main Page");?> </title>
		<!--This is the main style sheet-->
		<link rel="stylesheet" href="/css/mainstyle.css" type="text/css" />
		<link rel="shortcut icon" href="/images/favicon.png" />
		<?php
			//If user isn't logged in load the login.js
			if(!$loginValid){
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
				<div id="blogContainer">
				<?php

					//Ouput the login or the users stats depending on weather or not they are logged in
					include($userInfoBox); 
					/////////////////////////////////////
				?>
					<div class="blogPost">
					<?php
						//Include a blog editor when an admin is logged in
						if($getCredientials->isAdmin == 1){
							//Check if a blog needs to be added
								if($_POST["act"] == "addBlog"){
									//Add blog to database
										//MySql Injection Prevention
											$timestamp = time();
											$title = mysql_real_escape_string($_POST["title"]);
											$message = mysql_real_escape_string($_POST["message"]);
											mysql_query("INSERT INTO `blogPosts` (`timestamp`, `title`, `message`) VALUES('".$timestamp."', '".$title."', '".$message."')");
								}
							//Check if a blog needs to be deleted
								if($_POST["act"] == "Delete Post"){
									//Delete blog
										//MySql injection prevention
											$postId = mysql_real_escape_string($_POST["postId"]);

										//Delete
											mysql_query("DELETE FROM `blogPosts` WHERE `id` = '".$postId."' LIMIT 1");
								}

							//Check if a blog needs to be edited
								if($_POST["act"] == "Edit Post"){
									//Edit Post
										//Get post information
											//Mysql injection preventions
												$postId = mysql_real_escape_string($_POST["postId"]);

											//Post information
												$postInfoQ = mysql_query("SELECT `title`, `message`, `timestamp` FROM `blogPosts` WHERE `id` = '$postId' LIMIT 0,1");
			
												$postInfo = mysql_fetch_object($postInfoQ);
								}

							//Check if a blog needs to be updated){
								if($_POST["act"] == "updateBlog"){
									//Update post
										//update information
											//Mysql injection prevention
												$title = mysql_real_escape_string($_POST["title"]);
												$message = mysql_real_escape_string($_POST["message"]);
												$postId = mysql_real_escape_string($_POST["postId"]);

											//Update
											mysql_query("UPDATE `blogPosts` SET `title` = '$title', `message` = '$message' WHERE `id` = '$postId' LIMIT 1");
									//Make the following form clean
										$_POST["act"] = "";
								}
						?>
						<form action="/index.php" method="post">
						<input type="hidden" name="act" value="<?php if($_POST["act"] == "Edit Post"){ echo "updateBlog";}else if ($_POST["act"] == "editBlog"){ echo "addBlog"; }?>">
						<input type="hidden" name="postId" value="<?php echo $_POST["postId"]; ?>"/>
						<?php echo gettext("Type in a new Blog entry");?><br/>
						<input type="text" size="20" name="title" value="<?php if($_POST["act"] == "Edit Post"){ echo $postInfo->title; }else if($_POST["act"] != "editBlog"){ echo gettext("Blog Title"); }?>"/> | <?php echo date("M,d Y g:ja", time());?><br/>
						<textarea name="message" rows="13" cols="90"><?php if($_POST["act"] == "Edit Post"){ echo $postInfo->message; }else if($_POST["act"] != "editBlog"){ echo gettext("Blog content here"); }?></textarea><br/>
						<input type="submit" value="<?php echo gettext("Add Blog Entry");?>"/>
						</form>
						<?php
						}
						//End blog editor
					?>
					</div>
					<?php 
					//Output blog posts from the database
					blogPosts($getCredientials->isAdmin); 
					/////////////////////////////////////
					?>
				</div><br/>
	
				<?php
					//Output Footer
					include($footer);
					///////////////
				?>
			</div>
		</div>
	</body>
</html>
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
