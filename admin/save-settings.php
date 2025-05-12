<?php
include "config.php";
session_start();
if(empty($_FILES['logo']['name'])){
    $file_name = $_POST['old_logo'];
} else {
    $errors = array();
    $file_name = $_FILES['logo']['name'];
    $file_size = $_FILES['nlogo']['size'];
    $tmp_name = $_FILES['logo']['tmp_name'];
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
        move_uploaded_file($tmp_name,"images/".$file_name);
    }else {
        print_r($errors);
        die();
    }
}

$web_name = mysqli_real_escape_string($conn, $_POST['website_name'] ?? '');
$footer_desc = mysqli_real_escape_string($conn, $_POST['footer_desc'] ?? '');

$sql = "UPDATE settings SET website_name = '$web_name', logo = '$file_name', footer_desc = '$footer_desc'";
if (mysqli_query($conn, $sql)) {
    header("Location: {$hostname}/admin/settings.php");
    exit;
} else {
    die("Query Failed");
}
?>