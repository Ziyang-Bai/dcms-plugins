<?
if(isset($_GET['add']))
{
echo'<form method="post" action="?">';
echo'Название<br/>';
echo'<input type="text" name="name"><br/>';
echo'Описание<br/>';
echo'<textarea name="desc"></textarea><br/>';
echo'<input type="submit" name="ok" value="Создать"></form><br/>';
}
else
{
echo'<a href="?add">Добавить категорию</a><br/>';
}
if(isset($_GET['edit']) && mysql_result(mysql_query("SELECT COUNT(*) FROM `diary_cat` WHERE `id` = '".intval($_GET['edit'])."' LIMIT 1"),0)==1)
{
$edit=mysql_fetch_assoc(mysql_query("SELECT * FROM `diary_cat` WHERE `id` = '".intval($_GET['edit'])."' LIMIT 1"));
echo'<form method="post" action="?edit='.$edit['id'].'">';
echo'Название<br/>';
echo'<input type="text" name="name" value="'.$edit['name'].'"><br/>';
echo'Описание<br/>';
echo'<textarea name="desc">'.$edit['desc'].'</textarea><br/>';
echo'<input type="submit" value="Изменить">';
}
?>