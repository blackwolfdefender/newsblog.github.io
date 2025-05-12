<?php include "header.php"; 
include "config.php";
if($_SESSION['role'] == 0) {
    header("location: {$hostname}/admin/post.php");
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">Settings</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
              <?php
                include "config.php";
                $sql = "SELECT * FROM settings";
                $result = mysqli_query($conn,$sql) or die("Query Failed");
                if(mysqli_num_rows($result) > 0) { 
                    while($row = mysqli_fetch_assoc($result)){
              ?>
              <form  action="save-settings.php" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="website_name">Website Name</label>
                          <input type="text" name="website_name" class="form-control" autocomplete="off" value="<?php echo $row['website_name']?>">
                      </div>
                      <div class="form-group">
                        <label for="logo">Website Logo</label>
                        <input type="file" name="logo">
                        <img src="images/<?php echo $row['logo']?>" height="150px">
                        <input type="hidden" name="old_logo" value="<?php echo $row['logo']; ?>">
                      </div>
                      <div class="form-group">
                        <label for="footer_desc">Footer Description</label>
                        <textarea name="footer_desc" class="form-control" id="" cols="30" rows="5"><?php echo $row['footer_desc']?></textarea>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Submit">
              </form>
              <?php
              }
            }
            ?>
              </div>
          </div>
      </div>
  </div>