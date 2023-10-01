<div id="post">
				<div>
					<?php

						$image = "images/user_male.jpg";
						if($ROW_USER['gender'] == "Female")
						{
							$image = "images/user_female.jpg";
						}

						if(file_exists($ROW_USER['profile_image']))
						{
							$image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
						}
					?>
					<img src="<?php echo $image ?>" style="width: 75px; margin-right: 4px; border-radius: 50%;">
				</div>
					<div>
						<div style="font-weight: bold; color: #a6a6a6;"><a href="profile.php?id=<?php echo $ROW_USER['userid']; ?>" style="text-decoration: none;"><?php echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']); ?></a>

							<?php
							if($ROW['is_profile_image'])
							{
								$pronoun = "his";
								if($ROW_USER['gender'] == "Female")
								{
									$pronoun = "her";
								}
								echo "<span style='font-weight:normal; color:#aaa;'> changed $pronoun profile picture </span>";
							}

							if($ROW['is_cover_image'])
							{
								$pronoun = "his";
								if($ROW_USER['gender'] == "Female")
								{
									$pronoun = "her";
								}
								echo "<span style='font-weight:normal; color:#aaa;'> changed $pronoun cover picture </span>";
							}
							
							?>

						</div>

							<?php echo htmlspecialchars($ROW['post']);  ?>
							<br><br>

							<?php 
								if(file_exists($ROW['image']))
								{
									
									$post_image = $image_class->get_thumb_post($ROW['image']);
									echo "<img src='$post_image' style='width:80%;' />"; 
								}
								 
							?>
							<br/><br><br/>
							<?php
								 $likes = "";
								 $likes = ($ROW['likes'] > 0) ? "(" .$ROW['likes']. ")" : "" ;

								 }




							?>

							<a href="like.php?type=post&id=<?php echo $ROW['postid'] ?>" style="text-decoration: none;">Like<?php echo $likes ?></a> . <a href="#" style="text-decoration: none;">Comment</a> . <span style="color: #999;"><?php echo $ROW['date']  ?></span> 

							<span style="color: #999; float: right; margin-left: 300px;"> <a href="#" style="text-decoration: none;"> Edit </a> . <a href="#" style="text-decoration: none;">Delete </a></span>
						</div>
					</div>
					<hr style="color: #999;">