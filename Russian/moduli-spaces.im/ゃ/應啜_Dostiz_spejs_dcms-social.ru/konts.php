<?
/*
Сделано © alex-borisi
Все права защищены
http://nasimbe.ru
*/
include_once 'sys/inc/start.php';
include_once 'sys/inc/compress.php';
include_once 'sys/inc/sess.php';
include_once 'sys/inc/home.php';
include_once 'sys/inc/settings.php';
include_once 'sys/inc/db_connect.php';
include_once 'sys/inc/ipua.php';
include_once 'sys/inc/fnc.php';
include_once 'sys/inc/user.php';
only_reg(); 



switch (@$_GET['type']) {
case 'favorite':
$type='favorite';
$type_name='Избранные';
break;
case 'ignor':
$type='ignor';
$type_name='Игнорируемые';
break;
case 'deleted':
$type='deleted';
$type_name='Корзина';
break;
default:
$type='common';
$type_name='Активные';
break;
}


$set['title']=$type_name.' контакты';
include_once 'sys/inc/thead.php';
title();




if (isset($_GET['id']))
{
$ank=get_user($_GET['id']);
if ($ank)
{
if (isset($_GET['act']))
{
switch ($_GET['act']) {
case 'add':
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `id_kont` = '$ank[id]'"), 0) == 1)
$err[]='Этот пользователь уже есть в вашем списке контактов';
else
{
mysql_query("INSERT INTO `users_konts` (`id_user`, `id_kont`, `time`) VALUES ('$user[id]', '$ank[id]', '$time')");
$_SESSION['message'] = 'Контакт успешно добавлен';
header("Location: ?");
exit;
}

break;
case 'del':
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `id_kont` = '$ank[id]'"), 0) == 0)
$warn[]='Этого пользователя нет в вашем списке контактов';
else
{
mysql_query("UPDATE `users_konts` SET `type` = 'deleted', `time` = '$time' WHERE `id_user` = '$user[id]' AND `id_kont` = '$ank[id]' LIMIT 1");
$_SESSION['message'] = 'Контакт перенесен в корзину';
header("Location: ?");
exit;
$type='deleted';
}
break;
}
}
}
else
$err[]='Пользователь не найден';
}

if (isset($_GET['act']) && $_GET['act'] == 'edit_ok' && isset($_GET['id']) && mysql_result(mysql_query("SELECT COUNT(*) FROM `user` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"),0) == 1)
{
$ank=get_user(intval($_GET['id']));
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `id_kont` = '$ank[id]'"), 0) == 1)
{
$kont=mysql_fetch_array(mysql_query("SELECT * FROM `users_konts` WHERE `id_user` = '$user[id]' AND `id_kont` = '$ank[id]'"));
if (isset($_POST['name']) && $_POST['name']!=($kont['name']!=null?$kont['name']:$ank['nick']))
{
if (preg_match('#[^A-z0-9\-_\.,\[\]\(\) ]#i', $_POST['name']))$err[]='В названии контакта присутствуют запрещенные символы';
if (strlen($_POST['name'])>64)$err[]='Название контакта длиннее 64-х символов';

if (!isset($err))
{
mysql_query("UPDATE `users_konts` SET `name` = '".mysql_real_escape_string(htmlspecialchars($_POST['name']))."' WHERE `id_user` = '$user[id]' AND `id_kont` = '$ank[id]' LIMIT 1");
$_SESSION['message'] = 'Контакт успешно переименован';
header("Location: ?");
exit;
}
}

if (isset($_POST['type']) && preg_match('#^(common|ignor|favorite|deleted)$#',$_POST['type']) && $_POST['type']!=$type)
{
mysql_query("UPDATE `users_konts` SET `type` = '$_POST[type]', `time` = '$time' WHERE `id_user` = '$user[id]' AND `id_kont` = '$ank[id]' LIMIT 1");
$_SESSION['message'] = 'Контакт успешно перенесен';
header("Location: ?");
exit;
}

}
else
$err[]='Контакт не найден';
}

aut();


/*========================================Отмеченные========================================*/
foreach ($_POST as $key => $value)
{
if (preg_match('#^post_([0-9]*)$#',$key,$postnum) && $value='1')
{
$delpost[] = $postnum[1];
}
}
// игнор 
if (isset($_POST['ignor']))
{
if (isset($delpost) && is_array($delpost))
{
echo '<div class="mess">Контакт(ы): ';

for ($q=0; $q<=count($delpost)-1; $q++) {
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `id_kont` = '$delpost[$q]'"), 0) == 0)
$warn[]='Этого пользователя нет в вашем списке контактов';
else
{
mysql_query("UPDATE `users_konts` SET `type` = 'ignor', `time` = '$time' WHERE `id_user` = '$user[id]' AND `id_kont` = '$delpost[$q]' LIMIT 1");
}
$ank_del = get_user($delpost[$q]);
echo '<font color="#395aff"><b>' . $ank_del['nick'] . '</b></font>, ';
}

echo ' добавлен(ы) в черный список</div>';
}else{
$err[] = 'Не выделено ни одного контакта';
}
}
// активные 
if (isset($_POST['common']))
{
if (isset($delpost) && is_array($delpost))
{
echo '<div class="mess">Контакт(ы): ';

for ($q=0; $q<=count($delpost)-1; $q++) {
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `id_kont` = '$delpost[$q]'"), 0) == 0)
$warn[]='Этого пользователя нет в вашем списке контактов';
else
{
mysql_query("UPDATE `users_konts` SET `type` = 'common', `time` = '$time' WHERE `id_user` = '$user[id]' AND `id_kont` = '$delpost[$q]' LIMIT 1");
}
$ank_del = get_user($delpost[$q]);
echo '<font color="#395aff"><b>' . $ank_del['nick'] . '</b></font>, ';
}

echo ' успешно перенесен(ы) в активные контакты</div>';
}else{
$err[] = 'Не выделено ни одного контакта';
}
}
// избранное
if (isset($_POST['favorite']))
{
if (isset($delpost) && is_array($delpost))
{
echo '<div class="mess">Контакт(ы): ';

for ($q=0; $q<=count($delpost)-1; $q++) {
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `id_kont` = '$delpost[$q]'"), 0) == 0)
$warn[]='Этого пользователя нет в вашем списке контактов';
else
{
mysql_query("UPDATE `users_konts` SET `type` = 'favorite', `time` = '$time' WHERE `id_user` = '$user[id]' AND `id_kont` = '$delpost[$q]' LIMIT 1");
}
$ank_del = get_user($delpost[$q]);
echo '<font color="#395aff"><b>' . $ank_del['nick'] . '</b></font>, ';
}

echo ' успешно перенесен(ы) в избранное</div>';
}else{
$err[] = 'Не выделено ни одного контакта';
}
}
// удаляем
if (isset($_POST['deleted']))
{
if (isset($delpost) && is_array($delpost))
{
echo '<div class="mess">Контакт(ы): ';

for ($q=0; $q<=count($delpost)-1; $q++) {
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `id_kont` = '$delpost[$q]'"), 0) == 0)
$warn[]='Этого пользователя нет в вашем списке контактов';
else
{
mysql_query("UPDATE `users_konts` SET `type` = 'deleted', `time` = '$time' WHERE `id_user` = '$user[id]' AND `id_kont` = '$delpost[$q]' LIMIT 1");

}
$ank_del = get_user($delpost[$q]);
echo '<font color="#395aff"><b>' . $ank_del['nick'] . '</b></font>, ';
}

echo ' успешно перенесен(ы) в корзину</div>';
}else{
$err[] = 'Не выделено ни одного контакта';
}
}

err();





$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `type` = '$type'"), 0);


if ($k_post){

	$k_page=k_page($k_post,$set['p_str']);
	$page=page($k_page);
	$start=$set['p_str']*$page-$set['p_str'];



	echo '<table class="post">';
	$q = mysql_query("SELECT * FROM `users_konts` WHERE `id_user` = '$user[id]' AND `type` = '$type' ORDER BY `time` DESC, `new_msg` DESC LIMIT $start, $set[p_str]");	
	echo '<form method="post" action="">';


	while ($post = mysql_fetch_array($q))
	{
		$ank_kont = get_user($post['id_kont']);
		$k_mess = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail` WHERE `unlink` != '$user[id]' AND `id_user` = '$ank_kont[id]' AND `id_kont` = '$user[id]'"), 0);
		$k_mess2 = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail` WHERE `unlink` != '$user[id]' AND `id_user` = '$user[id]' AND `id_kont` = '$ank_kont[id]'"), 0);		$k_mess_to = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail` WHERE `unlink` != '$user[id]' AND `id_user` = '$user[id]' AND `id_kont` = '$ank_kont[id]' AND `read` = '0'"), 0);
		$k_new_mess = mysql_result(mysql_query("SELECT COUNT(*) FROM `mail` WHERE `id_user` = '$ank_kont[id]' AND `id_kont` = '$user[id]' AND `read` = '0'"), 0);				if ($k_mess_to > 0)		$k_mess_to = ' <font color=red><b>&uarr;</b></font> [<font color=red>' . $k_mess_to . '</font>]';		else		$k_mess_to = null;
		/*-----------зебра-----------*/
		if ($num == 0)
		{echo "  <div class='nav1'>\n";
		$num=1;
		}elseif ($num == 1)
		{echo "  <div class='nav2'>\n";
		$num=0;}
		/*---------------------------*/				
		if ($set['set_show_icon'] == 2){
		
		avatar($ank_kont['id']);
		
		}
		elseif ($set['set_show_icon'] == 1)
		{
		
		echo status($ank_kont['id']);
		
		}

	echo group($ank_kont['id']) . ' <a href="/info.php?id=' . $ank_kont['id'] . '">' . $ank_kont['nick'] . '</a>';	echo online($ank_kont['id']) . medal($ank_kont['id']) . '<br />';
	
	echo '<input type="checkbox" name="post_' . $post['id_kont'] . '" value="1" />';	
	echo ($k_new_mess != 0 ? '<img src="/style/icons/new_mess.gif" alt="*" /> ' : '<img src="/style/icons/msg.gif" alt="*" /> ') . '<a href="/mail.php?id=' . $ank_kont['id'] . '">' . ($post['name'] != null ? $post['name'] : 'Сообщения') . '</a> ';
	echo ($k_new_mess != 0 ? '<font color="red">' : null) . ($k_new_mess != 0 ? '+' . $k_new_mess : '(' . $k_mess . '/' . $k_mess2 . ')' . $k_mess_to) . ($k_new_mess != 0 ? '</font> ' : null);
	
	echo '</div>';
	}			
echo '<div class="mess">';
echo ' Отмеченные контакты<br />';echo '</div>';echo '<div class="nav2">';
if ($type != 'deleted')echo '<input value="Удалить" type="submit" name="deleted" /> ';
if ($type != 'common')echo '<input value="Активные" type="submit" name="common" /> ';
if ($type != 'favorite')echo '<input value="Избранное" type="submit" name="favorite" /> ';
if ($type != 'ignor')echo '<input value="Игнор" type="submit" name="ignor" /> ';

echo '</form>';

echo '</div>';

if ($k_page > 1)str("?type=$type&amp;",$k_page,$page); // Вывод страниц
}else{
	echo '<div class="mess">';
	echo 'Ваш список контактов пуст';
	echo '</div>';
}


if ($type == 'deleted')echo '<div class="mess">Внимание. Контакты хранятся в корзине не более 1 месяца.<br />После этого они полностью удаляются.</div>';
if ($type == 'ignor')echo '<div class="mess">Уведомления о сообщениях от этих контактов не появляются</div>';
if ($type == 'favorite')echo '<div class="mess">Уведомления о сообщениях от этих контактов выделяются</div>';

echo '<div class="main">';
echo ($type == 'common' ? '<b>' : null) . '<img style="padding:2px;" src="/style/icons/activ.gif" alt="*" /> <a href="?type=common">Активные</a>' . ($type == 'common' ? '</b>' : null ) . ' (' . mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `type` = 'common'"), 0) . ')<br />';
echo ($type == 'favorite' ? '<b>' : null) . '<img style="padding:2px;" src="/style/icons/star_fav.gif" alt="*" /> <a href="?type=favorite">Избранные</a>' . ($type == 'favorite' ? '</b>' : null) . ' (' . mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `type` = 'favorite'"), 0) . ')<br />';
echo ($type == 'ignor' ? '<b>' : null) . '<img style="padding:2px;" src="/style/icons/spam.gif" alt="*" /> <a href="?type=ignor">Игнорируемые</a>' . ($type == 'ignor' ? '</b>' : null) . ' (' . mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `type` = 'ignor'"), 0) . ')<br />';
echo ($type == 'deleted' ? '<b>' : null) . '<img style="padding:2px;" src="/style/icons/trash.gif" alt="*" /> <a href="?type=deleted">Корзина</a>' . ($type == 'deleted' ? '</b>' : null) . ' (' . mysql_result(mysql_query("SELECT COUNT(*) FROM `users_konts` WHERE `id_user` = '$user[id]' AND `type` = 'deleted'"), 0) .')<br />';
echo '</div>';


include_once 'sys/inc/tfoot.php';
?>