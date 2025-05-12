<?php
include "config.php";
session_start();
if(isset($_FILES['fileToUpload'])){
    $errors = array();
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $extensions = array(
        "jpg", "jpeg", "png", "gif",   // Most common web formats
        "bmp",                         // Bitmap
        "webp",                        // Modern web format by Google
        "svg",                         // Scalable Vector Graphics
        "tiff", "tif",                 // High-quality images (often used in publishing)
        "ico",                         // Icons (favicons)
        "heic",                        // iPhone/iOS high efficiency image format
        "avif"                         // Modern image format (smaller, better than WebP in some cases)
    );

    if(in_array($file_ext,$extensions) == false) {
        $errors[] = "Invalid file format please choose PNG or JPG file only";
    }
    if($file_size > 2097512){
        $errors[] = "File size must be 2mb or lower";
    }
    if(empty($errors)){
        $new_name = date("d-M-y") . "-" . $file_name;
        $target = "upload/" . $new_name;
        move_uploaded_file($tmp_name,$target);
    }else {
        print_r($errors);
        die();
    }
}
$title = mysqli_real_escape_string($conn,$_POST['post_title']);
$desc = mysqli_real_escape_string($conn,$_POST['postdesc']);
$cat = mysqli_real_escape_string($conn,$_POST['category']);
$date = date("d M, Y");
$author = $_SESSION['user_id'];

$sql = "INSERT INTO post (title, description, category, post_date, author, post_img)
        VALUES ('{$title}','{$desc}','{$cat}','{$date}','{$author}','{$new_name}');";
$sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$cat}";
if(mysqli_multi_query($conn, $sql)){
    header("location: {$hostname}/admin/post.php");
}else {
    die("Query Failed");
    exit;
}
?>