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
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <?php
              include "config.php";
              $page = $_GET['page'] ?? 1;
              $limit = 4;
              $offset = ($page - 1) * $limit;
              $sql = "SELECT * FROM users ORDER BY user_id DESC LIMIT {$offset},{$limit}";
              $result = mysqli_query($conn,$sql) or die("Query Failed");
              if(mysqli_num_rows($result) > 0) { 
              ?>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                        $serial = $offset + 1; 
                        while($row = mysqli_fetch_assoc($result)){ ?>
                          <tr>
                              <td class='id'><?php echo $serial?></td>
                              <td><?php echo $row['first_name'] . ' ' . $row['last_name']?></td>
                              <td><?php echo $row['username']?></td>
                              <td>
                                <?php
                                if($row['role'] == 1) {
                                    echo "Admin";
                                } else {
                                    echo "Normal user";
                                }
                                    ?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $row['user_id']?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-user.php?id=<?php echo $row['user_id']?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php
                          $serial ++; 
                        } 
                        ?>
                      </tbody>
                  </table>
                  <?php
                  $sql1 = "SELECT * FROM users";
                  $result1 = mysqli_query($conn,$sql1) or die("Query Failed");
                  if(mysqli_num_rows($result) > 0) {
                    $limit = 4;
                    $total_page = ceil((mysqli_num_rows($result1) / $limit));
                    $page = $_GET['page'] ?? 1;
                    echo "<ul class='pagination admin-pagination'>";
                    if($page < $total_page){
                        echo '<li><a href="users.php?page='.($page + 1).'">Next</a></li>'; 
                    }
                    for($p=1;$p <= $total_page;$p++){
                        $active = $page == $p ? "active" : "";
                        echo '<li class='.$active.'><a href="users.php?page='.$p.'">'.$p.'</a></li>';
                    }
                    if ($page > 1) {
                        echo '<li><a href="users.php?page=' . ($page - 1) . '">Prev</a></li>';
                    }
                    echo "</ul>";
                  }
              }
              ?>               
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
