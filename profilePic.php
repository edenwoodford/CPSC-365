//profilePic.php
<?php
require 'dbconnect.php';
dbConnect();
session_start();
if (isset($_FILES['upload'])) {
	$user_id = $_SESSION['user_id'];
	if ($_FILES ['upload']['error']  != UPLOAD_ERR_OK)
	{
		echo 'error uploading file';
		exit();
	}
	$finfo = new finfo (FILEINFO_MIME_TYPE);
	$ftype = $finfo->file ($_FILES['upload']['tmp_name']);
	if ($ftype != "image/jpeg")
	{
			echo 'error invalid file type';
			exit();
	}
	else {
        $upload_dir = 'uploads/';
        $filename = $upload_dir . $user_id . '.jpeg';
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $filename)) {
            echo 'File uploaded successfully';
        } else {
            echo 'Error moving uploaded file';
            exit();
        }
	$image = imagecreatefromjpeg ($filename);
	$width = imagesx ($image);
	$height = imagesy ($image);
	$targetWidth = 150;
	$targetHeight = floor ($height * ($targetWidth/$width));
	
	$thumbnail = imagecreatetruecolor ($targetWidth, $targetHeight);
	imagecopyresampled ($thumbnail, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
	$profilePicName = $upload_dir . $user_id . "_profile.jpeg";
	imagejpeg ($thumbnail, $profilePicName);
	header("Location: profile.php");
    }
}

?>