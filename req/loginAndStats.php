<?php
	if($loginValid != 1){
		//No valid cookie show login//
?>
<!--Login Input Field-->
<div id="loginBox">
	<form action="/login.php" method="post" id="loginForm">
		<?php echo gettext("Check account status");?>:
		<input type="text" name="username" value="username" id="userForm" onMouseDown="clearUsername();">
		<input type="password" name="password" value="password" id="passForm" onMouseDown="clearPassword();">
		<input type="submit" value="<?php echo gettext("Check Account");?>">
	</form><br/>
	<form action="/forgotpassword.php" method="post" id="lostPassForm">
		<input type="submit" name="act" value="<?php echo gettext("Lost Password");?>">
	</form>
	<form action="/register.php" method="post" id="register">
		<input type="submit" name="act" value="<?php echo gettext("Register");?>">
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
			echo gettext("Welcome Back")." <i><b>".$getCredientials->username."</b></i>, <a href='/logout.php'>".gettext("Logout")."</a><br/><hr size='1' width='100%' /><br/>";
			echo gettext("Valid").": <b><i>".$getCredientials->totalShares."</i> ".gettext("shares")."</b><br/>";
			echo gettext("Pool").": <b><i>".$getCredientials->totalPoolShares."</i> ".gettext("shares")."</b><br/>";
			echo gettext("Est. Earnings").": <b><i>".$getCredientials->estimatedReward."</i> ".gettext("BTC")."</b>";
			echo "<hr size='1' width='100%'>";
		?>
		<div id="quickStats">
		<?php
			echo gettext("Pending Balance").":<b><i>".$getCredientials->pendingBalance." </i>".gettext("BTC")."</b><br/>";
			echo gettext("Balance").": <b><i>".$getCredientials->accountBalance." </i>".gettext("BTC")."</b><br/>";
		
			//Pool stats
		?>
		</div>
	</span>
</div>
<?php
	}
?>