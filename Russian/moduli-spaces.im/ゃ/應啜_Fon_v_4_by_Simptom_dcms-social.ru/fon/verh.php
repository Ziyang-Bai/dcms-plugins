<?
//info.php �������� �� ���� ����� ������ ��������� �����
if ($_SERVER['PHP_SELF']=='/info.php')
{
include_once 'fon/verh_info.php';
}

//anketa.php �������� �� ���� ����� ������ �����
if ($_SERVER['PHP_SELF']=='/anketa.php')
{
include_once 'fon/verh_anketa.php';
}
include_once 'fon/fon_info/verh.php';
include_once 'fon/fon_anketa/verh.php';
?>