<?php
include_once("../Classes/DB.php");

$refr = $_SERVER['HTTP_REFERER'];
if(substr($refr,strlen($refr)-23) == "/index.php?content=News")
{
	$text = "Neis";
	$fontSize = 35;
}else if(substr($refr,strlen($refr)-27) == "/index.php?content=Ueberuns")
{
	$text = "üba uns";
	$fontSize = 35;
}else if(substr($refr,strlen($refr)-26) == "/index.php?content=Termine")
{
	$text = "Termine";
	$fontSize = 35;
}else if(substr($refr,strlen($refr)-26) == "/index.php?content=Satzung")
{
	$text = "Satzung des Katholischen Burschenvereins Unterneukirchen";
	$fontSize = 20;
}else if(substr($refr,strlen($refr)-26) == "/index.php?content=Kontakt")
{
	$text = "Kontakt";
	$fontSize = 35;
}else if(substr($refr,strlen($refr)-29) == "/index.php?content=Gaestebuch")
{
	$text = "Wea war do?";
	$fontSize = 35;
}else if(substr($refr,strlen($refr)-27) == "/index.php?content=Gallerie")
{
	$text = "Buidl";
	$fontSize = 35;
}else if(substr($refr,strlen($refr)-24) == "/index.php?content=Links")
{
	$text = "Links";
	$fontSize = 35;
}else if(substr($refr,strlen($refr)-28) == "/index.php?content=Impressum")
{
	$text = "Impressum";
	$fontSize = 35;
}else if(substr($refr,strlen($refr)-33) == "/index.php?content=Vorstandschaft")
{
	$text = "Vorstandschaft";
	$fontSize = 35;
}else if(substr($refr,strlen($refr)-29) == "/index.php?content=Mitglieder")
{
    $text = "Mitglieder";
    $fontSize = 35;
}else if(preg_match('/index.php\?content=GallerieDetails\&ID=([0-9]*).*$/',$refr,$pregGallRes))
{

	$sql = "SELECT `Description` FROM `glgroup` WHERE `ID` = " . mysql_escape_string($pregGallRes[1]);
	$res = DB::Query($sql);

	if($row = mysql_fetch_row($res))
	{
		$text = $row[0];
		$fontSize = 30;
	}else
		die();

} else {
    die();
}

$fontFile = "Schwabacher.ttf";

$box = imageTTFBbox($fontSize,0,$fontFile,$text);

$baseline = abs($box[5]);
$height = abs($box[5] - $box[3])+5;
$width = abs($box[2] - $box[0])+5;

$img = imageCreateTruecolor($width,$height);

$bg = imageColorAllocate($img,255,255,255);
$color = imageColorAllocate($img,0,0,0);
$shadowcolor = imageColorAllocate($img,100,100,100);

imagefill($img,0,0,$bg);

imagettftext($img,$fontSize,0,3,$baseline+3,$shadowcolor,$fontFile,$text);

for($i = 0; $i<5; $i++)
	imagefilter($img,IMG_FILTER_GAUSSIAN_BLUR);

imagettftext($img,$fontSize,0,0,$baseline,$color,$fontFile,$text);

header("Content-type: image/png");
imagepng($img);

imagedestroy($img);

?>
