<?
//include_once 'sys/inc/mp3.php';
//include_once 'sys/inc/zip.php';
include_once 'sys/inc/start.php';
include_once 'sys/inc/compress.php';
include_once 'sys/inc/sess.php';
include_once 'sys/inc/home.php';
include_once 'sys/inc/settings.php';
include_once 'sys/inc/db_connect.php';
include_once 'sys/inc/ipua.php';
include_once 'sys/inc/fnc.php';
include_once 'sys/inc/shif.php';
$show_all=true; // показ для всех
include_once 'sys/inc/user.php';
only_unreg();
$select=(!empty($_GET['act'])? trim($_GET['act']):NULL);
switch($select)
{
case 'country': 
if(isset($_SESSION['step']) && $_SESSION['step']==1){
$set['title']='Регистрация / Выбор страны';
include_once 'sys/inc/thead.php';
title();
aut();
$k_post = mysql_result(mysql_query("SELECT * FROM `country`"), 0);
$k_page = k_page($k_post, $set['p_str']);
$page = page($k_page);
$start = $set['p_str'] * $page - $set['p_str'];
$sql = mysql_query("SELECT * FROM `country` LIMIT $start, $set[p_str]");
while($country = mysql_fetch_assoc($sql)) {
    	echo '<div class="' . ($num % 2 ? "nav1" : "nav2") . '">
	
    	<img src="/style/country/'.$country['id'].'.png" alt="*"> <a href="?act=region&id='.output_text($country['id']).'">'.output_text($country['name']).'</a>
    	</div>';
    	$num++;
    	}

if ($k_page > 1)str('?act=country&amp;', $k_page, $page); // Вывод страниц   break;
echo '<div class="foot">';
echo "<img src='/style/icons/str2.gif' alt='*'> <a href='edit.php'>Редактировать анкету</a><br />\n";
echo '</div>';
}else
{
header("Location: reg.php".SID);
}
 break;
 /////////////////////////////////  
   case 'region': 
  if(isset($_SESSION['step']) && $_SESSION['step']==1){ 
 $set['title']='Регистрация / Выбор региона';
include_once 'sys/inc/thead.php';
title();
aut();
 $id =(!empty($_GET['id'])? intval($_GET['id']):NULL);
 
 if($id!=NULL && mysql_result(mysql_query("SELECT * FROM `region` WHERE `id_country`=$id"), 0)!='0') {
$_SESSION['region']=$id;
$k_post = mysql_num_rows(mysql_query("SELECT * FROM `region` WHERE `id_country`='$id'"));
$k_page = k_page($k_post, $set['p_str']);
$page = page($k_page);
$start = $set['p_str'] * $page - $set['p_str'];

$sql = mysql_query("SELECT * FROM `region` WHERE `id_country`=$id LIMIT $start, $set[p_str] ");
while($region = mysql_fetch_assoc($sql)) {
    	echo '<div class="' . ($num % 2 ? "nav1" : "nav2") . '">
    	<a href="?act=city&id='.output_text($region['id']).'">'.output_text($region['name']).'</a>
    	</div>';
    	$num++;
    	}
if ($k_page > 1)str('?act=region&id='.$id.'&amp;', $k_page, $page); // Вывод страниц   break;

echo '<div class="nav1">';
echo "<img src='/style/icons/str2.gif' alt='*'> <a href='?act=country'>Выбор страны</a><br />\n";
echo '</div>';
}

 else
 {
 header("Location: reg.php".SID); 
 }
 }
 else
{
header("Location: reg.php".SID);
}
   break;
 /////////////////////////////////  
   case 'city': 
 if(isset($_SESSION['step']) && $_SESSION['step']==1){ 
  $set['title']='Регистрация / Выбор города';
include_once 'sys/inc/thead.php';
title();
aut();
  $id =(!empty($_GET['id'])? intval($_GET['id']):NULL);
  
 if($id !=NULL && mysql_result(mysql_query("SELECT * FROM `city` WHERE `id_region`='$id'"),0)!='0') {
 $_SESSION['city']=$id;
 $k_post = mysql_num_rows(mysql_query("SELECT * FROM `city` WHERE `id_region`=$id "));
$k_page = k_page($k_post, $set['p_str']);
$page = page($k_page);
$start = $set['p_str'] * $page - $set['p_str'];

$sql = mysql_query("SELECT * FROM `city` WHERE `id_region`='$id' LIMIT $start, $set[p_str] ");
while($city = mysql_fetch_assoc($sql)){
    	echo '<div class="' . ($num % 2 ? "nav1" : "nav2") . '">
    	<a href="?act=select&id='.output_text($city['id']).'">'.output_text($city['name']).'</a>
    	</div>';
    	$num++;
    	}
if ($k_page > 1)str('?act=city&id='.$id.'&amp;', $k_page, $page); // Вывод страниц   break;

echo '<div class="foot">';
echo "<img src='/style/icons/str2.gif' alt='*'> <a href='?act=country'>Выбор страны</a><br />\n";
echo "<img src='/style/icons/str2.gif' alt='*'> <a href='?act=region&id=".$_SESSION['region']."'>Выбор региона</a><br />\n";
echo '</div>';
}
else
{
 header("Location: reg.php".SID); 
 }
 }else
 {
 header("Location: reg.php".SID);
 }  
   break;
   /////////////
case 'select':
if(isset($_SESSION['step']) && $_SESSION['step']==1){
  $id =(!empty($_GET['id'])? intval($_GET['id']):NULL);
$set['title']='Регистрация / Выбор страны';
include_once 'sys/inc/thead.php';
title();
aut();
 if($id !=NULL && mysql_result(mysql_query("SELECT * FROM `city` WHERE `id`=$id "),0!=0)) {
 
 $city = mysql_fetch_assoc(mysql_query("SELECT * FROM `city` WHERE `id`=$id LIMIT 1"));
$country = mysql_fetch_array(mysql_query("SELECT * FROM `country` WHERE `id`='".$city['id_country']."' LIMIT 1"));
$region = mysql_fetch_array(mysql_query("SELECT * FROM `region` WHERE `id`= ".$city['id_region']." LIMIT 1"));
$city = mysql_fetch_array(mysql_query("SELECT * FROM `city` WHERE `id`=".$city['id']." LIMIT 1"));

if(isset($_POST['save']) ){
 if (!isset($err))
{
$_SESSION['coun']=$country['name'];
$_SESSION['reg']=$region['name'];
$_SESSION['ci']=$city['name'];
//mysql_query("UPDATE `user` SET  `city` = '".htmlspecialchars($city['name'])."', `country` = '".htmlspecialchars($country['name'])."', `region` = '".htmlspecialchars($region['name'])."' WHERE `id` = '".$user['id'] ."'");
$_SESSION['message'] = 'Изменения успешно приняты';
header("Location: reg.php");
 }
 }

echo "<div class='mess'>
<form method='post' action=''>
 <font color='green'>Ваша страна :</font> <b>".output_text($country['name'])."</b></br> <font color='green'>Ваш регион:</font> <b>".output_text($region['name'])."</b> </br> <font color='green'>Ваш город : </font><b>".output_text($city['name'])."</b></br>
</br><input type='submit' name='save' value='Принять изменения' />
</form>
 </div>";
 
 
 echo '<div class="foot">';
echo "<img src='/style/icons/str2.gif' alt='*'> <a href='?act=country'>Выбор страны</a><br />\n";
echo "<img src='/style/icons/str2.gif' alt='*'> <a href='?act=region&id=".$_SESSION['region']."'>Выбор региона</a><br />\n";
echo "<img src='/style/icons/str2.gif' alt='*'> <a href='?act=city&id=".$_SESSION['city']."'>Выбор города</a><br />\n";
echo '</div>';
   } 
}
else
{
header("Location: reg.php".SID);
} 
 break;  
   default:

$set['title']='Регистрация';
include_once 'sys/inc/thead.php';
title();

if ($set['guest_select']=='1')msg("Доступ к сайту разрешен только авторизованым пользователям");
if ((!isset($_SESSION['refer']) || $_SESSION['refer']==NULL)
&& isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=NULL &&
!preg_match('#mail\.php#',$_SERVER['HTTP_REFERER']))
$_SESSION['refer']=str_replace('&','&amp;',preg_replace('#^http://[^/]*/#','/', $_SERVER['HTTP_REFERER']));if ($set['reg_select']=='close')
{
	$err='Регистрация временно приостановлена';
	err();

	echo "<a href='/aut.php'>Авторизация</a><br />\n";
	include_once 'sys/inc/tfoot.php';
}
elseif($set['reg_select']=='open_mail' && isset($_GET['id']) && isset($_GET['activation']) && $_GET['activation']!=NULL)
{
	if (mysql_result(mysql_query("SELECT COUNT(*) FROM `user` WHERE `id` = '".intval($_GET['id'])."' AND `activation` = '".my_esc($_GET['activation'])."'"),0)==1)
	{

	mysql_query("UPDATE `user` SET `activation` = null WHERE `id` = '".intval($_GET['id'])."' LIMIT 1");
	$user = mysql_fetch_assoc(mysql_query("SELECT * FROM `user` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));
	mysql_query("INSERT INTO `reg_mail` (`id_user`,`mail`) VALUES ('$user[id]','$user[ank_mail]')");
	msg('Ваш аккаунт успешно активирован');

	$_SESSION['id_user']=$user['id'];
	include_once 'sys/inc/tfoot.php';
	}
}

if (isset($_SESSION['step']) && $_SESSION['step']==1 && mysql_result(mysql_query("SELECT COUNT(*) FROM `user` WHERE `nick` = '".$_SESSION['reg_nick']."'"),0)==0 && isset($_POST['pass1']) && $_POST['pass1']!=NULL && $_POST['pass2'] && $_POST['pass2']!=NULL)
{

if ($set['reg_select']=='open_mail')
{
if (!isset($_POST['ank_mail']) || $_POST['ank_mail']==NULL)$err[]='Неоходимо ввести Email';
elseif (!preg_match('#^[A-z0-9-\._]+@[A-z0-9]{2,}\.[A-z]{2,4}$#ui',$_POST['ank_mail']))$err[]='Неверный формат Email';
elseif(mysql_result(mysql_query("SELECT COUNT(*) FROM `reg_mail` WHERE `mail` = '".my_esc($_POST['ank_mail'])."'"),0)!=0)
{
$err[]="Пользователь с этим E-mail уже зарегистрирован";
}
}
if($_SESSION['coun']==NULL)$err[]='Не выбрана страна';
if($_SESSION['reg']==NULL)$err[]='Не выбран регион';
if($_SESSION['ci']==NULL)$err[]='Не выбран город';


if (strlen2($_POST['pass1'])<6)$err[]='По соображениям безопасности пароль не может быть короче 6-ти символов';
if (strlen2($_POST['pass1'])>32)$err[]='Длина пароля превышает 32 символа';
if ($_POST['pass1']!=$_POST['pass2'])$err[]='Пароли не совпадают';
if (!isset($_SESSION['captcha']) || !isset($_POST['chislo']) || $_SESSION['captcha']!=$_POST['chislo']){$err[]='Неверное проверочное число';}

if (!isset($err))
{
if ($set['reg_select']=='open_mail')
{
$activation=md5(passgen());

mysql_query("INSERT INTO `user` (`nick`, `pass`, `date_reg`, `date_last`, `pol`, `activation`, `ank_mail`, `pol`,`country`,`region`,`city`) values('".$_SESSION['reg_nick']."', '".shif($_POST['pass1'])."', '$time', '$time', '".intval($_POST['pol'])."', '$activation', '".my_esc($_POST['ank_mail'])."','".$_SESSION['coun']."','".$_SESSION['reg']."','".$_SESSION['ci']."')",$db);

$id_reg=mysql_insert_id();
$subject = "Активация аккаунта";
$regmail = "Здравствуйте $_SESSION[reg_nick]<br />
Для активации Вашего аккаунта перейдите по ссылке:<br />
<a href='http://$_SERVER[HTTP_HOST]/reg.php?id=$id_reg&amp;activation=$activation'>http://$_SERVER[HTTP_HOST]/reg.php?id=".mysql_insert_id()."&amp;activation=$activation</a><br />
Если аккаунт не будет активирован в течении 24 часов, он будет удален<br />
С уважением, администрация сайта<br />
";
$adds="From: \"password@$_SERVER[HTTP_HOST]\" <password@$_SERVER[HTTP_HOST]>\n";
//$adds = "From: <$set[reg_mail]>\n";
//$adds .= "X-sender: <$set[reg_mail]>\n";
$adds .= "Content-Type: text/html; charset=utf-8\n";
mail($_POST['ank_mail'],'=?utf-8?B?'.base64_encode($subject).'?=',$regmail,$adds);

}
else
mysql_query("INSERT INTO `user` (`nick`, `pass`, `date_reg`, `date_last`, `pol`,`country`,`region`,`city`) values('".$_SESSION['reg_nick']."', '".shif($_POST['pass1'])."', '$time', '$time', '".intval($_POST['pol'])."','".$_SESSION['coun']."','".$_SESSION['reg']."','".$_SESSION['ci']."')",$db);

$user = mysql_fetch_assoc(mysql_query("SELECT * FROM `user` WHERE `nick` = '".my_esc($_SESSION['reg_nick'])."' AND `pass` = '".shif($_POST['pass1'])."' LIMIT 1"));

/*
========================================
Создание настроек юзера 
========================================
*/
unset($_SESSION);
mysql_query("INSERT INTO `user_set` (`id_user`) VALUES ('$user[id]')");
mysql_query("INSERT INTO `discussions_set` (`id_user`) VALUES ('$user[id]')");
mysql_query("INSERT INTO `tape_set` (`id_user`) VALUES ('$user[id]')");
mysql_query("INSERT INTO `notification_set` (`id_user`) VALUES ('$user[id]')");


if (isset($_SESSION['http_referer']))
mysql_query("INSERT INTO `user_ref` (`time`, `id_user`, `type_input`, `url`) VALUES ('$time', '$user[id]', 'reg', '".my_esc($_SESSION['http_referer'])."')");

$_SESSION['id_user']=$user['id'];
setcookie('id_user', $user['id'], time()+60*60*24*365);
setcookie('pass', cookie_encrypt($_POST['pass1'],$user['id']), time()+60*60*24*365);

if ($set['reg_select']=='open_mail')
{
msg('Вам необходимо активировать Ваш аккаунт по ссылке, высланной на Email');
}
else
{
	mysql_query("update `user` set `wall` = '0' where `id` = '$user[id]' limit 1");
	header('Location: /umenu.php?login=' . htmlspecialchars($_POST['reg_nick']) . '&pass=' . htmlspecialchars($_POST['pass1']));
}

echo "Если Ваш браузер не поддерживает Cookie, Вы можете создать закладку для автовхода<br />\n";
echo "<input type='text' value='http://$_SERVER[SERVER_NAME]/login.php?id=$user[id]&amp;pass=".htmlspecialchars($_POST['pass1'])."' /><br />\n";
if ($set['reg_select']=='open_mail')unset($user);
echo "<div class='foot'>\n";
echo "&raquo;<a href='settings.php'>Мои настройки</a><br />\n";
echo "&raquo;<a href='umenu.php'>Мое меню</a><br />\n";
echo "</div>\n";
include_once 'sys/inc/tfoot.php';
}
}
elseif (isset($_POST['nick']) && $_POST['nick']!=NULL )
{
if (mysql_result(mysql_query("SELECT COUNT(*) FROM `user` WHERE `nick` = '".my_esc($_POST['nick'])."'"),0)==0)
{
$nick=my_esc($_POST['nick']);if( !preg_match("#^([A-zА-я0-9\-\_\ ])+$#ui", $_POST['nick']))$err[]='В нике присутствуют запрещенные символы';
if (preg_match("#[a-z]+#ui", $_POST['nick']) && preg_match("#[а-я]+#ui", $_POST['nick']))$err[]='Разрешается использовать символы только русского или только английского алфавита';
if (preg_match("#(^\ )|(\ $)#ui", $_POST['nick']))$err[]='Запрещено использовать пробел в начале и конце ника';
if (strlen2($nick)<3)$err[]='Короткий ник';
if (strlen2($nick)>32)$err[]='Длина ника превышает 32 символа';
}
else $err[]='Ник "'.stripcslashes(htmlspecialchars($_POST['nick'])).'" уже зарегистрирован';if (!isset($err)){
$_SESSION['reg_nick']=$nick;
$_SESSION['step']=1;
msg ("Ник \"$nick\" может быть успешно зарегистрирован");
}
}

err();
if (isset($_SESSION['step']) && $_SESSION['step']==1)
{

	echo "<div class='nav2'><form method='post' action='/reg.php?$passgen'>\n";
	echo "Ваш ник [A-zА-я0-9 -_]:<br /><input type='text' name='nick' maxlength='32' value='$_SESSION[reg_nick]' /><br />\n";
	echo "<input type='submit' value='Другой' />\n";
	echo "</form><br />\n";echo "<form method='post' action='/reg.php?$passgen'>\n";
	echo "Ваш пол:<br /><select name='pol'><option value='1'>Мужской</option><option value='0'>Женский</option></select><br />\n";

	if ($set['reg_select']=='open_mail') 
	{
		echo "E-mail:<br /><input type='text' name='ank_mail' /><br />\n";
		echo "* Указывайте ваш реальный адрес E-mail. На него придет код для активации аккаунта.<br />\n";
	}
	
	/* Автор VoronoZ 
http://dcms-social.ru/info.php?id=627
https://vk.com/voronoz
*/

echo "<div class='nav1'>
  Страна  <b>".($_SESSION['coun']!=NULL? output_text($_SESSION['coun']): 'Не выбрано')."</b><span style='float:right;'><a href='?act=country'><font color='green'>Изменить</font></span></a></br>  Регион <b>".($_SESSION['reg']!=NULL ? output_text($_SESSION['reg']) : 'Не выбрано')."</b> </br>  Город </font><b>".($_SESSION['ci']!=NULL ? output_text($_SESSION['ci']) : 'Не выбрано')."</b></br></div>";
///// End
	
	echo "Введите пароль (6-32 символов):<br /><input type='password' name='pass1' maxlength='32' /><br />\n";
	echo "Повторите пароль:<br /><input type='password' name='pass2' maxlength='32' /><br />\n";
	echo "<img src='/captcha.php?$passgen&amp;SESS=$sess' width='100' height='30' alt='Проверочное число' /><br />\n<input name='chislo' size='5' maxlength='5' value='' type='text' /><br/>\n";
	echo "Регистрируясь, Вы автоматически соглашаетесь с <a href='/rules.php'>правилами</a> сайта<br />\n";

	echo "<input type='submit' value='Продолжить' />\n";
	echo "</form><br />\n";
}
else
{
	echo "<form class='mess' method='post' action='/reg.php?$passgen'>\n";
	echo "Выберите ник [A-zА-я0-9 -_]:<br /><input type='text' name='nick' maxlength='32' /><br />\n";
	echo "Регистрируясь, Вы автоматически соглашаетесь с <a href='/rules.php'>правилами</a> сайта<br />\n";
	echo "<input type='submit' value='Продолжить' />\n";
	echo "</form><br />\n</div>";
}
}
echo "<div class = 'foot'>Уже зарегистрированы?<br />&raquo;<a href='/aut.php'>Авторизация</a></div>
<div class = 'foot'>Не можете вспомнить пароль?<br />&raquo;<a href='/pass.php'>Восстановить пароль</a></div>\n";
include_once 'sys/inc/tfoot.php';
?>