<?
/*
Автор скрипта: Simptom
Сайт поддержки: http://s-klub.ru
Запрещено распространять скрипт в любом виде и под любым предлогом!
*/
if (!isset($user))
{
echo "<div class='err'>";
echo 'Игра "Флиртомания" доступна только для авторизованных пользователей!';
echo "</div>";
include_once '../sys/inc/tfoot.php';
exit;
}
?>