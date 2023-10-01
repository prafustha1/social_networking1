<?php

session_start();

if(isset($_SESSION['socialnet_userid']))
{
	$_SESSION['socialnet_userid'] = NULL;
	unset($_SESSION['socialnet_userid']);
}


header('Location: sign_in.php');
die;