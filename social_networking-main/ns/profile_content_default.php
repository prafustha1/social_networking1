<div style="display: flex; justify-content: space-around;">


			<div id="one1">
				
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

			<div id="two22">
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
			    </div>
			</div>

			<!--posts-->
			<div id="three3">
						
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