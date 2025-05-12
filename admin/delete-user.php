<?php
include "config.php";
if($_SESSION['role'] == 0) {
    header("location: {$hostname}/admin/post.php");
}
$user_id = $_GET['id'];
$sql = "DELETE FROM users WHERE user_id = {$user_id}";
if(mysqli_query($conn,$sql)){
    header("location: {$hostname}/admin/users.php");
} else {
    echo "Query Failed";
}
?>