<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
 <!--Fetching Exsiting Data-->

<?php
    $SearchQueryParameter = $_GET['username'];
    global $ConnectingDB;
    $sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName', $SearchQueryParameter);
    $stmt->execute();
    $Result = $stmt->rowcount();
if($Result==1){
	while ($DataRows=$stmt->fetch()){
		$ExistingName     = $DataRows["aname"];
		$ExistingBio      = $DataRows["abio"];
		$ExistingImage    = $DataRows["aimage"];
		$ExistingHeadline = $DataRows["aheadline"];
	}
}else{
  $_SESSION["ErrorMessage"]="Bad Request!";
  Redirect_to("Blog.php?page=1");
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
<title>Profile</title>
</head>

<body>
<<!-- NAVBAR -->
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
				<a href="Blog.php" class="nav-link">Home</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">About Us</a>
			</li>
			<li class="nav-item">
				<a href="Blog.php" class="nav-link">Blog</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">Contact Us</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">Features</a>
			</li>
		</ul>
		<u class="navbar-nav ml-auto">
		 <form class="form-inline d-none d-sm-block" action="Blog.php">
			 <div class="form-group">
				 <input class="form-control mr-2" type="text" name="Search" placeholder='Search here'value="">
				 <button class="btn btn-primary" name="SearchButton">Go</button>
		 </div>

	 </form>
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
			<div class="col-md-6">
			<h1><i class="fas fa-user text-success mr-2" style="color:#27aae1;"></i><?php echo $ExistingName; ?></h1>
			<h3><?php echo $ExistingHeadline; ?></h3>
		</div>
	</div>
	</div>
</header>
<!-- HEADER ENDS -->
<section class="container py-2 mb-4">
	<div class="row">
		<div class="col-md-3">
			<img src="Images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
		</div>
		<div class="col-md-9" style="min-height:400px;">
			<div class="card">
				<div class="card-body">
					<p class="lead"> <?php echo $ExistingBio; ?> </p>
				</div>
			</div>
		</div>
	</div>

</section>
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
