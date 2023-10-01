<?php

include("classes/autoload.php");

	$signin = new Signin();
	$user_data = $signin->check_signin($_SESSION['socialnet_userid']);

if(isset($_SERVER['HTTP_REFFERER'])){
	$return_to = $_SERVER['HTTP_REFFERER'];
} else{
	$return_to = "profile.php";
}
	if(isset($_GET['type']) && isset($_GET['id'])){

		if(is_numeric($_GET['id'])){
			 $allowed[] = 'post';
			 $allowed[] = 'profile';
			 $allowed[] = 'comment';

			 if(in_array($_GET['type'], $allowed)){
			 	$post = new Post();
				$post->like_post($_GET['id'], $_GET['type'],$_SESSION['socialnet_userid']);
			 }

		}
		

	}

header("Location: ". $return_to);
die;