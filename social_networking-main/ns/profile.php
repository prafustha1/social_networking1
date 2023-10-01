<?php

	include("classes/autoload.php");

	$signin = new Signin();
	$user_data = $signin->check_signin($_SESSION['socialnet_userid']);

	$USER = $user_data;

	if(isset($_GET['id']) && is_numeric($_GET['id']))
	{
		$profile = new Profile();
		$profile_data = $profile->get_profile($_GET['id']);

		if(is_array($profile_data)){
			$user_data = $profile_data[0];
		}
	}


  //posting starts here

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
  	$post = new Post();
  	$id = $_SESSION['socialnet_userid'];


  			$allowed_size = (1024 * 1024) * 3;
  			if($_FILES['file']['size'] < $allowed_size)
  			{
  				$result = $post->create_post($id, $_POST, $_FILES);
			
				if($result == "")
  				{
  					header("Location: profile.php");
  					die;
  				}else
  				{
			  		echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
			      	echo "<br>The following errors occured <br><br>";
			     	echo $result;
			     	echo "</div>";
			  	}
		  	}else{
		  			echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
		      		echo "<br>The following errors occured <br><br>";
		     		echo "Only images of size 3Mb or lower are allowed!";
		     		echo "</div>";
		  		}

  	}


  //collect posts
	$post = new Post();
  $id = $user_data['userid'];
  $posts = $post->get_post($id);

  //collect friends
  $user = new USER();

  $friends = $user->get_friends($id);

  $image_class = new Image();

?>





<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="profile.css?v=<?php echo time(); ?>">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body style="overflow: auto;">
	<div class="div1">
		<div class="dropdown">
    <button class="dropbtn">SETTINGS
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="password.php">Password</a>
      <a href="logout.php">Logout</a>
      <a href="#">Link 3</a>
    </div>
  </div> 
  <a href="home.php"> <i class="fa fa-home" id="home"></i></a>
		<div class="search-container">
			<form method="get" action="search.php">
				<input type="text" name="find" placeholder="search..." id="search">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>

	</div>

	<div class="div2">
		<div class="chatbox">
			<div id="friends_bar">
					Suggestions<br>

					<?php

					if($friends)
					{
						foreach ($friends as $FRIEND_ROW) {
							# code...

							include("user.php");
						}
					}

				?>

				</div>
		</div>

		<div class="menu">
			<a href="profile_content_following.php"><div class="followers">Followers</div></a>
			<a href="#"><div class="followings">Following</div></a>
			<div class="posts">
				<form method="post" enctype="multipart/form-data">
					<!--<?php

						$image = "images/user_male.jpg";
						if($user_data['gender'] == "Female")
						{
							$image = "images/user_female.jpg";
						}else if(file_exists($user_data['profile_image']))
						{
							$image = $user_data['profile_image'];
						}

						?>
						<img id="user_img" src="<?php echo $image ?>" style= "width: 45px; height: 45px; border-radius: 4px;">-->
						<textarea name="post" placeholder="What's on your mind?" style="resize: none; max-width: 100vh; max-height: 100vh; min-width: 98%; min-height: 45px; border-radius: 10px;"></textarea>
						<input type="file" name="file">
						<input type="submit" id="post_button" name="" value="Post" style="width: 100%; height: 30px;"><br>
				</form>
			</div>
		</div>

		<div class="main">
			<div class="main1">

				<?php

						$image = "images/user_male.jpg";
						if($user_data['gender'] == "Female")
						{
							$image = "images/user_female.jpg";
						}else if(file_exists($user_data['profile_image']))
						{
							$image = $image_class->get_thumb_profile($user_data['profile_image']);
						}

					?>
				<div class="photo"><img src="<?php echo $image ?>" style="width: 50px; height: 50px;"></div>
				<span><a href="profile.php"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></span></a><br>
				<a href="change_profile_image.php?change=profile" style="font-size: 12px;">change profile picture</a> | <a href="change_profile_image.php?change=cover" style="font-size: 12px;">change cover picture</a>
				<p>usko thought of the day, or uslai j halna maan lagyo tyo text.</p>
			</div>

			<div class="main2">
				<?php
					
							$myfollows = $user_data['follows'];
					
				?>
				<div class="follower"><?php  echo "$myfollows followers"; ?></div>
				<div class="following">
				
				</div>
				<div class="post">0 posts</div>
				<form>
					<?php
						$myfollows = "";
						if($user_data['follows'] > 0)
						{
							$myfollows = "(Followed)";
						}
						
						if($user_data['userid'] == $_SESSION['socialnet_userid']){

								$totalfollows = "(" . $user_data['follows'] . ")";
								
							
						}else{
							echo "<a href='follow.php?type=user&id=$user_data[userid]'><input type='button' name='follow' value='Follow $myfollows' id='follow'></a>";
						}
					?>
					
				</form>
			</div>

			<div class="main3">
				<!--posts-->
					<div id="post_bar" >

						<?php

					if($posts)
					{
						foreach ($posts as $ROW) {
							# code...
							$user = new User();
							$ROW_USER = $user->get_user($ROW['userid']);

							include("post.php");
						}
					}
						
				?>				
					
					</div>
				</div>
			</div>			
		</div>
	</div>
</body>
</html>