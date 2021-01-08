<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET['id']; ?>
<?php
if(isset($_POST["Submit"])){
	$Name = $_POST["CommenterName"];
	$Email = $_POST["CommenterEmail"];
	$Comments = $_POST["CommenterThoughts"];
	date_default_timezone_set("Asia/Kolkata");
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

	if(empty($Name)||empty($Email)||empty($Comments)){
		$_SESSION["ErrorMessage"]= "All fields must be filled out";
		Redirect_to("FullPost.php?id=$SearchQueryParameter");
	}elseif(strlen($Comments)>500){
		$_SESSION["ErrorMessage"]= "Comment length should be less than 500 characters";
		Redirect_to("FullPost.php?id=$SearchQueryParameter");
	}else{
		//Query to insert Comments in DB when everything is fine.
		$sql = "INSERT INTO comments(datetime,name,email,comments,approvedby,status,post_id)";
		$sql .= "VALUES(:datetime,:name,:email,:comments,'Pending','OFF',:postIdfromURL)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':datetime',$DateTime);
		$stmt->bindValue(':name',$Name);
		$stmt->bindValue(':email',$Email);
		$stmt->bindValue(':comments',$Comments);
		$stmt->bindValue(':postIdfromURL',$SearchQueryParameter);
		$Execute=$stmt->execute();
		//var_dump($Execute);

		if($Execute){
			$_SESSION["SuccessMessage"]="Comment Submitted Successfully";
			Redirect_to("FullPost.php?id=$SearchQueryParameter");
		}else{
			$_SESSION["ErrorMessage"]= "Something Went Wrong. Try Again!";
			Redirect_to("FullPost.php?id=$SearchQueryParameter");
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
<title> Full Post Page </title>
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
<div class="container">
	<div class="rows mt-4">
		<!-- Main Area Start -->
		<div class="col-sm-8">
			<h1>The Complete Responsive CMS Blog</h1>
			<h1 class="lead">The Complete blog using PHP by FurkanKhan</h1>
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
			<?php
			global $ConnectingDB;
			//Search Query when Search button is Active.
			if(isset($_GET["SearchButton"])){
				$Search = $_GET["Search"];
				$sql = "SELECT * FROM posts
				WHERE datetime LIKE :search
				OR title LIKE :search
				OR category LIKE :search
				OR post LIKE :search";
				$stmt = $ConnectingDB->prepare($sql);
				$stmt->bindValue(':search','%'.$Search."%");
				$stmt->execute();
			}
		else{
			$PostIdfromURL = $_GET["id"];
			if(!isset($PostIdfromURL)){
				$_SESSION["ErrorMessage"]= "Bad Request!";
				Redirect_to("Blog.php");
			}
			$sql = "SELECT * FROM posts WHERE id= '$PostIdfromURL'";
			$stmt = $ConnectingDB->query($sql);
			$Result = $stmt->rowcount();
			if ($Result!=1){
				$_SESSION["ErrorMessage"]= "Bad Request!";
				Redirect_to("Blog.php?page=1");
			}
		}

			while ($DataRows = $stmt->fetch()){
				$PostId           =  $DataRows["id"];
				$DateTime         =  $DataRows["datetime"];
				$PostTitle        =  $DataRows["title"];
				$Category         =  $DataRows["category"];
				$Admin            =  $DataRows["author"];
				$Image            =  $DataRows["image"];
				$PostDescription  =  $DataRows["post"];

			?>
			<div class="card">
				<img src="Uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top"/>
				<div class="card-body">
					<h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
				  	<small class="card-muted">Category:<span class="text-dark"><a href="Blog.php?category=<?php echo htmlentities($Category);?>"> <?php echo htmlentities($Category);?></a></span> & Written by <span class="text-dark"><a href="Profile.php?username=<?php echo htmlentities($Admin); ?>"><?php echo htmlentities($Admin); ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span> <span class="text-dark">
					<hr>
					<p class="card-text">
						<?php echo nl2br($PostDescription); ?></p>
				</div>
			</div>
		<?php } ?>
		<!-- Comments Area Start -->
		<!-- Fetching existing comments start -->
		<span class="FieldInfo">Comments</span>
		<br><br>
		<?php
		global $ConnectingDB;
		$sql = "SELECT * FROM comments
		WHERE post_id='$SearchQueryParameter' AND status='ON'";
		$stmt = $ConnectingDB->query($sql);
		while($DataRows = $stmt->fetch()){
			$CommentDate      =  $DataRows['datetime'];
			$CommenterName    =  $DataRows['name'];
			$CommenterContent =  $DataRows['comments'];
		?>
		<div>
			<div class="media CommentBlock">
				<img class="d-block img-fluid align-self-start" src="Images/iconfinder2.png" alt="">
				<div class="media-body ml-2">
					<h6 class="lead"><?php echo $CommenterName; ?></h6>
					<p class="small"><?php echo $CommentDate; ?></p>
					<p><?php echo $CommenterContent; ?></p>
				</div>
			</div>
		</div>
		<hr>
	<?php } ?>
		<!-- Fetching existing comments Ends-->
		<div class="">
			<form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
				<div class="card mb-3">
					<div class="card-header">
						<h5 class="FieldInfo">Share your thoughts about this posts</h5>
					</div>
					<div class="card-body">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
							<input class="form-control" type="text" name="CommenterName" placeholder="name" value="">
						</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								</div>
							<input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
						</div>
						</div>
						<div class="form-group">
							<textarea name="CommenterThoughts" class="form-control" rows="6" cols="80"></textarea>
						</div>
						<div class="">
							<button type="submit" name="Submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<!-- Comments Area Ends-->
		</div>
		<!-- Main Area End-->
<?php require_once("Footer.php") ?>
