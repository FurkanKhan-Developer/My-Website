<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
confirm_login(); ?>
<!DOCTYPE html>

<html>

<head>
<link rel="stylesheet type="text/css" href="css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://kit.fontawesome.com/1c394f4fca.js" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>

<link rel="stylesheet" href="css/Styles.css">
<title>Comments</title>
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
			<h1><i class="fas fa-comments" style="color:#27aae1;"></i>Manage Comments</h1>
		</div>
	</div>
	</div>
</header>
<!-- HEADER ENDS -->
<!-- Main Area Start -->
<section class="container py-2 mb-4">
	<div class="row" style="min-height:30px;">
		<div class="col-lg-12" style="min-height:400px;">
			<?php
				echo ErrorMessage();
				echo SuccessMessage();
			?>
			<h2>Unapproved Comments</h2>
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th>No. </th>
						<th>Date&Time</th>
						<th>Name</th>
						<th>Comment</th>
						<th>Approve</th>
						<th>Action</th>
						<th>Details</th>
					</tr>
				</thead>
			<?php
			global $ConnectingDB;
			$sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
			$Execute = $ConnectingDB->query($sql);
			$SrNo = 0;
			while($DataRows=$Execute->fetch()){
				$CommentId = $DataRows["id"];
				$DateTimeOfComment = $DataRows["datetime"];
				$CommenterName = $DataRows["name"];
				$CommentContent = $DataRows["comments"];
				$CommentPostId = $DataRows["post_id"];
				$SrNo++;
				//if(strlen($DateTimeOfComment)>11){$DateTimeOfComment = strlen($DateTimeOfComment,0,11)."..";}
				//if(strlen($CommenterName)>10){$CommenterName = strlen($CommenterName,0,10)."..";}
			?>
			<tbody>
				<tr>
					<td><?php echo htmlentities($SrNo); ?></td>
					<td><?php echo htmlentities($DateTimeOfComment); ?></td>
					<td><?php echo htmlentities($CommenterName); ?></td>
					<td><?php echo htmlentities($CommentContent); ?></td>
					<td><a href="ApproveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-success">Approve</a></td>
					<td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
					<td style="min-width:140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
				</tr>
			</tbody>
			<?php } ?>
			</table>
			<h2>Approved Comments</h2>
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th>No. </th>
						<th>Date&Time</th>
						<th>Name</th>
						<th>Comment</th>
						<th>Revert</th>
						<th>Action</th>
						<th>Details</th>
					</tr>
				</thead>
			<?php
			global $ConnectingDB;
			$sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
			$Execute = $ConnectingDB->query($sql);
			$SrNo = 0;
			while($DataRows=$Execute->fetch()){
				$CommentId = $DataRows["id"];
				$DateTimeOfComment = $DataRows["datetime"];
				$CommenterName = $DataRows["name"];
				$CommentContent = $DataRows["comments"];
				$CommentPostId = $DataRows["post_id"];
				$SrNo++;
				//if(strlen($DateTimeOfComment)>11){$DateTimeOfComment = strlen($DateTimeOfComment,0,11)."..";}
				//if(strlen($CommenterName)>10){$CommenterName = strlen($CommenterName,0,10)."..";}
			?>
			<tbody>
				<tr>
					<td><?php echo htmlentities($SrNo); ?></td>
					<td><?php echo htmlentities($DateTimeOfComment); ?></td>
					<td><?php echo htmlentities($CommenterName); ?></td>
					<td><?php echo htmlentities($CommentContent); ?></td>
					<td style="min-width:140px;"><a href="DisApproveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-warning">Dis-Approve</a></td>
					<td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
					<td style="min-width:140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
				</tr>
			</tbody>
			<?php } ?>
			</table>
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
