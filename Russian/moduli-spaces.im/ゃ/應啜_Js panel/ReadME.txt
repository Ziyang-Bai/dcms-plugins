        /////////////////////////////////////////////////////
       //////////////�������� ��� � ��//////////////////////
      /////////////////////////////////////////////////////
     ////////////////����� master/////////////////////////
    /////////////////////////////////////////////////////
   /////////////////���� ������ 50�/////////////////////
  /////////////////////////////////////////////////////
 ////////////////���� scriptwm.ru/////////////////////
/////////////////////////////////////////////////////




/////////////////////���������///////////////////////////

1) ��������� ������ :

ALTER TABLE `user` ADD `paneljs` set('0','1') DEFAULT '0' ;


2) ��� ����� c ����� panel ������ � ������ .

3) � ����� � ����� ��� �� ������ ������ ������, � ����� head.php (��� �� � ����� /style/themes/��������_����/heads.php)  �������� ���� ��� :

� �����  
//////////////////////////
if($user['paneljs']==1){
include_once 'panel.php'; 
};
//////////////////////////

 �

����� - <link rel="stylesheet" href="/style/themes/<?echo $set['set_them'];?>/style.css" type="text/css" />
////////////////////////////
<link rel="stylesheet" href="/panell/css/decor_web_def.css" type="text/css" />
<script src="/panell/js/paneljs.js"></script>
	

////////////////////////////////


4) �  ����� settings.php ��������� :


����� - if (isset($_POST['save'])){
////////////////////////////////////
if (isset($_POST['paneljs']) && ($_POST['paneljs']==2 || $_POST['paneljs']==1 || $_POST['paneljs']==0))
{
$user['paneljs']=intval($_POST['paneljs']);
mysql_query("UPDATE `user` SET `paneljs` = '$user[paneljs]' WHERE `id` = '$user[id]' LIMIT 1");
}
else $err='������ ������ ������ ������';
///////////////////////////////////


 � 
 
����� - echo "<form method='post' action='?$passgen'>\n";
//////////////////////////////////
echo "������:<br />\n<select name='paneljs'>\n";
echo "<option value='1'".($user['paneljs']==1?" selected='selected'":null).">���</option>\n";
echo "<option value='0'".($user['paneljs']==0?" selected='selected'":null).">����</option>\n";
echo "</select><br />\n";
/////////////////////////////////




������ ) ������ �������� ^^
���� ���� �������� ������ - ttdris@spaces.ru
