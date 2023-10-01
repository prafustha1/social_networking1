<?php

  include("classes/connect.php");
  include("classes/signup.php");

    $first_name = "";
    $last_name = "";
    $gender = "";
    $email = "";
    $dob = "";

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $signup = new Signup();
    $result = $signup->evaluate($_POST);

    if($result != "")
    {

      echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
      echo "<br>The following errors occured <br><br>";
      echo $result;
      echo "</div>";
    }else
    {
      header("Location: sign_in.php");
      die;
    }

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
 
  }



?>


<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="sign_up.css?v=<?php echo time(); ?>">
  </head>
  <body>

  	<section class="Form my-4 mx-5">
  		<div class="container">
  			<div class="row g-0">
  				<div class="col-lg-5" id="slider">
  					<figure>
            <img src="signup_slide1.jpg" class="img-fluid" alt="">
            <img src="signup_slide2.jpg" class="img-fluid" alt="">
            <img src="signup_slide1.jpg" class="img-fluid" alt="">
            <img src="signup_slide3.jpg" class="img-fluid" alt="">
            <img src="signup_slide1.jpg" class="img-fluid" alt="">
            </figure>
  				</div>
  				<div class="col-lg-7 px-5 py-3">
            <h1 class="font-weight-bold py-3">BEAP</h1>
            <h8>Come join our community!<br>
             Let's set up your account. Already have one? <a href="sign_in.php">Sign in</a></h8>

  					<form method="post" action="">

  						<div class="input-group">
  							<div class="col-5">
  							   <input type="name" name="first_name" placeholder="First name" class="form-control my-3 p-3">
  							</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <div class="col-5">
                  <input type="name" name="last_name" placeholder="Last name" class="form-control my-3 p-3">
                </div>
  						</div>
              <div class="form-row">
                <div class="col-lg-11">
                  <input type="email" name="email" placeholder="Email address" class="form-control p-3">
                </div>
              </div>
              <div class="form-row">
                <div class="col-lg-11">
                  <input type="password" name="password" placeholder="Password" class="form-control my-3 p-3">
                </div>
              </div>
              <div class="form-row">
                <div class="col-lg-11">
                  <input type="password" name="password2" placeholder="Confirm password" class="form-control my-3 p-3">
                </div>
              </div>
              <div class="form-row">
                <div class="col-lg-7">
                  <input type="text" name="dob" placeholder="Date of birth" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control my-3 p-3">
                </div>
              </div>
              <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="inlineRadio1" value="Female" name="gender">
                  <label class="form-check-label" for="inlineRadio1">Female</label>
              </div>
               <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="inlineRadio2" value="Male" name="gender">
                  <label class="form-check-label" for="inlineRadio2">Male</label>
              </div>
              <div class="form-check form-check-inline">
                  <input type="radio" class="form-check-input" id="inlineRadio3" value="Other" name="gender">
                  <label class="form-check-label" for="inlineRadio3">Other</label>
              </div><br><br>
              By submitting this form you agree to our <a href="#">Terms of Service</a>.
  						<div class="form-row">
  							<div class="col-lg-7">
  								<input type="submit" name="" class="btn1 mt-3 mb-5" value="Sign Up">
  							</div>
  						</div>

  					</form>

  				</div>
  			</div>
  		</div>
  	</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

  </body>
</html>