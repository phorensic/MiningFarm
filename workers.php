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
	$loginSuccess		= $getCredientials->checkLogin($_COOKIE[$cookieName]);

if($loginSuccess){
	//Connect to db
		connectToDb();

	//Figure out which action the user is trying to do
		$act = $_POST["act"];
		if($act == "Add Worker"){
				$getCredientials->getStats();

			//Mysql Injection Protection
				$usernameWorker = $_POST["username"];
				$passwordWorker = $_POST["password"];

			//add workers
				mysql_query("INSERT INTO `pool_worker` (`associatedUserId`, `username`, `password`)
								VALUES('".$getCredientials->userId."', '".$getCredientials->username.".".$usernameWorker."', '".$passwordWorker."')");
		}

		if($act == "Update Worker"){
				$getCredientials->getStats();
			
			//Mysql Injection Protection
				$usernameWorker = mysql_real_escape_string($_POST["username"]);
				$passwordWorker = mysql_real_escape_string($_POST["password"]);
				$workerId	= mysql_real_escape_string($_POST["workerId"]);

				$usernameWorker = $getCredientials->username.".".$usernameWorker;
			//update worker
				mysql_query("UPDATE `pool_worker` SET `username` = '".$usernameWorker."', `password` = '".$passwordWorker."' WHERE `id` = '".$workerId."' AND `associatedUserId` = '".$getCredientials->userId."'")or die(mysql_error());
		}

		if($act == "Delete Worker"){
				$getCredientials->getStats();

			//Mysql Injection Protection
				$workerId = mysql_real_escape_string($_POST["workerId"]);

			//Delete worker OH NOES!
				mysql_query("DELETE FROM `pool_worker` WHERE `id` = '".$workerId."' AND `associatedUserId` = '".$getCredientials->userId."'");
		}
?>
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
		<form action="workers.php" method="post">
		<input type="text" name="username" value="username"> &middot; <input type="text" name="password" value="password"><input type="submit" name="act" value="Add Worker"><br/>
		</form><br/>
		<hr size="1" width="100%">
		</form>
		<?php
			//Get and show list of workers along with a <form> to add more workers
				$listWorkersQ = mysql_query("SELECT `id`, `username`, `password` FROM `pool_worker` WHERE `associatedUserId` = '".$getCredientials->userId."' ORDER BY `id` DESC")or die(mysql_error());
				while($worker = mysql_fetch_array($listWorkersQ)){
					$splitUser = explode(".", $worker["username"]);
		?>
		<form action="workers.php" method="post">
			<input type="hidden" name="workerId" value="<?=$worker["id"]?>">
			<?php echo $splitUser[0]; ?>.<input type="text" name="username" value="<?php echo $splitUser[1]; ?>" size="10"> <input type="text" name="password" value="<?php echo $worker["password"];?>" size="10"><input type="submit" name="act" value="Update Worker"><input type="submit" name="act" value="Delete Worker"/>
			800Mhash/s
		</form>
		<hr size="1" width="100%"><br/>
		<?php
				}
		}

		?>
	</body>
</html>