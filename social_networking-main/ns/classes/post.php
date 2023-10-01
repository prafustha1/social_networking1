<?php

class Post
{
	private $error = "";

	public function create_post($userid, $data, $files)
	{
		if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image']))
		{
			$myimage = "";
			$has_image = 0;
			$is_cover_image = 0;
			$is_profile_image = 0;

			if(isset($data['is_profile_image']) || isset($data['is_cover_image']))
			{
				$myimage = $files;
				$has_image = 1;

				if(isset($data['is_cover_image']))
				{
					$is_cover_image = 1;
				}
				
				if(isset($data['is_profile_image']))
				{
					$is_profile_image = 1;
				}
				
			}else{

				if(!empty($files['file']['name']))
				{
					
					$folder = "uploads/" . $userid . "/";

	  					//create folder
	  					if(!file_exists($folder))
	  					{
	  						mkdir($folder,0777,true);
	  						file_put_contents($folder . "index.php", "");
	  					}

	  					$image_class = new Image();

	  					$myimage = $folder . $image_class->generate_filename(15) . ".jpg";
	  					move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

	  					$image_class->resize_image($myimage,$myimage,1500,1500);

					$has_image = 1;
				}
			}

			$post = "";
			if(isset($data['post']))
			{
				$post = addslashes($data['post']);
			}
			
			$postid = $this->create_postid();

			$query = "insert into posts (userid,postid,post,image,has_image,is_cover_image,is_profile_image) values ('$userid','$postid','$post','$myimage','$has_image','$is_cover_image','$is_profile_image')" ;

			$DB = new Database();
			$DB->save($query);

		}else
		{
			$this->error .= "Please type something to post!<br>";
		}

		return $this->error;
	}

	public function get_post($id)
	{
		$query = "select * from posts where userid = '$id' order by id desc " ;

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result;

		}else
		{
			return false;
		}

	}

	public function get_follows($id,$type)
	{
		$DB = new Database();
		$type = addslashes($type);

		if(is_numeric($id))
		{
			//get follows details
			$sql = "select follows from follows where type='$type' && contentid = '$id' limit 1";
			$result = $DB->read($sql);
			if(is_array($result))
			{
				$follows = json_decode($result[0]['follows'],true);
				return $follows;
			}
		}

		return false;
			
	}

	public function follow_friend($id,$type,$socialnet_userid)
	{

			$DB = new Database();

			//save follows details
			$sql = "select follows from follows where type='$type' && contentid = '$id' limit 1";
			$result = $DB->read($sql);
			if(is_array($result))
			{
				
				$follows = json_decode($result[0]['follows'],true);

				$user_ids = array_column($follows, "userid");

				if(!in_array($socialnet_userid, $user_ids))
				{
					$arr["userid"] = $socialnet_userid;
					$arr["date"] = date("Y-m-d H:i:s");

					$follows[] = $arr;

					$follows_string = json_encode($follows);
					$sql = "update follows set follows = '$follows_string' where type='$type' && contentid = '$id' limit 1";
					$DB->save($sql);

					//increment the right table
					$sql = "update {$type}s set follows = follows + 1 where {$type}id = '$id' limit 1";
					$DB->save($sql);
				}else{
					$key = array_search($socialnet_userid, $user_ids);
					unset($follows[$key]);

					$follows_string = json_encode($follows);
					$sql = "update follows set follows = '$follows_string' where type='$type' && contentid = '$id' limit 1";
					$DB->save($sql);

					//decrement the right table
					$sql = "update {$type}s set follows = follows - 1 where {$type}id = '$id' limit 1";
					$DB->save($sql);


				}
				
			}else{

				$arr["userid"] = $socialnet_userid;
				$arr["date"] = date("Y-m-d H:i:s");

				$arr2[] = $arr;

				$follows = json_encode($arr2);
				$sql = "insert into follows (type,contentid,follows) values ('$type','$id','$follows') ";
				$DB->save($sql);

				//increment the right table
				$sql = "update {$type}s set follows = follows + 1 where {$type}id = '$id' limit 1";
				$DB->save($sql);
			}
		
	}
	public function like_post($id, $type,$socialnet_userid){
		if($type == "post"){
			$DB = new Database();
			
		// save likes details
		$
		$sql = " select likes from likes  where type ='post' &&  contentid = '$id' limit 1";
		$result = $DB->read($sql);
		if(is_array($result)){
			$likes = json_decode($result[0]['likes'],true);
			$user_ids = array_column($likes, "userid");

			if(!in_array($socialnet_userid, $user_ids)){


			$arr["userid"] = $socialnet_userid;
			$arr["date"] = date("Y-m-d H:i:s");
			$likes[] = $arr;
			$likes_string = json_encode($likes);

			$sql = " update likes set likes = '$likes_string' where type ='post' &&  contentid = '$id' limit 1";
			$DB->save($sql);
			// increment the posts table 
			$sql = " update posts  set likes = likes + 1 where postid = '$id'limit 1";
			$DB->save($sql);
			}else {
				$key = array_search($socialnet_userid, $user_ids);
				unset($likes[$key]);
				$likes_string = json_encode($likes);

			$sql = " update likes set likes = '$likes_string' where type ='post' &&  contentid = '$id' limit 1";
			$DB->save($sql);

			}

		} else{
			$arr["userid"] = $socialnet_userid;
			$arr["date"] = date("Y-m-d H:i:s");
			$arr2[] = $arr;

				$likes = json_encode($arr2);
			$sql = " insert into likes (type,contentid,likes) values ('$type','$contentid','$likes')";
			$DB->save($sql);
		// increment the posts table 
			$sql = " update posts  set likes = likes - 1 where postid = '$id'limit 1";
			$DB->save($sql);

		}


		}


	}


	private function create_postid()
	{
		$length = rand(4,19);
		$number = "";
		for ($i=0; $i < $length; $i++) { 
			# code...
			$new_rand = rand(0,9);
			$number = $number . $new_rand;
		}

		return $number;
	}
}