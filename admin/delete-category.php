<?php
include "config.php";
if($_SESSION['role'] == 0) {
    header("location: {$hostname}/admin/post.php");
}
$cat_id = $_GET['id'];
$sql = "DELETE FROM category WHERE category_id = {$cat_id}";
if(mysqli_query($conn,$sql)){
    header("location: {$hostname}/admin/category.php");
} else {
    echo "Query Failed";
}
?>