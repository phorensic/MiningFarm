<?php
	if($loginValid != 1){
		//No valid cookie show login//
?>
<!--Login Input Field-->
<div id="loginBox">
	<form action="/login.php" method="post" id="loginForm">
		Check account status:
		<input type="text" name="username" value="username" id="userForm" onMouseDown="clearUsername();">
		<input type="password" name="password" value="password" id="passForm" onMouseDown="clearPassword();">
		<input type="submit" value="Check Account">
	</form><br/>
	<form action="/forgotpassword.php" method="post" id="lostPassForm">
		<input type="submit" name="act" value="Lost Password">
	</form>
	<form action="/register.php" method="post" id="register">
		<input type="submit" name="act" value="Register">
	</form>
</div>
<?php
	}else if($loginValid == 1){
		//Valid cookie YES! Show this user stats//
?>
<div id="userInfo">
	<span>
		<?php
			$getCredientials->getStats();
			echo "Welcome Back <i><b>".$getCredientials->username."</b></i>, <a href='/logout.php'>Logout</a><br/><hr size='1' width='100%' /><br/>";
			echo "Valid: <b><i>".$getCredientials->totalShares."</i> shares</b><br/>";
			echo "Total Pool: <b><i>".$getCredientials->totalPoolShares."</i> shares</b><br/>";
			echo "Est. Earnings: <b><i>".$getCredientials->estimatedReward."</i> BTC</b>";
			echo "<hr size='1' width='100%'>";
		?>
		<div id="quickStats">
		<?php
			echo "Balance: <b><i>".$getCredientials->accountBalance." </i>BTC</b><br/>";
		
			//Pool stats
		?>
		</div>
	</span>
</div>
<?php
	}
?>