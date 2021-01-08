<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
confirm_login(); ?>
<?php
if(isset($_POST["Submit"])){
	$PostTitle = $_POST["PostTitle"];
	$Category  = $_POST["Category"];
	$Image     = $_FILES["Image"]["name"];
	$Target    = "Uploads/".basename($_FILES["Image"]["name"]);
	$PostText  = $_POST["PostDescription"];
	$Admin = $_SESSION["UserName"];

	date_default_timezone_set("Asia/Kolkata");
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

	if(empty($PostTitle)){
		$_SESSION["ErrorMessage"]= "Title cant be empty";
		Redirect_to("AddNewPost.php");
	}elseif(strlen($PostTitle)<5){
		$_SESSION["ErrorMessage"]= "Post Title should be greater than 5 characters";
		Redirect_to("AddNewPost.php");
	}elseif(strlen($PostText)>9999){
		$_SESSION["ErrorMessage"]= "Post Description should be less than 1000 characters";
		Redirect_to("AddNewPost.php");
	}else{
		//Query to insert Posts in DB when everything is fine.
		$sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
		$sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':dateTime',$DateTime);
		$stmt->bindValue(':postTitle',$PostTitle);
		$stmt->bindValue(':categoryName',$Category);
		$stmt->bindValue(':adminName',$Admin);
		$stmt->bindValue(':imageName',$Image);
		$stmt->bindValue(':postTitle',$PostTitle);
		$stmt->bindValue(':postDescription',$PostText);
  	$Execute=$stmt->execute();
		move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
		if($Execute){
			$_SESSION["SuccessMessage"]="Post with id : ".$ConnectingDB->lastInsertId()." Added Successfully";
			Redirect_to("AddNewPost.php");
		}else{
			$_SESSION["ErrorMessage"]= "Something Went Wrong. Try Again!";
			Redirect_to("AddNewPost.php");
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
			<h1><i class="fas fa-edit" style="color:#27aae1;"></i> Add New Post </h1>
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

			<form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
				<div class="card bg-secondary text-light mb-3">
					<div class="card-body bg-dark">
						<div class="form-group">
							<lable class="title"> <span class="FieldInfo"> Post Title: </span></lable>
							<input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="">
						</div>
						<div class="form-group">
							<lable for="CategoryTitle"> <span class="FieldInfo"> Choose Category: </span></lable>
							<select class="form-control" id="CategoryTitle" name="Category">
								<?php
									//Fetching all the categories from the category mysql_list_table
									global $ConnectingDB;
									$sql = "SELECT id,title FROM category";
									$stmt = $ConnectingDB->query($sql);
									while ($DataRows = $stmt->fetch()){
										$Id = $DataRows["id"];
										$CategoryName = $DataRows["title"];
										?>
										<option> <?php echo $CategoryName; ?> </option>
									<?php  } ?>
							</select>
						</div>
						<div class="form-group">
							<div class="custom-file">
							<input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
							<label for="imageSelect" class="custom-file-label">Select Image</label>
						</div>
						</div>
						<div class="form-group">
						<lable for="Post"> <span class="FieldInfo"> Post: </span></lable>
						<textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80"></textarea>
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
