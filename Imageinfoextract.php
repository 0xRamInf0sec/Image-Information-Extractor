<html>
<head>
<title>Meta Data Extractor</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style>
.jumbotron {
 background-color:transparent;
  margin: 5px auto;
  height:500px;
  justify-content: center;
padding:0;
}

.bg-cover {
    background-attachment: static;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
input[type=submit] {
  background-color:#f4253e;
  color: white;
  position: 10px 100 px;
  padding: 6px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: center;
}
.text-line {
    background-color: transparent;
    color:solid #000000;
    outline: none;
    outline-style: none;
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom: solid #000000 1px;
    padding: 3px 10px;
}
.text-line:focus
{
	    background-color: transparent;
}
</style>
<body >
<div class="jumbotron bg-cover" style="width:50%;">
<div style='background-color:#436cee;padding:30px;text-align:center'>
  <h3 style='color:white'>Image Meta data Extractor</h3>
  <h5 style="float:right;color:white">by Ramalingasamy M K</h5>
  </div>
  <br>
<form action="" method="POST" enctype="multipart/form-data">

<div class="form-group">
<label for="image"><b>Your Image File</b></label>
<input type="file" name="image"  >
</div>
<div class="form-group">
<input type="submit" value="Extract Information" >
</div>
</form>
<div>
<?php

	if(isset($_FILES['image']))
	{
$imageurl=$_FILES['image']['tmp_name'];
$name=$_FILES['image']['name'];
$imageext=strtolower(pathinfo($name,PATHINFO_EXTENSION));
$ext=array("jpeg","jpg","png");
if(in_array($imageext,$ext)===false)
{
	echo "<h5>extension not allowed, please choose a JPEG or PNG file.</h5>";
}
else
{
$exif= exif_read_data($imageurl,'EXIF');
		// print_r($exif);
		if(!isset($exif['MimeType'])|| !isset($exif['COMPUTED']['Height']) || !isset($exif['COMPUTED']['Width']) || !$exif['Model'] || !$exif['Software'])
          {
        echo "<p><b>UNFORTUNATELY , No DATA FOUND</b></p>";
         }
		 else
		 {
		 echo '<p><b>Image Type : </b> '.$exif['MimeType'].'</p>';
		 echo '<p><b>Height : </b> '.$exif['COMPUTED']['Height'].'</p>';
		  echo '<p><b>Width : </b> '.$exif['COMPUTED']['Width'].'</p>';
		  echo '<p><b>Device Name : </b> '.$exif['Model'].'</p>';
		  echo '<p><b>Software : </b> '.$exif['Software'].'</p>';
		  
		  echo '<p><b>Date and Time : </b> '.$exif['DateTime'].'</p>';
		 }
		  if(!isset($exif['GPSLatitude']))
          {
        echo "<p><b>UNFORTUNATELY , No GPS DATA FOUND</b></p>";
         }
	 else
	 {
          $lat_ref = $exif['GPSLatitudeRef'];
          $lat = $exif['GPSLatitude']; 
          list($num, $dec) = explode('/', $lat[0]); 
          $lat_s = $num / $dec;
          list($num, $dec) = explode('/', $lat[1]); 
          $lat_m = $num / $dec;
          list($num, $dec) = explode('/', $lat[2]); 
          $lat_v = $num / $dec;
          $lon_ref = $exif['GPSLongitudeRef'];
          $lon = $exif['GPSLongitude']; 
          list($num, $dec) = explode('/', $lon[0]); 
          $lon_s = $num / $dec;
          list($num, $dec) = explode('/', $lon[1]); 
          $lon_m = $num / $dec;
          list($num, $dec) = explode('/', $lon[2]); 
          $lon_v = $num / $dec;
          $gps_int = array($lat_s + $lat_m / 60.0 + $lat_v / 3600.0, $lon_s
                     + $lon_m / 60.0 + $lon_v / 3600.0);
         // print_r($gps_int);
		 echo '<p><b>Location Found </b></p>';
		 $link="http://www.google.com/maps/place/".$gps_int[0].",".$gps_int[1]."/@".$gps_int[0].",".$gps_int[1].",17z/data=!3m1!1e3";
		 echo "<a href=".$link." target='_blank'><b>Tap to locate Where the image was taken</b></a>";
	 }
	}
	}
?>
</div>
</body>
</html>