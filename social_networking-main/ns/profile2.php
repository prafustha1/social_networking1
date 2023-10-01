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

  	if($_FILES['file']['type'] == "image/jpeg")
  	{

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
		}else{
		  	echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
		      echo "<br>The following errors occured <br><br>";
		     echo "Only images of Jpeg type are allowed!";
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
	<title>profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="mainpage.css?v=<?php echo time(); ?>">
	
	<?php
	include("header.php");
	?>

  <link rel="stylesheet" type="text/css" href="profile.css?v=<?php echo time(); ?>">
</head>
<body bgcolor="#F5F6F9">
	<div class="body">

		<div id="header"></div>

			
			<div class="slide">
				<?php

					$image = "cover_image.png";
					if(file_exists($user_data['cover_image']))
					{
						$image = $image_class->get_thumb_cover($user_data['cover_image']);
					}

					?>
				<img src="<?php echo $image ?>">
			</div>
			<div id="circle">
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
				<span style="font-size: 12px;">
					<img src="<?php echo $image ?>">
					<a style="text-decoration: none; color: #f0f; float: right; margin-top: -45px; margin-right: -70px;" href="change_profile_image.php?change=profile">Change Profile Image</a><span style="color: #f0f; float: right; margin-top: -45px; margin-right: -75px;">|</span>
					<a style="text-decoration: none; color: #f0f; float: right; margin-top: -45px; margin-right: -190px;" href="change_profile_image.php?change=cover">Change Cover Image</a>
				</span>
			</div>

			<div id="name">
				<a href="profile.php?id=<?php echo $user_data['userid']; ?>"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></a><br>
				<form>
					<?php
						$myfollows = "";
						if($user_data['follows'] > 0)
						{
							$myfollows = "(" . $user_data['follows'] . " Followers)";
						}
						
						if($user_data['userid'] == $_SESSION['socialnet_userid']){

								$totalfollows = "(" . $user_data['follows'] . ")";
								echo "<span style= 'font-size: 14px; color: purple;'>Followers$totalfollows</span>";
							
						}else{
							echo "<a href='follow.php?type=user&id=$user_data[userid]'><input type='button' name='follow' value='Follow $myfollows' id='follow'></a>";
						}

					?>
				</form>
			<span style="font-size: 14px; color: #ccc;">@<?php echo $user_data['url_address']; ?></span><br>
			<br>
			<a href="profile.php?section=default&id=<?php echo $user_data['userid']; ?>"><span style="font-size: 12px;">Timeline</span></a> . 
			<a href="profile.php?section=photos&id=<?php echo $user_data['userid']; ?>"><span style="font-size: 12px;">Photos</span></a> . 
			<a href="profile.php?section=following&id=<?php echo $user_data['userid']; ?>"><span style="font-size: 12px;">Following</span></a> . 
			<a href="profile.php?section=followers&id=<?php echo $user_data['userid']; ?>"><span style="font-size: 12px;">Followers</span></a>
			
				
			</div>

			<!--below cover area-->

			<?php

				$section = "default";
				if(isset($_GET['section']))
				{
					$section = $_GET['section'];
				}

				if($section == "default")
				{
					include("profile_content_default.php");

				}elseif($section == "photos")
				{
					include("profile_content_photos.php");

				}elseif($section == "followers")
				{
					include("profile_content_followers.php");
				}elseif($section == "following")
				{
					include("profile_content_following.php");
				}

			?>

		</div>

			
			
			

</body>
</html>
