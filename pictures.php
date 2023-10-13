Using Images in PHP 10/11/23
NOT recommended to use BLOB
store images in the file system -> name of the image
USE the movie_id as the naming system for each poster
google up mime types -> we are looking for image.png
we have to verify the information the browser is giving us
limit it to png or jpeg
feel free to limit it to one image type
Movie Page, movie posters must be 250 pixels wide
user uploads, a movie poster 750 pixels wide by 1000 pixels high
<?php
if (isset($_POST['upload'])) {
	//var_dump($_FILES['upload']);
	//we are using movie_id to name the images
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
	$image = imagecreatefromjpeg ($filename);
	$width = imagesx ($image);
	$height = imagesy ($image);
	$targetWidth = 250;
	$targetHeight = floor ($height * (targetWidth/$width));
	
	$thumbnail = imagecreatetruecolor ($targetWidth, $targetHeight);
	imagecopyresampled ($thumbnail, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
	imagejpeg ($thumbnail, "movieposter.jpg");

}
?>
<form method="POST" enctype="multipart/form-data">
Name of file: <input type="text" name="name"> <br>
<input type="file" name="upload">
<input type="submit">
</form>
