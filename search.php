<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                <?php
                include "config.php";
                $search_term = mysqli_real_escape_string($conn,$_GET['search']);
                echo '<h2 class="page-heading">Search : '.$search_term.'</h2>';

                    $page = $_GET['page'] ?? 1;
                    $limit = 6;
                    $offset = ($page - 1) * $limit;
                    $sql = "SELECT post_id, title, description, post_date, category.category_name, users.username, post_img, category, author
                    FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN users ON post.author = users.user_id
                    WHERE title LIKE '%{$search_term}%' 
                    OR description LIKE '%{$search_term}%'
                    ORDER BY post_id DESC LIMIT {$offset},{$limit}";
                    $result = mysqli_query($conn,$sql) or die("Query Failed.");
                    if(mysqli_num_rows($result) > 0 ){
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row['post_id']?>"><img src="admin/upload/<?php echo $row['post_img']?>" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $row['post_id']?>'><?php echo $row['title']?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?cid=<?php echo $row['category']?>'><?php echo $row['category_name']?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?id=<?php echo $row['author']?>'><?php echo $row['username']?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date']?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($row['description'],0,130).'...'?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    }
                    $sql2 = "SELECT * FROM post 
                            WHERE title LIKE '%{$search_term}%'";
                    $result2 = mysqli_query($conn,$sql2) or die("Query Failed.");
                    if(mysqli_num_rows($result2) > 0 ) {
                        $limit = 6;
                        $total_page = ceil((mysqli_num_rows($result2)) / $limit);
                        $page = $_GET['page'] ?? 1;

                        echo "<ul class='pagination'>";
                        if ($page > 1) {
                            echo '<li><a href="search.php?search=' . urlencode($search_term) . '&page=' . ($page - 1) . '">Prev</a></li>';
                        }
                        for ($i = 1; $i <= $total_page; $i++) {
                            $active = ($page == $i) ? "active" : "";
                            echo '<li class="' . $active . '"><a href="search.php?search=' . urlencode($search_term) . '&page=' . $i . '">' . $i . '</a></li>';
                        }
                        if ($page < $total_page) {
                            echo '<li><a href="search.php?search=' . urlencode($search_term) . '&page=' . ($page + 1) . '">Next</a></li>';
                        }
                        
                        echo "</ul>";
                    }
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
