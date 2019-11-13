<?php
/*
define('UPLOAD_DIR', 'images/');
$image_parts = explode(";base64,", $_POST['data_uri']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file = UPLOAD_DIR . uniqid() . '.png';
file_put_contents($file, $image_base64);
*/





/*
define('UPLOAD_DIR', 'images/');

$image_parts = explode(",", $_POST['base64ImageContent']);
$base64_part = $image_parts[1];

$bin = base64_decode($base64_part);
$size = getImageSizeFromString($bin);

if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
  die('Base64 value is not a valid image');
}

$ext = substr($size['mime'], 6);
if (!in_array($ext, ['png', 'gif', 'jpeg'])) {
  die('Unsupported image type');
}

$image_file_name = uniqid() . ".{$ext}";
file_put_contents(UPLOAD_DIR . $image_file_name, $bin);

// echo $image_file_name;
*/





/*
$location = UPLOAD_DIR . $image_file_name;
$data = getimagesize($location);
$width = $data[0];
$height = $data[1];

if ($height > $width) {
  $sq = $width;
  $x = 0;
  $y = ($height - $width)/2;
} else {
  $sq = $height;
  $y = 0;
  $x = ($width - $height)/2;
}

$im = imagecreatefromjpeg($location);
$im2 = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $sq, 'height' => $sq]);
if ($im2 != FALSE) {
  imagejpeg($im2, $location); // image cropped

  list($width, $height) = getimagesize($location);
  $newwidth = 300;
  $newheight = 300;
  $destination = imagecreatetruecolor($newwidth, $newheight);
  $source = imagecreatefromjpeg($location);
  imagecopyresampled($destination,$source, 0, 0, 0, 0, $newwidth,$newheight, $width,$height);
  header("Content-Type: image/jpeg");
  imagejpeg($destination, $location, 90); // image resized
}
*/




// $location = 'twitter_png.png';
$location = 'twitter_jpg.jpg';
$mime_content_type = mime_content_type($location); // image/png or image/jpeg
$extension = substr($mime_content_type, 6);

switch ($extension) {
  case "png":
    pngResize($location);
    break;
  case "jpeg":
    jpgReize($location);
    break;
  default:
    echo "File Type Not Supported";
}

function pngResize($location) {
  $data = getimagesize($location);
  $width = $data[0];
  $height = $data[1];

  if ($height > $width) {
    $sq = $width;
    $x = 0;
    $y = ($height - $width)/2;
  } else {
    $sq = $height;
    $y = 0;
    $x = ($width - $height)/2;
  }

  $im = imagecreatefrompng($location);
  $im2 = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $sq, 'height' => $sq]);
  if ($im2 !== FALSE) {
    imagepng($im2, $location); // image cropped

    list($width, $height) = getimagesize($location);
    $newwidth = 300;
    $newheight = 300;
    $source = imagecreatefrompng($location);
    $destination = imagecreatetruecolor($newwidth, $newheight);
    imagealphablending($destination, false);
    imagesavealpha($destination,true);
    $transparency = imagecolorallocatealpha($destination, 255, 255, 255, 127);
    imagefilledrectangle($destination, 0, 0, $newwidth, $newheight, $transparency);
    imagecopyresampled($destination,$source, 0, 0, 0, 0, $newwidth, $newheight, $width,$height);
    header("Content-Type: image/png");
    imagepng($destination, $location); // image resized
  }
}

function jpgReize($location) {
  $data = getimagesize($location);
  $width = $data[0];
  $height = $data[1];

  if ($height > $width) {
    $sq = $width;
    $x = 0;
    $y = ($height - $width)/2;
  } else {
    $sq = $height;
    $y = 0;
    $x = ($width - $height)/2;
  }

  $im = imagecreatefromjpeg($location);
  $im2 = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $sq, 'height' => $sq]);
  if ($im2 !== FALSE) {
    imagejpeg($im2, $location); // image cropped

    list($width, $height) = getimagesize($location);
    $newwidth = 300;
    $newheight = 300;
    $destination = imagecreatetruecolor($newwidth, $newheight);
    $source = imagecreatefromjpeg($location);
    imagecopyresampled($destination,$source, 0, 0, 0, 0, $newwidth,$newheight, $width,$height);
    header("Content-Type: image/jpeg");
    imagejpeg($destination, $location, 90); // image resized
  }
}
