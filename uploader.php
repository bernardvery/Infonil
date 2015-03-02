<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Ple-Q" />

	<title>File Uploader</title>
</head>
<body>

<?
include("koneksi.php");
if(isset($_FILES["uploadedfile"])){
$target_path = $_SERVER['DOCUMENT_ROOT'] . "/info/";

$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    " has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}
}
?>

<form enctype="multipart/form-data" action="" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
<input name="uploadedfile" type="file" /><input type="submit" value="Upload" />
</form>
<p>
<font size="1">&copy;2011 Bernard Very.</font>
</p>
<a href="http://in.bernard-very.com/">Back to in.bernard-very.com ...</a>
</body>
</html>