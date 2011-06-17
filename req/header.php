<!--Javascript Area that will be included in all pages-->
	<!--Login Dissapear Script-->
	<script src="/js/login.js"></script>

<!--/////////////////////////////////////////////////-->

<!--High Charts Javascript area-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript"></script>
<script src="/js/highcharts/highcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/highcharts/themes/greenlikemoney.js"></script>
<!--///////////////////////////-->
<div id="headerbox">	
	<a id="logo" href="/index.php" title="Mining Farm"></a>
	<div id="headerTitle">
		<h1 id="h1Title">
			<a href="/"><?php echo outputHeaderTitle();?></a>
		</h1>
		<span class="slogan" id="slogan"><?php echo outputHeaderSlogan();?></span>
	</div>
<?php
//If a valid login show balance if not logged in show login/register interface
if(!$loginValid){
?>
	<div class="login" align="right">
		<form method="POST" action="/login.php">
			<input name="username" value="username" id="userForm" onMouseDown="clearUsername();" size="15" type="text"><br>
			<input type="password" name="password" value="password" id="passForm" onMouseDown="clearPassword();" size="15">
			<br>
			<input src="/images/register.gif" value="Regsiter" type="image" class="regsiterBtn"> &nbsp; <input src="/images/login.gif" value="Login" type="image">

		</form>
	</div>
</div>
<?php
}else if($loginValid){
?>
	<div class="userInfo" align="right">
			<?php $getCredientials->getStats();?>
			<span class="userText">Estimated: <span class="estimated"><?php	echo $getCredientials->estimatedReward;	?></span></span><br/>
			<span class="userText">Unconfirmed: <span class="unconfirmed"><?php echo $getCredientials->pendingBalance;?></span></span><br/>
			<span class="userText">Total Balance: <span class="confirmedBalance"><?php echo $getCredientials->accountBalance;?></span></span><br/>
			<a href="/logout.php">Logout</a>
	</div>
</div>
<?php
}
?>
<div id="nav">
	<ul id="list-nav">
		<li><a href="/stats.php"><?php echo gettext("Statistics");?></a></li>
<?php
		if($loginValid){
?>
		<li><a href="/accountDetails.php"><?php echo gettext("Account Details");?></a></li>
		<li><a href="/workers.php"><?php echo gettext("Manage Workers");?></a></li>
<?php
		}
		if($getCredientials->isAdmin){
?>
		<li><a href="/adminPanel.php"><?php echo gettext("(Administration)");?></a></li>
		<li><a href="/adminPanel.php?show=editUsers"><?php echo gettext("(User Management)");?></a></li>
<?php
		}
?>
	</ul>
</div>