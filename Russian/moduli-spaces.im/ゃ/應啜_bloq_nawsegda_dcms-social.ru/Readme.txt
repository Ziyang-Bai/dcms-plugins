�� � ��������� ��� ���: ������� ���� ��������, ����� ������ ��� ����!
��� ���� ����� ��� ��������, � ���� ��� �� ��������....��� ����� ��� "���� ��������" � ���� �� �����!
������ ������� ����: ������ Ivanovsky 
��������: icq: 613540059
e-mail: corp.breaking@ya.ru
����: http://vineti.ru/info.php?id=1
�������: � ���� ���� ������� � ���� �����...������ ����������...� �� ��� ����...� ������� �������!






������ ������ ���������:
���� ���� /info.php ������ ������ ���������))
aut(); �������� 21 ������
��������� ���:
if ($ank['bloq']==1){
 avatar($ank['id']);
 echo "<font color='red'> ���� ������ ������������ �� ��������� <a href='http://vineti.ru/info/all_rules.php'> ������ </a> �������!<font>";
 echo "<div class='forum_t'>�������: $ank[bloq_p]</div>";
 if ($user['group_access']>=7){
echo "<a href='/bloq.php?id=$ank[id]'> �������������� </a><br/>";
echo "������� $ank[ua]";}
� ������ � ����� ���� ����� include_once 'sys/inc/tfoot.php';
��������� �������( ���� ��� �� ����� ��� ��� ������ } )
�� ������ ��������� ���!

if (isset($user) && $user['group_access']>=7){ echo "[<a href='/bloq.php?id=$ank[id]'> ������������� �������� </a>]<br/>";}


������ ��������� ������ � ��
ALTER TABLE `user` ADD `bloq` enum('0','1') NOT NULL default '0';
ALTER TABLE `user` ADD `bloq_p` TEXT NOT NULL default '';
������ ������� ���� 
bloq.php � ������ ������ �����:
���� user.php � /sys/inc/
� ������ �� ����� �������� �� ������!
�� ��� �� ��������� ���!
������� �� ���� �������!

(c) BreaKing 2011 