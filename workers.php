<?php
// Load Linkage Variables //
	$dir = dirname(__FILE__);
	$req 		= $dir."/req/";
	$functions	= $req."functions.php";

//Load Functions
	include($functions);

//Include bitcoind functions
	include($bitcoind);

//Perform login
	$getCredientials	= new getCredientials;
<<<<<<< HEAD
	$loginValid		= $getCredientials->checkLogin($_COOKIE[$cookieName]);
if($loginValid){
=======
	$loginSuccess		= $getCredientials->checkLogin($_COOKIE[$cookieName]);

if($loginSuccess){
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

	//Connect to db
		connectToDb();
	
	//Get user information
		$getCredientials->getStats();
		
	//Figure out which action the user is trying to do
		$act = $_POST["act"];
		if($act == "Add Worker"){
				

			//Mysql Injection Protection
				$usernameWorker = $_POST["username"];
				$passwordWorker = $_POST["password"];

			//add workers
				$insertQ = mysql_query("INSERT INTO `pool_worker` (`associatedUserId`, `username`, `password`)
								VALUES('".$getCredientials->userId."', '".$getCredientials->username.".".$usernameWorker."', '".$passwordWorker."')");
				
				$insertWorked = mysql_affected_rows();
				if($insertWorked == 0){
						$returnError = gettext("You already have a worker named that");
				}
		}

		if($act == "Update Worker"){
			
			//Mysql Injection Protection
				$usernameWorker = mysql_real_escape_string($_POST["username"]);
				$passwordWorker = mysql_real_escape_string($_POST["password"]);
				$workerId	= mysql_real_escape_string($_POST["workerId"]);

				$usernameWorker = $getCredientials->username.".".$usernameWorker;

			//update worker
				mysql_query("UPDATE `pool_worker` SET `username` = '".$usernameWorker."', `password` = '".$passwordWorker."' WHERE `id` = '".$workerId."' AND `associatedUserId` = '".$getCredientials->userId."'")or die(mysql_error());
		}

		if($act == "Delete Worker"){

			//Mysql Injection Protection
				$workerId = mysql_real_escape_string($_POST["workerId"]);

			//Delete worker OH NOES!
				mysql_query("DELETE FROM `pool_worker` WHERE `id` = '".$workerId."' AND `associatedUserId` = '".$getCredientials->userId."'");
		}
?>
<<<<<<< HEAD
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
			<div id="mainbox"><br/><br/>
				<table align="center" cellpadding="0" cellspacing="0" class="bigContent">
					<tbody>
						<tr>
							<td class="contTL">
							&nbsp;
							</td>
							<td class="contTC">
								<?php echo gettext("Add a worker");?>
							</td>
							<td class="contTR">
							&nbsp;
							</td>
						</tr>
						<tr>
							<td colspan="3" class="contContent">
								<span class="workersMessages"><?php echo $returnError;?></span>
								<form action="workers.php" method="post">
								<input type="text" name="username" value="username"> &middot; <input type="text" name="password" value="password"><input type="submit" name="act" value="Add Worker"><br/>
								</form><br/>
							</td>
						</td>
					</tbody>
				</table><br/><br/>
				<table align="center" cellpadding="0" cellspacing="0" class="bigContent">
					<tbody>
						<tr>
							<td class="contTL">
							&nbsp;
							</td>
							<td class="contTC">
								<?php echo gettext("Manage Workers");?>
							</td>
							<td class="contTR">
							&nbsp;
							</td>
						</tr>
						<tr>
							<td colspan="3" class="contContent">
								<?php
								//Get and show list of workers along with a <form> to add more workers
									//Get time 5 minutes ago
										$timeFiveMinutesAgo = time();
										$timeFiveMinutesAgo -= 60*5;
										
									$listWorkersQ = mysql_query("SELECT `id`, `username`, `password` FROM `pool_worker` WHERE `associatedUserId` = '".$getCredientials->userId."' ORDER BY `id` DESC")or die(mysql_error());

									while($worker = mysql_fetch_array($listWorkersQ)){
										//Get this workers recent average Mhashes (If any recently)
											$getMhashes = mysql_query("SELECT `mhashes` FROM `stats_userMHashHistory` WHERE `username` = '".$worker["username"]."' AND `timestamp` >= '$timeFiveMinutesAgo' ORDER BY `timestamp` DESC");
											$numHashes = mysql_num_rows($getMhashes);
											$totalMhashes = 0;
											while($mhashes = mysql_fetch_array($getMhashes)){
												$totalMhashes += $mhashes["mhashes"];
											}
											
											//Prevent division by zero
												if($totalMhashes > 0 && $totalMhashes > 0){
													$averageHashes = $totalMhashes/$numHashes;
												}else if($totalMhashes == 0 || $totalMhashes == 0){
													$averageHashes = "<span class=\"notConnected\">".gettext("Not connected")."</span>";
												}
												
												$averageHashes = round($averageHashes, 2);
										
											//Get this workers efficency (if working)
												$eff = "N/A";
												if($averageHashes > 0){
													$totalShares = mysql_query("SELECT `id` FROM `shares` WHERE `username` = '".$worker["username"]."'");
													$totalShares = mysql_num_rows($totalShares);
													
													$totalValidShares = mysql_query("SELECT `id` FROM `shares` WHERE `username` = '".$worker["username"]."' AND `our_result` = 'Y'");
													$totalValidShares = mysql_num_rows($totalValidShares);
													$eff = 100;
													if($totalShares > 0 && $totalValidShares > 0){
														$eff = round(($totalValidShares/$totalShares)*100, 2);
													}
												}
										//Split username for user input
											$splitUser = explode(".", $worker["username"]);
									?>
									<form action="workers.php" method="post">
										<input type="hidden" name="workerId" value="<?=$worker["id"]?>">
										<?php echo $splitUser[0]; ?>.<input type="text" name="username" value="<?php echo $splitUser[1]; ?>" size="10"> <input type="text" name="password" value="<?php echo $worker["password"];?>" size="10"><input type="submit" name="act" value="<?php echo gettext("Update");?>"><input type="submit" name="act" value="<?php echo gettext("Delete");?>"/><br/>
										<span class="workerMhash"><?php echo $averageHashes; ?> MHash/s</span> &middot; <span class="efficiency"><?php echo $eff;?>% efficient</span>
										</form><br/><Br/>
									<hr size="1" width="100%"/>
									<?php
									}

									?>
							</td>
						</td>
					</tbody>
				</table><br/><br/>
								
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
<?php
}else{
	header("Location: /");
}
?>
=======
<html>
	<head>
		<title>Why are you on this page?</title>
		<!--This is the main style sheet-->
		<link rel="stylesheet" href="/css/mainstyle.css" type="text/css" /> 
		<style type="text/css">
			body{
				background-color:transparent;
				background-image:url();
			}
		</style>
	</head>
	<body>
		<span class="workersMessages"><?php echo $returnError;?></span>
		<form action="workers.php" method="post">
		<input type="text" name="username" value="username"> &middot; <input type="text" name="password" value="password"><input type="submit" name="act" value="Add Worker"><br/>
		</form><br/>
		<hr size="1" width="100%">
		</form>
		<?php
			//Get and show list of workers along with a <form> to add more workers
				//Get time 5 minutes ago
					$timeFiveMinutesAgo = time();
					$timeFiveMinutesAgo -= 60*5;
					
				$listWorkersQ = mysql_query("SELECT `id`, `username`, `password` FROM `pool_worker` WHERE `associatedUserId` = '".$getCredientials->userId."' ORDER BY `id` DESC")or die(mysql_error());

				while($worker = mysql_fetch_array($listWorkersQ)){
					//Get this workers recent average Mhashes (If any recently)
						$getMhashes = mysql_query("SELECT `mhashes` FROM `stats_userMHashHistory` WHERE `username` = '".$worker["username"]."' AND `timestamp` >= '$timeFiveMinutesAgo' ORDER BY `timestamp` DESC");
						$numHashes = mysql_num_rows($getMhashes);
						$totalMhashes = 0;
						while($mhashes = mysql_fetch_array($getMhashes)){
							$totalMhashes += $mhashes["mhashes"];
						}
						
						//Prevent division by zero
							if($totalMhashes > 0 && $totalMhashes > 0){
								$averageHashes = $totalMhashes/$numHashes;
							}else if($totalMhashes == 0 || $totalMhashes == 0){
								$averageHashes = "<span class=\"notConnected\">".gettext("Not connected")."</span>";
							}
							
					//Split username for user input
						$splitUser = explode(".", $worker["username"]);
		?>
		<form action="workers.php" method="post">
			<input type="hidden" name="workerId" value="<?=$worker["id"]?>">
			<?php echo $splitUser[0]; ?>.<input type="text" name="username" value="<?php echo $splitUser[1]; ?>" size="10"> <input type="text" name="password" value="<?php echo $worker["password"];?>" size="10"><input type="submit" name="act" value="<?php echo gettext("Update");?>"><input type="submit" name="act" value="<?php echo gettext("Delete");?>"/><br/>
			<span class="workerMhash"><?php echo $averageHashes; ?> MHash/s</span>
		</form>
		<hr size="1" width="100%"><br/>
		<?php
				}
		}

		?>
	</body>
</html>
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
