<?php

	include("classes/autoload.php");

	$signin = new Signin();
	$user_data = $signin->check_signin($_SESSION['socialnet_userid']);

	if(isset($_GET['find']))
	{
		$find = addslashes($_GET['find']);

		$sql = "select * from users where first_name like '%$find%' || last_name like '%$find%' limit 20 ";
		$DB = new Database();
		$result = $DB->read($sql);
	}
	?>

	<!DOCTYPE html>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Search</title>
		</head>

		<link rel="stylesheet" type="text/css" href="profile.css?v=<?php echo time(); ?>">
			
		<body style="font-family: tahoma;">

			<br>
			<?php include("header.php"); ?>

			<!--cover area-->
			<div style="width: 800px; margin: auto; min-height: 400px;">

				<!--below cover area-->
				<div style="display: flex;">

					<!--posts area-->
					<div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px; margin-top: 50px;">

						<div style="border: solid thin #aaa; padding: 10px; background-color: white;" class="search_area">

							<?php

								$User = new User();
								$image_class = new Image();

								if(is_array($result))
								{
									foreach ($result as $row) {
										# code...
										$FRIEND_ROW = $User->get_user($row['userid']);
										include("user.php");
									}
								}else{
									echo "no results were found!";
								}


							?>

							<br style="clear: both;">
							
						</div>
						
					</div>
					
				</div>
				
			</div>
		
		</body>
		</html>