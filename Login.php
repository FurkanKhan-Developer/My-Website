<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if(isset($_SESSION["UserId"])){
	Redirect_to("Dashboard.php");
}
if(isset($_POST["Submit"])){
	$UserName = $_POST["Username"];
	$Password = $_POST["Password"];
	if(empty($UserName)||empty($Password)){
		$_SESSION["ErrorMessage"] = "All fields must be filled out";
		Redirect_to("Login.php");
	}else{
		//code for checking whether username and password are from database.
		$Found_Account=Login_Attempt($UserName,$Password);
		if($Found_Account){
			$_SESSION["UserId"]=$Found_Account["id"];
			$_SESSION["UserName"]=$Found_Account["username"];
			$_SESSION["AdminName"]=$Found_Account["aname"];
			$_SESSION["SuccessMessage"]="Welcome ".$_SESSION["AdminName"]."!";
			if(isset($_SESSION["TrackingURL"])){
				Redirect_to($_SESSION["TrackingURL"]);
			}else{
			Redirect_to("Dashboard.php");
		}
		}else{
			$_SESSION["ErrorMessage"]="Incorrect Username/Password";
			Redirect_to("Login.php");
		}
	}
}





?>
<!DOCTYPE html>

<html>

<head>
<link rel="stylesheet type="text/css" href="css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://kit.fontawesome.com/1c394f4fca.js" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>

<link rel="stylesheet" href="css/Styles.css">
<title>Login</title>
</head>

<body>
<!-- NAVBAR -->
<div style="height:10px; background:#27aae1;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<a href="#" class="navbar-brand">FURKANKHAN.COM</a>
		<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarcollapseCMS">
	</div>
	</div>


</nav>
<div style="height:10px; background:#27aae1;"></div>
<!-- NAVBAR END -->
<!-- HEADER -->
<header class="bg-dark text-white py-3">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
		</div>
	</div>
	</div>
</header>
<!-- HEADER ENDS -->
<!-- Main Area Start -->
<section class="container py-2 mb-4">
	<div class="row">
		<div class="offset-sm-3 col-sm-6" style="min-height:500px;">
			<br><br><br>
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
			<div class="card bg-secondary text-light">
				<div class="card-header">
					<h4>Welcome Back!</h4>
					</div>
					<div class="card-body bg-dark">
					<form class="" action="Login.php" method="post">
						<div class="form-group">
							<label for="username"><span class="FieldInfo">Username:</span></label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text text-light bg-info"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" class="form-control" name="Username" id="username" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="password"><span class="FieldInfo">Password:</span></label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text text-light bg-info"><i class="fas fa-lock"></i></span>
								</div>
								<input type="password" class="form-control" name="Password" id="password" value="">
							</div>
						</div>
						<input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Main Area End -->
<!-- FOOTER -->
<footer class="bg-dark text-white">
	<div class="container">
		<div class="row"></div>
		<div class="col">
		<p class="lead text-center">Theme By | Furkan Khan | <span id="year"></span> &copy; ----All Rights Reserved.</p>
		<p class="text-center small"><a style="color:white; text-decoration: none; cursor:pointer;" href="http://FURKANKHAN.COM/Coupons/" target="_blank">
			This site is used only for Study purpose furkankhan.com has all the rights. No one is allowed to distribute
			copies other than <br>&trade; furkankhan.com &trade; Udemy; &trade; SkillShare; &trade; StackSkills
		</a></p>
	  </div>
</div>
<div style="height:10px; background:#27aae1;"></div>
</footer>
<!-- FOOTER END -->

<button type="button" class="btn btn-primary">Primary</button>
<button type="button" class="btn btn-secondary">Secondary</button>
<button type="button" class="btn btn-success">Success</button>
<button type="button" class="btn btn-danger">Danger</button>
<button type="button" class="btn btn-warning">Warning</button>
<button type="button" class="btn btn-info">Info</button>
<button type="button" class="btn btn-light">Light</button>
<button type="button" class="btn btn-dark">Dark</button>

<button type="button" class="btn btn-link">Link</button>
<script>
	$('#year').text(new Date().getFullYear());
</script>
</body>

</html>
