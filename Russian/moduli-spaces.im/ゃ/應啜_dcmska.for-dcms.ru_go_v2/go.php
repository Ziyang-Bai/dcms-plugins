<?
include_once 'sys/inc/start.php';
include_once 'sys/inc/compress.php';
include_once 'sys/inc/sess.php';
include_once 'sys/inc/home.php';
include_once 'sys/inc/settings.php';
include_once 'sys/inc/db_connect.php';
include_once 'sys/inc/ipua.php';
include_once 'sys/inc/fnc.php';
include_once 'sys/inc/user.php';

if(isset($_GET['go'])){
	$go=@base64_decode($_GET['go']);
	if(substr_count($go,'http://')){
		$set['title']='Переход по ссылке...';
		include('sys/inc/thead.php');
		title();



		echo "<center>Вы покидаете сайт ".strtoupper($_SERVER['HTTP_HOST'])."</center>";
        echo "<center>Продолжить переход по внешней ссылке на сайт $go.<br/></center>";
        echo "<center><a href='$go'>Да</a> <a href='$_SERVER[HTTP_REFERER]'>Нет</a><br/></center><br/>";




		include 'sys/inc/tfoot.php';
		exit();
		}
	}



$set['title']='Перенаправление';
include_once 'sys/inc/thead.php';
title();

if (!isset($_GET['go']) || (mysql_result(mysql_query("SELECT COUNT(*) FROM `rekl` WHERE `id` = '".intval($_GET['go'])."'"),0)==0 && !ereg('^https?://',@base64_decode($_GET['go']))))
{
header("Location: index.php?".SID);
exit;
}

if (ereg('^(ht|f)tps?://',base64_decode($_GET['go'])))
{
if (isset($_SESSION['adm_auth']))unset($_SESSION['adm_auth']);
header("Location: ".base64_decode($_GET['go']));
exit;
}
else
{
$rekl=mysql_fetch_assoc(mysql_query("SELECT * FROM `rekl` WHERE `id` = '".intval($_GET['go'])."'"));
mysql_query("UPDATE `rekl` SET `count` = '".($rekl['count']+1)."' WHERE `id` = '$rekl[id]'");

if (isset($_SESSION['adm_auth']))unset($_SESSION['adm_auth']);
header("Refresh: 2; url=$rekl[link]");



echo "За содержание рекламируемого ресурса<br />\n";
echo "администрация сайта ".strtoupper($_SERVER['HTTP_HOST'])." ответственности не несёт.<br />\n";

echo "<b><a href=\"$rekl[link]\">Переход</a></b><br />\n";

echo "Переходов: $rekl[count]<br />\n";
}
include_once 'sys/inc/tfoot.php';
?>
