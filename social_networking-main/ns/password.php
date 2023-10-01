<?php
include("classes/autoload.php");
if(isset($_POST['Submit']))
{
 $oldpass=md5($_POST['oldpassword']);
 $useremail=$_SESSION['login'];
 $newpassword=md5($_POST['newpassword']);
$sql=mysqli_query($con,"SELECT password FROM users where password='$oldpass' && email='$email'");
$num=mysqli_fetch_array($sql);
if($num>0)
{
 $con=mysqli_query($con,"UPDATE users set password=' $newpassword' where email='$email'");
$_SESSION['msg1']="Password Changed Successfully !!";
}
else
{
$_SESSION['msg1']="Old Password not match !!";
}
}
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

	<div class="passbox">
		<center><h3>Change Password</h3></center>
		<div><?php echo $_SESSION['msg1'];?><?php echo  $_SESSION['msg1'];?></div>
		<form method="POST" action="" align="center">
			Current Password: <input type="password" name="currentpassword"> <span id="currentpassword" class="required"></span><br>
			New Password: <input type="password" name="newpassword"> <span id="newpassword" class="required"><br>
			
			Confirm Password: <input type="password" name="confirmpasssword"> <span id="newpassword" class="required"><br><br>
				<input type="submit">
		</form>
		
	</div>

	
</body>
</html>

