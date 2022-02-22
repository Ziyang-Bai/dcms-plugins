<?
require '../sys/inc/start.php';
require '../sys/inc/compress.php';
require '../sys/inc/sess.php';
require '../sys/inc/home.php';
require '../sys/inc/settings.php';
require '../sys/inc/db_connect.php';
require '../sys/inc/ipua.php';
require '../sys/inc/fnc.php';
require '../sys/inc/adm_check.php';
require '../sys/inc/user.php';
user_access('adm_ban_ip',null,'index.php?'.SID);

$opsos=NULL;
$set['title']='Бан по IP';
require '../sys/inc/thead.php';
title();



if (isset($_POST['min']) && isset($_POST['max']))
{
if (!preg_match("#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#",$_POST['min']))$err[]='Неверный формат IP-адреса';
if (!preg_match("#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#",$_POST['max']))$err[]='Неверный формат IP-адреса';

$min=ip2long($_POST['min']);
$max=ip2long($_POST['max']);

if (ip2long($ip)>=$min && ip2long($ip)<=$max)
{
$err[]='Ваш IP входит в заданный диапазон';
}
elseif (!isset($err))
{
mysql_query("INSERT INTO `ban_ip` (`min`, `max`) values('$min', '$max')",$db);
msg ('Диапазон успешно забанен');
}
}




if (isset($_GET['delmin'])  && isset($_GET['delmax']) &&
 mysql_result(mysql_query("SELECT COUNT(*) FROM `ban_ip` WHERE `min` = '".mysql_real_escape_string($_GET['delmin'])."' AND `max` = '".mysql_real_escape_string($_GET['delmax'])."' LIMIT 1",$db), 0)!=0)
{
mysql_query("DELETE FROM `ban_ip` WHERE `min` = '".mysql_real_escape_string($_GET['delmin'])."' AND `max` = '".mysql_real_escape_string($_GET['delmax'])."' LIMIT 1");
mysql_query("OPTIMIZE TABLE `ban_ip`");
msg('Диапазон успешно удален');
}



err();

$k_post=mysql_result(mysql_query("SELECT COUNT(*) FROM `ban_ip`"),0);
$k_page=k_page($k_post,$set['p_str']);
$page=page($k_page);
$start=$set['p_str']*$page-$set['p_str'];
$q=mysql_query("SELECT * FROM `ban_ip` LIMIT $start, $set[p_str]");
echo "<table class='post'>\n";
if ($k_post==0)
{
echo "   <tr>\n";
echo "  <td class='p_t'>\n";
echo "Нет забаненых IP\n";
echo "  </td>\n";
echo "   </tr>\n";

}
while ($post = mysql_fetch_assoc($q))
{
echo "   <tr>\n";
echo "  <td class='p_t'>\n";
echo long2ip($post['min']).' - '.long2ip($post['max']);
echo "  </td>\n";
echo "   </tr>\n";
echo "   <tr>\n";
echo "  <td class='p_m'>\n";
echo "<a href='?page=$page&amp;delmin=$post[min]&amp;delmax=$post[max]'>Удалить</a><br />\n";
echo "  </td>\n";
echo "   </tr>\n";
}
echo "</table>\n";
if ($k_page>1)str('?',$k_page,$page); // Вывод страниц



$min=NULL;$max=NULL;
if (isset($_GET['min']) && preg_match("#^([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})$#",long2ip($_GET['min'])))
{
echo "HOST: ".gethostbyaddr(long2ip($_GET['min']))."<br />\n";
$min=long2ip($_GET['min']);$max=long2ip($_GET['min']);
if (isset($_GET['max']) && preg_match("#^([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})$#",long2ip($_GET['max'])))$max=long2ip($_GET['max']);
}

echo "<form method='post' action='?ban=$passgen'>\n";
echo "Начало:<br />\n<input name='min' size='16'  value='$min' type='text' /><br />\n";
echo "Конец:<br />\n<input name='max' size='16' value='$max' type='text' /><br />\n";
echo "<input value='Забанить' type='submit' />\n";
echo "</form>\n";



if (user_access('adm_panel_show')){
echo "<div class='fyt'>\n";
echo "&laquo;<a href='/adm_panel/'>В админку</a><br />\n";
echo "</div>\n";
}
require '../sys/inc/tfoot.php';
?>