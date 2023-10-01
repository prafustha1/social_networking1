<div style="min-height: 500px; width: 100%; background-color: white; text-align: center;"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

	<div style="padding: 20px;">
	<?php
		
		$DB = new Database();
		$sql = "select image,postid from posts where has_image = 1 && userid = $user_data[userid] order by id desc limit 30";
		$images = $DB->read($sql);

		$image_class = new Image();

		if(is_array($images))
		{
			foreach ($images as $image_row) {
				# code...
				echo "<img src='" . $image_class->get_thumb_post($image_row['image']) . "' style='width:150px; margin:10px; ' />" ;
			}
			
		}else{
			echo "No images were found!";
		}

	?>
	</div>

</div>