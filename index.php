<?php

echo '
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

<h4>Image cropper</h4>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="imageSource" value="">
    <input type="submit" name="submit" value="Upload">
</form>

</body>
</html>
';

$originalimagepath = $thumbimagepath = $inputName = "";
$uploadExtention = array('jpg', 'jpeg', 'png');

$originalimagepath = 'upload/original/';
$thumbimagepath = 'upload/croped/';
$inputName = 'imageSource';

if ((isset($_POST['submit'])) && ($_SERVER['REQUEST_METHOD'] === "POST") && ($_FILES[$inputName]['name']) != "") {

    $newImage = imageCropper($inputName, $originalimagepath, $thumbimagepath, 280, 200);
    echo '<img src="' . $newImage . '">';

} else if ((isset($_POST['submit'])) && ($_FILES[$inputName]['name'] == "")) {
    echo "Select a image first";
}


function imageCropper($inputName, $originalimagepath = "", $cropimagepath = "", $newheight = " ", $newwidth = "")
{

    $imagetype = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
    global $uploadExtention;

    if (in_array($imagetype, $uploadExtention)) {

        if ($imagetype == "jpg" || $imagetype == "jpeg") {
            move_uploaded_file($_FILES[$inputName]['tmp_name'], $originalimagepath . $_FILES[$inputName]['name']);
            $filename = $originalimagepath . $_FILES[$inputName]['name'];
            list($width, $height) = getimagesize($filename);
            $newfile = imagecreatefromjpeg($filename);
            $thumb = $cropimagepath . time() . $_FILES[$inputName]['name'];
            $truecolor = imagecreatetruecolor($newheight, $newwidth);
            imagecopyresampled($truecolor, $newfile, 0, 0, 0, 0, $newheight, $newwidth, $width, $height);
            imagejpeg($truecolor, $thumb, 100);
            return $thumb;

        } else if ($imagetype == "png") {
            move_uploaded_file($_FILES[$inputName]['tmp_name'], $originalimagepath . $_FILES[$inputName]['name']);
            $filename = $originalimagepath . $_FILES[$inputName]['name'];
            list($width, $height) = getimagesize($filename);
            $newfile = imagecreatefrompng($filename);
            $thumb = $cropimagepath . time() . $_FILES[$inputName]['name'];
            $truecolor = imagecreatetruecolor($newheight, $newwidth);
            imagecopyresampled($truecolor, $newfile, 0, 0, 0, 0, $newheight, $newwidth, $width, $height);
            imagepng($truecolor, $thumb, 9);
            return $thumb;

        } else if ($imagetype == "gif") {
            echo "Format not Supported !";
        } else if ($imagetype == "bmp") {
            echo "Format not Supported !";
        }
    }

}


?>