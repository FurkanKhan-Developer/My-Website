<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
confirm_login(); ?>
<!--Fetching the existing Admin Data start-->
<?php
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()){
	$ExistingName = $DataRows['aname'];
	$ExistingUsername = $DataRows['username'];
	$ExistingHeadline = $DataRows['aheadline'];
	$ExistingBio = $DataRows['abio'];
	$ExistingImage = $DataRows['aimage'];
}
//Fetching the existing Admin Data end
if(isset($_POST["Submit"])){
	$AName = $_POST["Name"];
	$AHeadline  = $_POST["Headline"];
	$ABio = $_POST["Bio"];
	$Image     = $_FILES["Image"]["name"];
	$Target    = "Images/".basename($_FILES["Image"]["name"]);
if(strlen($AHeadline)>30){
		$_SESSION["ErrorMessage"]= "Headline should be less than 30 characters";
		Redirect_to("MyProfile.php");
	}elseif(strlen($ABio)>500){
		$_SESSION["ErrorMessage"]= "Bio should be less than 500 characters";
		Redirect_to("MyProfile.php");
	}else{
		//Query to Update Admin data in DB when everything is fine.
		global $ConnectingDB;
		if(!empty($_FILES["Image"]["name"])){
			$sql = "UPDATE admins
							SET aname = '$AName', aheadline = '$AHeadline', abio = '$ABio', aimage = '$Image'
							WHERE id='$AdminId'";
		}else{
			$sql = "UPDATE admins
							SET aname = '$AName', aheadline = '$AHeadline', abio = '$ABio'
							WHERE id='$AdminId'";
		}
		$Execute = $ConnectingDB->query($sql);
		move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
		if($Execute){
			$_SESSION["SuccessMessage"]="Details Updated Successfully";
			Redirect_to("MyProfile.php");
		}else{
			$_SESSION["ErrorMessage"]= "Something Went Wrong. Try Again!";
			Redirect_to("MyProfile.php");
		}
	}
} //Ending of submit button. If-condition


?>
<!DOCTYPE html>

<html>

<head>
<link rel="stylesheet type="text/css" href="css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://kit.fontawesome.com/1c394f4fca.js" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>

<link rel="stylesheet" href="css/Styles.css">
<title>My Profile</title>
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
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a href="MyProfile.php" class="nav-link"><i class="fas fa-user-alt text-primary"></i> My Profile</a>
			</li>
			<li class="nav-item">
				<a href="Dashboard.php" class="nav-link">Dashboard</a>
			</li>
			<li class="nav-item">
				<a href="Posts.php" class="nav-link">Posts</a>
			</li>
			<li class="nav-item">
				<a href="Categories.php" class="nav-link">Categories</a>
			</li>
			<li class="nav-item">
				<a href="Admins.php" class="nav-link">Manage Admins</a>
			</li>
			<li class="nav-item">
				<a href="Comments.php" class="nav-link">Comments</a>
			</li>
			<li class="nav-item">
				<a href="Blog.php?page=1" class="nav-link">Live Blog</a>
			</li>

		</ul>
		<u class="navbar-nav ml-auto">
			<li class="nav-item"><a href="Logout.php" class="nav-link"><i class="fas fa-user-times text-danger"></i> Logout</a></li>
		</u>
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
			<h1><i class="fas fa-user text-success mr-2"></i>@<?php echo $ExistingUsername; ?> </h1>
			<small><?php echo $ExistingHeadline; ?></samll>
		</div>
	</div>
	</div>
</header>
<!-- HEADER ENDS -->
<!-- MAIN AREA -->
<section class="container py-2 mb-4">
	<div class="row">
		<!-- Left Area -->
		<div class="col-md-3">
			<div class="card">
				<div class="card-header bg-dark text-light">
					<h3><?php echo $ExistingName; ?></h3>
				</div>
				<div class="card-body">
					<img src="Images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
					 <div class="card-body">
             <p class="lead"> <?php echo $ExistingBio; ?> </p>
					</div>
				</div>
			</div>
		</div>
		<!-- Right Area -->
		<div class="col-md-9" style="min-height:400px;">
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
			<form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
				<div class="card bg-dark text-light">
					<div class="card-header bg-secondary text-light">
						<h4>Edit Profile</h4>
					</div>
					<div class="card-body">
						<div class="form-group">
							<input class="form-control" type="text" name="Name" id="title" placeholder="Your name" value="">
						</div>
						<div class="form-group">
							<input class="form-control" type="text" id="title" placeholder="Headline" name="Headline">
							<small class="text-muted">Add a professional headline like, 'Engineer' at XYZ or 'Architect'</small>
							<span class="text-danger">Not more than 30 characters</span>
						</div>
						<div class="form-group">
						<textarea placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80"></textarea>
						</div>
						<div class="form-group">
							<div class="custom-file">
							<input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
							<label for="imageSelect" class="custom-file-label">Select Image</label>
						</div>
					</div>
							<div class="row">
							<div class="col-lg-6 mb-2">
								<a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
							</div>
							<div class="col-lg-6 mb-2">
								<button type="submit" name="Submit" class="btn btn-success btn-block">
									<i class="fas fa-check"></i> Publish
								</button>
							</div>
						</div>
					</div>
				</div>

      </form>
    </div>
	</div>

</section>
<!-- END MAIN AREA -->
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
