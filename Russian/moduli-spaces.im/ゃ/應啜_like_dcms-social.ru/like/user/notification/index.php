<?
/*
=======================================
Уведомления для Dcms-Social
Автор: Искатель
---------------------------------------
Этот скрипт распостроняется по лицензии
движка Dcms-Social. 
При использовании указывать ссылку на
оф. сайт http://dcms-social.ru
---------------------------------------
Контакты
ICQ: 587863132
http://dcms-social.ru
=======================================
*/
include_once '../../sys/inc/start.php';
include_once '../../sys/inc/compress.php';
include_once '../../sys/inc/sess.php';
include_once '../../sys/inc/home.php';
include_once '../../sys/inc/settings.php';
include_once '../../sys/inc/db_connect.php';
include_once '../../sys/inc/ipua.php';
include_once '../../sys/inc/fnc.php';
include_once '../../sys/inc/adm_check.php';
include_once '../../sys/inc/user.php';


only_reg();


$width = ($webbrowser == 'web' ? '100' : '70'); // Размер подарков при выводе в браузер


/*
===============================
Полная очистка уведомлений
===============================
*/

if (isset($_GET['delete']) && $_GET['delete']=='all')
{
if (isset($user))
{
	mysql_query("DELETE FROM `notification` WHERE `id_user` = '$user[id]'");
	$_SESSION['message'] = 'Уведомления очищены';
	header("Location: ?");
	exit;
}
}


if (isset($_GET['del'])) // удаление уведомления
{
if (isset($user))
{
	if (mysql_result(mysql_query("SELECT COUNT(*) FROM `notification`  WHERE `id_user` = '$user[id]' AND `id` = '".intval($_GET['del'])."'"),0)==1)
	{
	mysql_query("DELETE FROM `notification` WHERE `id_user` = '$user[id]' AND `id` = '".intval($_GET['del'])."' LIMIT 1");
	$_SESSION['message'] = 'Уведомление удалено';
	header("Location: ?komm&".intval($_GET['page'])."");
	exit;
	}
}
}

$set['title']='Уведомления';
include_once '../../sys/inc/thead.php';


title();
err();
aut();

$k_notif = mysql_result(mysql_query("SELECT COUNT(`read`) FROM `notification` WHERE `id_user` = '$user[id]' AND `read` = '0'"), 0); // Уведомления

if ($k_notif > 0)$k_notif = '<font color=red>('.$k_notif.')</font>';
else $k_notif = null;

$discuss = mysql_result(mysql_query("SELECT COUNT(`count`) FROM `discussions` WHERE `id_user` = '$user[id]' AND `count` > '0' "),0); // Обсуждения

if ($discuss > 0)$discuss = '<font color=red>('.$discuss.')</font>';
else $discuss = null;

$lenta = mysql_result(mysql_query("SELECT COUNT(`read`) FROM `tape` WHERE `id_user` = '$user[id]' AND `read` = '0' "),0); // Лента

if ($lenta > 0)$lenta = '<font color=red>('.$lenta.')</font>';
else $lenta = null;

echo "<div id='comments' class='menus'>";
echo "<div class='webmenu'>";
echo "<a href='/user/tape/'>Лента $lenta</a>";
echo "</div>"; 
echo "<div class='webmenu'>";
echo "<a href='/user/discussions/' >Обсуждения $discuss</a>";
echo "</div>"; 
echo "<div class='webmenu'>";
echo "<a href='/user/notification/' class='activ'>Уведомления $k_notif</a>";
echo "</div>"; 
echo "</div>";


	$k_post=mysql_result(mysql_query("SELECT COUNT(*) FROM `notification`  WHERE `id_user` = '$user[id]' "),0);
	$k_page=k_page($k_post,$set['p_str']);
	$page=page($k_page);
	$start=$set['p_str']*$page-$set['p_str'];
	


	$q=mysql_query("SELECT * FROM `notification` WHERE `id_user` = '$user[id]' ORDER BY `time` DESC LIMIT $start, $set[p_str]");

if ($k_post==0)
{
	echo "  <div class='mess'>\n";
	echo "Нет новых уведомлений\n";
	echo "  </div>\n";
}

while ($post = mysql_fetch_assoc($q))
{

/*-----------зебра-----------*/ 
if ($num==0){
	echo '<div class="nav1">';
	$num=1;
}elseif ($num==1){
	echo '<div class="nav2">';
	$num=0;
}
/*---------------------------*/

	$type = $post['type'];
	$avtor = get_user($post['avtor']);
$type_post = explode('|', $post['type']);
	
	if ($post['read']==0)
	{
	$s1 = "<font color='red'>";
	$s2 = "</font>";
	}else{
	$s1 = null;
	$s2 = null;
	}
	
/*
===============================
Значение переменной $name для 
определенного типа сообщения
===============================
*/
if ($type == 'ok_gift') // Принимаем подарок
{	
	$name = 'принял'.($avtor['pol'] == 1 ? "" : "а") . ' ваш подарок ';
}
elseif ($type == 'no_gift') // Отказ от подарка
{	
	$name = 'отклонил'.($avtor['pol'] == 1 ? "" : "а") . ' ваш подарок ';
}
elseif ($type == 'new_gift') // Подарки новые
{	
	$name = 'сделал'.($avtor['pol'] == 1 ? "" : "а") . ' вам подарок ';
}
elseif ($type == 'files_komm' || $type == 'obmen_komm') // Файлы
{	
	$name = 'ответил'.($avtor['pol'] == 1 ? "" : "а") . ' вам в комментариях к файлу ';
}
elseif ($type == 'news_komm') // Новости 
{	
	$name = 'ответил'.($avtor['pol'] == 1 ? "" : "а") . ' вам в комментариях к новости ';
}
elseif ($type == 'status_komm') // Статусы
{	
	
	$status = mysql_fetch_assoc(mysql_query("SELECT * FROM `status` WHERE `id` = '".$post['id_object']."' LIMIT 1"));
	$name = 'ответил'.($avtor['pol'] == 1 ? "" : "а") . ' вам в комментариях этого ';
}
elseif ($type == 'foto_komm') // Фото 
{	
	$name = 'ответил'.($avtor['pol'] == 1 ? "" : "а") . ' вам в комментариях к фотографии ';
}
elseif ($type == 'notes_komm') // Дневники
{	
	$name = 'ответил'.($avtor['pol'] == 1 ? "" : "а") . ' вам в комментариях к дневнику ';
}
elseif ($type == 'them_komm') // форум
{	
	$name = 'ответил' . ($avtor['pol'] == 1 ? "" : "а") . ' вам в теме ';
}
elseif ($type_post[1] == 'them_post_like' || $type_post[1] == 'them_post_dislike') // форум посты
{
$name = 'проголосовал' . ($avtor['pol'] == 1 ? "" : "а") . ' ';
}
elseif ($type == 'stena_komm') // Стена
{	
	$stena = get_user($post['id_object']);
	
	if ($stena['id'] == $user['id']) $sT = 'вашей';
	elseif ($stena['id'] == $avtor['id']) $sT = 'своей';
	else{ $sT = null; }
	
	$name = 'ответил' . ($avtor['pol'] == 1 ? "" : "а") . ' вам на '.$sT;
}
elseif ($type == 'guest' || $type == 'adm_komm') // Гостевая, админ чат
{	
	$name = 'ответил' . ($avtor['pol'] == 1 ? "" : "а").' вам в ';
}
elseif ($type == 'del_frend') // Уведомления о удаленных друзьях
{	
	$name = ' к сожалению удалил' . ($avtor['pol'] == 1 ? "" : "а").' вас из списка друзей';
}
elseif ($type == 'no_frend') // Уведомления о отклоненных заявках в друзья
{	
	$name = ' к сожалению отказал' . ($avtor['pol'] == 1 ? "" : "а").' вам в дружбе';
}
elseif ($type == 'ok_frend') // Уведомления о принятых заявках в друзья
{	
	$name = ' стал' . ($avtor['pol'] == 1 ? "" : "а").' вашим другом';
}
elseif ($type == 'otm_frend') // Уведомления о отмененных заявках в друзья
{	
	$name = ' отменил' . ($avtor['pol'] == 1 ? "" : "а").' свою заявку на добавление вас в друзья';
}


/*
===============================
Подарки
===============================
*/	
if ($type == 'new_gift' || $type == 'no_gift' || $type == 'ok_gift') 
{	
if ($type == 'new_gift')
{
	$id_gift =  mysql_fetch_assoc(mysql_query("SELECT id,id_gift FROM `gifts_user` WHERE `id` = '$post[id_object]' LIMIT 1"));
	$gift =  mysql_fetch_assoc(mysql_query("SELECT * FROM `gift_list` WHERE `id` = '$id_gift[id_gift]' LIMIT 1"));
	
}else{

	$gift =  mysql_fetch_assoc(mysql_query("SELECT * FROM `gift_list` WHERE `id` = '$post[id_object]' LIMIT 1"));
	
}
if ($avtor['id']){
	
	echo status($avtor['id']) ,  group($avtor['id']) , " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a> ";
	echo medal($avtor['id']) , online($avtor['id']) , " $name ";

	if ($type == 'new_gift')echo '<a href="/user/gift/gift.php?id=' . $id_gift['id'] . '"><img src="/sys/gift/' . $gift['id'] . '.png" style="max-width:60px;" alt="*" /> ' . htmlspecialchars($gift['name']) . '</a>';
	
	else echo '<img src="/sys/gift/' . $gift['id'] . '.png" style="max-width:60px;" alt="*" /> ' . htmlspecialchars($gift['name']);
	
	echo "  $s1 ".vremja($post['time'])." $s2";

} 
	

if ($post['read'] == 0)
	mysql_query("UPDATE `notification` SET `read` = '1' WHERE `id` = '$post[id]'");
	
echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";

} 
/*
===============================
Друзья/Заявки
===============================
*/	
if ($type == 'no_frend' || $type == 'ok_frend' || $type == 'del_frend' || $type == 'otm_frend') 
{	

if ($avtor['id']){

	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>";
	echo "  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";

	echo "  $s1 ".vremja($post['time'])." $s2";

} else {

	echo " Этот друг уже удален с сайта =)  $s1 ".vremja($post['time'])." $s2";

}
	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
	mysql_query("UPDATE `notification` SET `read` = '1' WHERE `id` = '$post[id]'");
} 
/*
===============================
Дневники коментарии
===============================
*/	
if ($type == 'notes_komm') 
{	
	$notes = mysql_fetch_assoc(mysql_query("SELECT * FROM `notes` WHERE `id` = '".$post['id_object']."' LIMIT 1"));

if ($notes['id']){

	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";
	
	echo " <img src='/style/icons/zametki.gif' alt='*'> ";
	
	echo '<a href="/plugins/notes/list.php?id='.$notes['id'].'&amp;page='.$pageEnd.'"><b>'.htmlspecialchars($notes['name']).'</b></a> ';

	echo "  $s1 ".vremja($post['time'])." $s2";

} else {
	
	echo " Этот дневник уже удален =(  $s1 ".vremja($post['time'])." $s2";
	
}
	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
}
/*
===============================
Файлы коментарии
===============================
*/	
if ($type == 'files_komm' || $type == 'obmen_komm') 
{	
	$file = mysql_fetch_assoc(mysql_query("SELECT * FROM `obmennik_files` WHERE `id` = '".$post['id_object']."' LIMIT 1"));
	$dir=mysql_fetch_assoc(mysql_query("SELECT * FROM `user_files` WHERE `id` = '".$file['my_dir']."' LIMIT 1"));
	$ras = $file['ras'];
if ($file['id'] && $avtor['id']){

	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";
	echo " <img src='/style/icons/d.gif' alt='*'> ";
	
	echo '<a href="/user/personalfiles/'.$file['id_user'].'/'.$dir['id'].'/?id_file='.$file['id'].'&amp;page='.$pageEnd.'"><b>'.htmlspecialchars($file['name']).'.'.$ras.'</b></a> ';

	echo "  $s1 ".vremja($post['time'])." $s2";

} else {
	
	echo " Этот " . (!$file['id'] ? "файл" : "пользователь" ) . " уже удален =(  $s1 ".vremja($post['time'])." $s2";
	
}
	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
}
/*
===============================
Фото коментарии
===============================
*/	
if ($type == 'foto_komm') 
{	
	$foto = mysql_fetch_assoc(mysql_query("SELECT * FROM `gallery_foto` WHERE `id` = '".$post['id_object']."' LIMIT 1"));

if ($foto['id']){

	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";
	echo " <img src='/style/icons/foto.png' alt='*'> ";
	echo " <a href='/foto/$foto[id_user]/$foto[id_gallery]/$foto[id]/?page=$pageEnd'>" . htmlspecialchars($foto['name']) . "</a> ";
	echo "  $s1 ".vremja($post['time'])." $s2";

} else {
	
	echo " Эта фотография уже удалена =(  $s1 ".vremja($post['time'])." $s2";
	
}
	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
}
/*
===============================
Форум коментарии
===============================
*/	
if ($type == 'them_komm') 
{	
	$them=mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_t` WHERE `id` = '".$post['id_object']."' LIMIT 1"));
	$razdel=mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_r` WHERE `id` = '$them[id_razdel]' LIMIT 1"));
	$forum=mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_f` WHERE `id` = '$razdel[id_forum]' LIMIT 1"));

if ($them['id']){

	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";
	echo "<img src='/style/themes/$set[set_them]/forum/14/them_$them[up]$them[close].png' alt='*' /> ";
	echo " <a href='/forum/$forum[id]/$razdel[id]/$them[id]/?page=$pageEnd'>" . htmlspecialchars($them['name']) . "</a>  $s1 ".vremja($post['time'])." $s2";

} else {
	
	echo " Эта тема уже удалена =(  $s1 ".vremja($post['time'])." $s2";
	
}
	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
}
/*
===============================
Форум рейтинг постов
===============================
*/   
if ($type_post[1] == 'them_post_like' || $type_post[1] == 'them_post_dislike') 
{   
   $them=mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_t` WHERE `id` = '".$post['id_object']."' LIMIT 1"));

   $razdel=mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_r` WHERE `id` = '$them[id_razdel]' LIMIT 1"));

   $forum=mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_f` WHERE `id` = '$razdel[id_forum]' LIMIT 1"));

$poster=mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_p` WHERE `id_them` = '$them[id]' AND `id_forum` = '$forum[id]' AND `id_razdel` = '$razdel[id]' AND `id` = '".$type_post[0]."' "));


if ($type_post[1] == 'them_post_like')$like = '<b><span style = "color:green">+1</span></b>';
if ($type_post[1] == 'them_post_dislike')$like = '<b><span style = "color:red">-1</span></b>';
if ($poster['id']){
   echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name за ваш пост $like <br /><b>".$poster['msg']."</b><br />\n в теме ";
   echo "<img src='/style/themes/$set[set_them]/forum/14/them_$them[up]$them[close].png' alt='*' /> ";
   echo " <a href='/forum/$forum[id]/$razdel[id]/$them[id]/?page=$pageEnd'>".htmlspecialchars($them['name'])."</a>  $s1 ".vremja($post['time'])." $s2";

} else {


echo "Этот пост уже удален =(  $s1 ".vremja($post['time'])." $s2";

}
   
echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
   
}
/*
===============================
Стена юзера
===============================
*/	
if ($type == 'stena_komm') 
{	

	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";
	
	echo "<img src='/style/icons/stena.gif' alt='*'> <a href='/info.php?id=$stena[id]&amp;page=$pageEnd'>стене</a> " . ($sT == null ? "$stena[nick]" : "") . "  $s1 ".vremja($post['time'])." $s2";

	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
}
/*
===============================
Стасус коментарии
===============================
*/	
if ($type == 'status_komm') 
{	
	if ($status['id'])
	{
	$ankS = get_user($status['id_user']);
	
	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";
	
	echo "<img src='/style/icons/comment.png' alt='*'> <a href='/user/status/komm.php?id=$status[id]&amp;page=$pageEnd'>статуса</a>  $s1 ".vremja($post['time'])." $s2";
	
	}else{
	
	echo 'Статус уже удален =(';
	
	}
	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
}
/*
===============================
Новости коментарии
===============================
*/	
if ($type == 'news_komm') 
{	
	$news = mysql_fetch_assoc(mysql_query("SELECT * FROM `news` WHERE `id` = '".$post['id_object']."' LIMIT 1"));
	
	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";
	
	echo "<img src='/style/icons/news.png' alt='*'> <a href='/news/news.php?id=$news[id]&amp;page=$pageEnd'>" . htmlspecialchars($news['title']) . "</a>  $s1 ".vremja($post['time'])." $s2";

	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
}
/*
===============================
Гостевая коментарии
===============================
*/	
if ($type == 'guest') 
{	
	if ($avtor['id'])
	{
	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";
	
	echo "<img src='/style/icons/guest.png' alt='*'> <a href='/guest/?page=$pageEnd'>гостевой</a>  $s1 ".vremja($post['time'])." $s2";
	} else {
	echo 'Этот пользователь пользователь уже удален =(';
	}
	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
}
/*
===============================
Админ чат
===============================
*/	
if ($type == 'adm_komm') 
{	

	echo status($avtor['id']) .  group($avtor['id']) . " <a href='/info.php?id=$avtor[id]'>$avtor[nick]</a>  " . medal($avtor['id']) . " " . online($avtor['id']) . " $name ";
	
	echo "<img src='/style/icons/chat.gif' alt='S' /> <a href='/plugins/admin/chat/?page=$pageEnd'>админ чате</a>  $s1 ".vremja($post['time'])." $s2";

	echo "<div style='text-align:right;'><a href='?komm&amp;del=$post[id]&amp;page=$page'><img src='/style/icons/delete.gif' alt='*' /></a></div>";
}
	
	echo "</div>";
}

if ($k_page>1)str('?',$k_page,$page); // Вывод страниц



	
echo "<div class=\"foot\">\n";
echo "<img src='/style/icons/str2.gif' alt='*'> <a href='/info.php?id=$user[id]'>$user[nick]</a> | \n";
echo '<b>Уведомления</b> | <a href="settings.php">Настройки</a>';
echo "</div>\n";


include_once '../../sys/inc/tfoot.php';
?>