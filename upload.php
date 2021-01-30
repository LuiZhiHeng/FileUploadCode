<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadok = 1;
$imgFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// create folder if file not exist
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if(($check = getimagesize($_FILES["fileToUpload"]["tmp_name"])) !== false) {
        echo "File is an image - " . $check["mime"] . "."; //show file type
        $uploadok = 1;
    } else {
        echo "File is not an image.";
        $uploadok = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadok = 0;
    /* change file name by add one
    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $temp[0] .= 1;
    $target_file = $target_dir . $temp[0] . "." . $temp[1];
    */
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) { //500KB
    echo "Sorry, your file is too large.";
    $uploadok = 0;
}

// Allow certain file formats
if($imgFileType != "jpg" && $imgFileType != "png" && $imgFileType != "jpeg" && $imgFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadok = 0;
}

// Check if $uploadok is set to 0 by an error
if ($uploadok == 0) {
    echo "Sorry, your file was not uploaded.";
} else { // if everything is ok, try to upload file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
       echo "Sorry, there was an error uploading your file.";
    }
}
?>