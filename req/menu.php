<div id="menuBar">
		<div class="menuBtn">
			<a href="/stats.php" class="menu">Statistics</a>
		</div>
<?php
//Display the following only if $cookieValid
if($loginSuccess){
?>
	
		<div class="menuBtn">
			<a href="/accountDetails.php" class="menu">Account Details</a>
		</div>
		

<?php
		//If this user is an admin show the adminPanel.php link
		if($getCredientials->isAdmin){
?>
		<div class="menuBtn">
			<a href="/adminPanel.php" class="menu">(Admin Panel)</a>
		</div>
<?php	
		}
}
?>
</div>