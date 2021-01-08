<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirm_login(); ?>
<?php
if(isset($_POST["Submit"])){
	$Category = $_POST["CategoryTitle"];
	$Admin = $_SESSION["UserName"];
	date_default_timezone_set("Asia/Kolkata");
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

	if(empty($Category)){
		$_SESSION["ErrorMessage"]= "All fields must be filled out";
		Redirect_to("Categories.php");
	}elseif(strlen($Category)<3){
		$_SESSION["ErrorMessage"]= "Category title should be greater than 3 characters";
		Redirect_to("Categories.php");
	}elseif(strlen($Category)>49){
		$_SESSION["ErrorMessage"]= "Category title should be less than 50 characters";
		Redirect_to("Categories.php");
	}else{
		//Query to insert Category in DB when everything is fine.
		$sql = "INSERT INTO category(title,author,datetime)";
		$sql .= "VALUES(:categoryName,:adminName,:dateTime)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':categoryName',$Category);
		$stmt->bindValue(':adminName',$Admin);
		$stmt->bindValue(':dateTime',$DateTime);
		$Execute=$stmt->execute();

		if($Execute){
			$_SESSION["SuccessMessage"]="Category with id: ".$ConnectingDB->lastInsertId()." Added Successfully";
			Redirect_to("Categories.php");
		}else{
			$_SESSION["ErrorMessage"]= "Something Went Wrong. Try Again!";
			Redirect_to("Categories.php");
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
<title>Categories</title>
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
			<h1><i class="fas fa-edit" style="color:#27aae1;"></i> Manage Categories</h1>
		</div>
	</div>
	</div>
</header>
<!-- HEADER ENDS -->
<!-- MAIN AREA -->
<section class="container py-2 mb-4">
	<div class="row">
		<div class="offset-lg-1 col-lg-10" style="min-height:400px;">
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>

			<form class="" action="Categories.php" method="post">
				<div class="card bg-secondary text-light mb-3">
					<div class="card-header">
						<h1>Add New Category</h1>
					</div>
					<div class="card-body bg-dark">
						<div class="form-group">
							<lable class="title"> <span class="FieldInfo"> Category Title: </span></lable>
							<input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here" value="">
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
			<h2>Existing Categories</h2>
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th>No. </th>
						<th>Date&Time</th>
						<th>Category Name</th>
						<th>Creator Name</th>
						<th>Action</th>
					</tr>
				</thead>
			<?php
			global $ConnectingDB;
			$sql = "SELECT * FROM category ORDER BY id desc";
			$Execute = $ConnectingDB->query($sql);
			$SrNo = 0;
			while($DataRows=$Execute->fetch()){
				$CategoryId = $DataRows["id"];
				$CategoryDate = $DataRows["datetime"];
				$CategoryName = $DataRows["title"];
				$CreatorName = $DataRows["author"];
				$SrNo++;
				//if(strlen($DateTimeOfComment)>11){$DateTimeOfComment = strlen($DateTimeOfComment,0,11)."..";}
				//if(strlen($CommenterName)>10){$CommenterName = strlen($CommenterName,0,10)."..";}
			?>
			<tbody>
				<tr>
					<td><?php echo htmlentities($SrNo); ?></td>
					<td><?php echo htmlentities($CategoryDate); ?></td>
					<td><?php echo htmlentities($CategoryName); ?></td>
					<td><?php echo htmlentities($CreatorName); ?></td>
					<td><a href="DeleteCategory.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger">Delete</a></td>
				</tr>
			</tbody>
			<?php } ?>
			</table>
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
