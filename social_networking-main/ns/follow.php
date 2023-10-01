<?php

	include("classes/autoload.php");

	$signin = new Signin();
	$user_data = $signin->check_signin($_SESSION['socialnet_userid']);

if(isset($_SERVER['HTTP_REFERER']))
{
	$return_to = $_SERVER['HTTP_REFERER'];
}else{
	$return_to = "profile.php";
}
	
	if(isset($_GET['type']) && isset($_GET['id']))
	{

		if(is_numeric($_GET['id']))
		{
			$allowed[] = 'post';
			$allowed[] = 'user';

			if(in_array($_GET['type'], $allowed)) 
			{
				$post = new Post();
				$user_class = new User();
				$post->follow_friend($_GET['id'],$_GET['type'],$_SESSION['socialnet_userid']);

				if($_GET['type'] == "user"){
					$user_class->follow_user($_GET['id'],$_GET['type'],$_SESSION['socialnet_userid']);
				}

			}
		
		}
	}
		
header("Location: ". $return_to);
die;