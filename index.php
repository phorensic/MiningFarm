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
