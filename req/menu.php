<div id="menuBar">
		<div class="menuBtn">
			<a href="/stats.php" class="menu"><?php echo gettext("Statistics");?></a>
		</div>
<?php
//Display the following only if $cookieValid
if($loginValid){
?>
	
		<div class="menuBtn">
			<a href="/accountDetails.php" class="menu"><?php echo gettext("Account Details");?></a>
		</div>
		

<?php
		//If this user is an admin show the adminPanel.php link
		if($getCredientials->isAdmin){
?>
		<div class="menuBtn">
			<a href="/adminPanel.php" class="menu">(<?php echo gettext("Admin Panel");?>)</a>
		</div>
		<div class="menuBtn">
			<a href="/adminPanel.php?show=editUsers" class="menu">(<?php echo gettext("Edit Users");?>)</a>
		</div>
<?php	
		}
}
?>
</div>