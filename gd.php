<?php 


$target_path = "uploads/";
$thickness = $_POST['thickness'];
$color = $_POST['color'];
$filename= basename($_FILES['uploadedfile']['name']);

$target_path = $target_path . $filename; 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    //echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    " has been uploaded";
} else{
	header('Content-type: text/html'); 
	echo "Error code: ";
	echo $_FILES['uploadedfile']['error'];
}

$ext =  strtolower(pathinfo($target_path, PATHINFO_EXTENSION));

switch($ext){
	case "png":
		$img = ImageCreateFromPNG($target_path); 
		header('Content-type: image/png'); 
		break;
	case "jpg":
		$img = ImageCreateFromJPEG($target_path);
		header('Content-type: image/jpeg'); 
		break;
	case "jpeg":
		$img = ImageCreateFromJPEG($target_path); 
		header('Content-type: image/jpeg'); 
		break;
}


$color_red = hexdec(substr($color,0,2));
$color_green = hexdec(substr($color,2,2));
$color_blue = hexdec(substr($color,4,2));

// Draw border 
$color_user = ImageColorAllocate($img, $color_red, $color_green, $color_blue); 
drawBorder($img, $color_user, $thickness); 

//filename
header('Content-Disposition: inline; filename='.'"'.$filename.'"');


// Output 
switch($ext){
	case "png":
		ImagePNG($img); 
		break;
	case "jpg":
		ImageJPEG($img); 
		break;
	case "jpeg":
		ImageJPEG($img); 
		break;
}


//delete file no longer needed
unlink($target_path);

// Draw a border 
function drawBorder(&$img, &$color, $thickness = 1) 
{ 
    $x1 = 0; 
    $y1 = 0; 
    $x2 = ImageSX($img) - 1; 
    $y2 = ImageSY($img) - 1; 

    for($i = 0; $i < $thickness; $i++) 
    { 
        ImageRectangle($img, $x1++, $y1++, $x2--, $y2--, $color); 
    } 
} 

?>