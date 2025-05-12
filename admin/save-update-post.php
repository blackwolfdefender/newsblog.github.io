<?php
include "config.php";
session_start();
if(empty($_FILES['new-image']['name'])){
    $new_name = $_POST['old_image'];
} else {
    $errors = array();
    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $tmp_name = $_FILES['new-image']['tmp_name'];
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
$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn,$_POST['category']);
$post_id = mysqli_real_escape_string($conn,$_POST['post_id']);

$sql = "UPDATE post SET title = '$title', description = '$desc',
        category = '$category', post_img = '$new_name'
        WHERE post_id = $post_id";

if(mysqli_query($conn, $sql)){
    header("location: {$hostname}/admin/post.php");
}else {
    die("Query Failed");
    exit;
}


?>