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
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <?php
              include "config.php";
              $page = $_GET['page'] ?? 1;
              $limit = 4;
              $offset = ($page - 1) * $limit;
              $sql = "SELECT * FROM category ORDER BY category_id DESC LIMIT {$offset},{$limit}";
              $result = mysqli_query($conn,$sql) or die("Query Failed");
              if(mysqli_num_rows($result) > 0) { 
              ?>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                    <?php
                    $serial = $offset + 1; 
                    while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td class='id'><?php echo $serial?></td>
                            <td><?php echo $row['category_name']?></td>
                            <td><?php echo $row['post']?></td>
                            <td class='edit'><a href='update-category.php?id=<?php echo $row['category_id']?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $row['category_id']?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        <?php
                          $serial ++; 
                          }
                           ?>
                    </tbody>
                </table>
                <?php
                  $sql1 = "SELECT * FROM category";
                  $result1 = mysqli_query($conn,$sql1) or die("Query Failed");
                  if(mysqli_num_rows($result) > 0) {
                    $limit = 4;
                    $total_page = ceil((mysqli_num_rows($result1) / $limit));
                    $page = $_GET['page'] ?? 1;
                    echo "<ul class='pagination admin-pagination'>";
                    if($page < $total_page){
                        echo '<li><a href="category.php?page='.($page + 1).'">Next</a></li>'; 
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        $result = $page == $i ? "active" : ""; // Check if current page matches
                        echo '<li class="' . $result . '"><a href="category.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                    if ($page > 1) {
                        echo '<li><a href="category.php?page=' . ($page - 1) . '">Prev</a></li>';
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
