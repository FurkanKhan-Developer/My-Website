<!-- Side Area Start-->
<div class="col-sm-4">
  <div class="card mt-4">
    <div class="card-body">
      <img src="Images/start-a-blog.png" class="d-block img-fluid mb-3" alt="">
      <div class="text-center">
        Become a Better Writer: Practice makes perfect, and blogging gives you the platform to sharpen your writing skills to perfection.
Make Some Serious Money: Successful bloggers bring in all kinds of income from their blogs. Whether they sell ad space, promote products, or sell their own services, there’s money to be made!
Blogging Opens up New Opportunities: Sometimes it’s a great mention on your resume, and other times it helps you get hired for consulting or writing services, but either way, it benefits your career.
Total Control, Total Freedom: Your blog is a business that you own and it makes you the boss. Work when you want, how you want, and control every aspect of your life.
Anyone Can Do It: You don’t have to be a scientist or an engineer. Anyone can blog, even if they’re not a writer.
      </div>
    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header bg-dark text-light">
      <h2 class="lead">Sign Up</h2>
    </div>
    <div class="card-body">
      <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">Join the Forum</button>
      <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="" placeholder="Enter your Email" value="">
        <div class="input-group-append">
          <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<br>
<div class="card col-md-offset-8">
<div class="card-header bg-primary text-light">
  <h2 class="lead">Categories</h2>
  </div>
  <div class="card-body">
    <?php
    global $ConnectingDB;
    $sql = "SELECT * FROM category ORDER BY id desc";
    $stmt = $ConnectingDB->query($sql);
    while($DataRows = $stmt->fetch()){
      $CategoryId = $DataRows["id"];
      $CategoryName = $DataRows["title"];
    ?>
    <a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?></span></a><br>
  <?php } ?>
</div>
</div>
<br>
<div class="card">
<div class="card header bg-info text-white">
<h2 class="lead">Recent Posts</h2>
</div>
<div class="card-body">
<?php
global $ConnectingDB;
$sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
$stmt = $ConnectingDB->query($sql);
while($DataRows=$stmt->fetch()){
  $Id        = $DataRows['id'];
  $Title     = $DataRows['title'];
  $DateTime  = $DataRows['datetime'];
  $Image     = $DataRows['image'];
?>
<div class="media">
  <img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
  <div class="media-body ml-2">
    <a href="FullPost.php?id=<?php echo htmlentities($Id);?>"> <h6 class="lead"><?php echo htmlentities($Title); ?></h6></a>
    <p class="small"><?php echo htmlentities($DateTime); ?></p>
  </div>
</div>
<hr>
<?php } ?>
</div>
</div>
</div>
</div>
<!-- Side Area End -->
</div>
<!-- HEADER ENDS -->
<br>
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
<button type="button" class="btn btn-link">Link</button>
<script>
$('#year').text(new Date().getFullYear());
</script>
</body>

</html>
