����������� ��������������
����� alex-borisi (��������)
ICQ 587863132

���������:

����������� � ������

������ ������� (������� �� ������ ��� ����/foto/install.php ���� � ������..)

� info.php ���������

if ($user['id']==$ank['id']){
echo '<div class="p_t">';
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `gallery_rating` WHERE `avtor` = '$ank[id]' AND `ready` = '1'"),0)!=0){
echo "<a href='/foto/ocenky.php?id=$ank[id]'><font color='red'>������ +" . mysql_result(mysql_query("SELECT COUNT(*) FROM `gallery_rating` WHERE `avtor` = '$ank[id]' AND `ready` = '1'"),0) . "</font></a><br />\n";
}else{
echo "<a href='/foto/ocenky.php?id=$ank[id]'>������</a><br />\n";
}
echo '</div>';
} // ������ �� ������



//��� ���� ��� � ��� ������ �� �����)

$c2=mysql_result(mysql_query("SELECT COUNT(*) FROM `ocenky` WHERE `id_user` = '$user[id]' AND `time` > '$time'"), 0);
echo "&rarr; <a href='/user/money/plus5.php'>������</a> <img src='/style/icons/6.png' alt='*'> " . ($c2==0?'<span class="off">[���������]</span> ':'<span class="on">[��������]</span>')."";
