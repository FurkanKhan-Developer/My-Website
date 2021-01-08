<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirm_login(); ?>
<!DOCTYPE html>

<html>

<head>
<link rel="stylesheet type="text/css" href="css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://kit.fontawesome.com/1c394f4fca.js" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>

<link rel="stylesheet" href="css/Styles.css">
<title>Dashboard</title>
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
			<h1><i class="fas fa-blog" style="color:#27aae1;"></i>Blog Posts</h1>
		</div>
		<div class="col-lg-3 mb-2">
			<a href="AddNewPost.php" class="btn btn-primary btn-block">
				<i class="fas fa-edit"></i> Add New Post
			</a>
		</div>
		<div class="col-lg-3 mb-2">
			<a href="Categories.php" class="btn btn-info btn-block">
				<i class="fas fa-folder-plus"></i> Add New Category
			</a>
		</div>
		<div class="col-lg-3 mb-2">
			<a href="Admins.php" class="btn btn-warning btn-block">
				<i class="fas fa-user-plus"></i> Add New Admin
			</a>
		</div>
		<div class="col-lg-3 mb-2">
			<a href="Comments.php" class="btn btn-success btn-block">
				<i class="fas fa-check"></i> Approve Comments
			</a>
		</div>

	</div>
	</div>
</header>
<!-- HEADER ENDS -->
<!-- Main Area -->
<section class="container py-2 mb-4">
 <div class="row">
 <div class="col-lg-12">
	 <?php
		 echo ErrorMessage();
		 echo SuccessMessage();
	 ?>
	 <table class="table table-striped table-hover">
		 <thead class="thead-dark">
		 <tr>
			 <th>#</th>
			 <th>Title</th>
			 <th>Category</th>
			 <th>DateTime</th>
			 <th>Author</th>
			 <th>Banner</th>
			 <th>Comments</th>
			 <th>Action</th>
			 <th>Live Preview</th>
		</tr>
	</thead>
		<?php
		global $ConnectingDB;
		$sql = "SELECT * FROM posts ORDER BY id desc";
		$stmt = $ConnectingDB->query($sql);
		$Sr = 0;
		while ($DataRows = $stmt->fetch()){
  		$Id        =  $DataRows["id"];
			$DateTime  =  $DataRows["datetime"];
			$PostTitle =  $DataRows["title"];
			$Category  =  $DataRows["category"];
			$Admin     =  $DataRows["author"];
			$Image     =  $DataRows["image"];
			$PostText  =  $DataRows["post"];
			$Sr++;
		?>
		<tbody>
		<tr>
			<td><?php echo $Sr; ?></td>
			<td>
				<?php
				if (strlen($PostTitle)>20){$PostTitle = substr($PostTitle,0,18).'..';}
			  echo $PostTitle;
				?>
			 </td>
			<td>
				<?php
				if (strlen($Category)>8){$Category = substr($Category,0,8).'..';}
				echo $Category;
				?>
			</td>
			<td>
				<?php
				if (strlen($DateTime)>11){$DateTime = substr($DateTime,0,11).'..';}
				 echo $DateTime;
				 ?>
			 </td>
			<td>
				<?php
				if (strlen($Admin)>6){$Admin = substr($Admin,0,6).'..';}
				 echo $Admin;
				  ?>
			</td>
			<td><img src="Uploads/<?php echo $Image; ?>" width="170px;" height="50px"</td>
			<td>
					<?php
					$Total = ApproveCommentsAccordingtoPost($Id);
					if($Total>0){
						?>
						<span class="badge badge-success">
							<?php echo $Total; ?>
						</span>
				<?php	}		?>
			</span>
				<?php
				$Total = DisApproveCommentsAccordingtoPost($Id);
				if($Total>0){
					?>
					<span class="badge badge-danger">
						<?php echo $Total; ?>
					</span>
			<?php	}		?>
		</span>
			</td>
			<td>
				<a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
				<a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
			</td>
			<td>
				<a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</sapn></a>
				</td>
		</tr>
	</tbody>
 <?php } ?>
	 </table>

 </div>
 </div>
</section>
<!--Main Area Ends -->
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
