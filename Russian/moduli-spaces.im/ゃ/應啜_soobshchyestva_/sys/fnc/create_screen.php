<?
function create_screen($file, $path, $w=128, $h=128, $dop, $need_name=NULL)
{
if (is_file($file))
{
$movie=@new ffmpeg_movie($file);
if($imgc=@imagecreatefromstring(file_get_contents($file)))
{
$img_x=imagesx($imgc);
$img_y=imagesy($imgc);
if ($img_x==$img_y)
{
$dstW=$w; // ������
$dstH=$h; // ������ 
}
elseif ($img_x>$img_y)
{
$prop=$img_x/$img_y;
$dstW=$w;
$dstH=ceil($dstW/$prop);
}
else
{
$prop=$img_y/$img_x;
$dstH=$h;
$dstW=ceil($dstH/$prop);
}
$screen=imagecreatetruecolor($dstW, $dstH);
imagecopyresampled($screen, $imgc, 0, 0, 0, 0, $dstW, $dstH, $img_x, $img_y);
imagedestroy($imgc);
if ($need_name==NULL)$name = $w."-".$h."_".$dop."screen.png";
else $name = $need_name;
imagepng($screen, $path.$name);
imagedestroy($screen);
}
elseif($movie)
{
$k_frames=$movie->getFrameCount(); //�-��� ������
for($kp=1;$kp<=60;$kp++) //�������� ��������� ����
{
$image=@$movie->getFrame($kp);
if($image)$show_img=$image->toGDImage(); //���� ���� � ���������� ���������, �� �������� ��� ��� ���������� ������
}
if(@$show_img)
{
$imgc=$show_img;
$img_x=imagesx($imgc);
$img_y=imagesy($imgc);
if ($img_x==$img_y)
{
$dstW=$w; // ������
$dstH=$h; // ������ 
}
elseif ($img_x>$img_y)
{
$prop=$img_x/$img_y;
$dstW=$w;
$dstH=ceil($dstW/$prop);
}
else
{
$prop=$img_y/$img_x;
$dstH=$h;
$dstW=ceil($dstH/$prop);
}
$screen=imagecreatetruecolor($dstW, $dstH); // ������� �����������
$black = imagecolorallocate ($screen, 0, 0, 0); // � ������� ��� ������� ����
imagecopyresampled($screen, $imgc, 0, 0, 0, 0, $dstW, $dstH, $img_x, $img_y); // ���������� �� ���� ����
imagedestroy($imgc);
$name = rand(12345,67890)."screen.png";
imagepng($screen, $path.$name);
imagedestroy($screen);
/*
###########################################################################
#	������� ��������� Killer (Special For New DiaryMod)												 #
#	��� 75319624																		 #
#	������� R408800828608																 #
#	(�) Killer																			 #
#	��� ����� ��������. ��� ������ ���������/�������� � �.�. ������ ����� (���� ���� ��� ���� ��� ����, ���� ��� ����...)	 #
###########################################################################
*/
}
}
else $name = NULL;
}
else $name = NULL;
if (!isset($name))$name = NULL;
return $name;
}
?>