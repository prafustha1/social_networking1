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
  					header("Location: mainpage.php");
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
  $id = $_SESSION['socialnet_userid'];
  $posts = $post->get_post($id);

?>


<!DOCTYPE html>
<html>
<head>
	<title>mainpage</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="mainpage.css?v=<?php echo time(); ?>">
	
	<?php
	include("header.php");
	?>
</head>

	<body bgcolor="#F5F6F9">
			<div id="header"></div>

			<!--main newsfeed-->
			<div style="display: flex; justify-content: space-around;">

				<!--leftbar-->
				<div style="height: 92vh; flex: 1 1; border: 1px solid #a6a6a6; background-color: white; margin-top: 100px; position: sticky; top: 50px; justify-content: flex-start;">
					<div class="leftbar" style="height: 100%; width: 100%; ">
					<div id="two1">
					</div>
					<div id="two2">
						<?php

						$image_class = new Image();
						$image = "images/user_male.jpg";
						if($user_data['gender'] == "Female")
						{
							$image = "images/user_female.jpg";
						}else if(file_exists($user_data['profile_image']))
						{
							$image = $image_class->get_thumb_profile($user_data['profile_image']);
						}

					?>
						<img src="<?php echo $image ?>">
					</div>
					<div id="box1">
						<a href="profile.php"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></a><br>
						<span style="font-size: 14px; color: #ccc;">@<?php echo $user_data['url_address']; ?></span>
						<br><br>
						<hr id="hr1">
					</div>
				</div>
				</div>

				<!--main post area-->

				<div style="min-height: auto; flex: 3 3; padding: 40px; margin-top: 60px;">
					<div class="post_upborder"></div>
				
					<div style="border: solid thin #a6a6a6; padding: 10px; background-color: white; ">

						<form method="post" enctype="multipart/form-data">
							<?php

							$image = "images/user_male.jpg";
							if($user_data['gender'] == "Female")
							{
								$image = "images/user_female.jpg";
							}else if(file_exists($user_data['profile_image']))
							{
								$image = $user_data['profile_image'];
							}

							?>
							<img id="user_img" src="<?php echo $image ?>">
							<textarea name="post" placeholder="What's on your mind?" style="resize: none;"></textarea>
							<input type="file" name="file">
							<input type="submit" id="post_button" name="" value="Post"><br>
						</form>
					</div>

					<!--posts-->
					<div id="post_bar" >

						<?php

							$DB = new Database();
							$user_class = new User();
							$image_class = new Image();

							$followers = $user_class->get_following($_SESSION['socialnet_userid'], "user");

							$follower_ids = false;
							if(is_array($followers))
							{
								$follower_ids = array_column($followers, "userid");
								$follower_ids = implode("','", $follower_ids);
							}

							if($follower_ids){
								$myuserid = $_SESSION['socialnet_userid'];
								$sql = "select * from posts where userid = '$myuserid' || userid in('" .$follower_ids. "') order by id desc limit 30";
								$posts = $DB->read($sql);
							}
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

				<!--rightbar-->
				<div style="height: 92vh; flex: 1 1; border: 1px solid #a6a6a6; margin-top: 100px; position: sticky; top: 50px; justify-content: flex-start;">
					<div style="width: 100%; height: 100%; background-color: white;">
						
					</div>
				</div>
			</div>


</body>
</div>
</html>