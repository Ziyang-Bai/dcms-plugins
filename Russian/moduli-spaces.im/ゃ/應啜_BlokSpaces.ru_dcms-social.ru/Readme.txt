O� � o�epe��o� �o� �o�: �a��ca� ��o� �a�ce��a, cpa�y o��c�� ��� �e�o!
Bo� ��ep ��o�o pa� �apy�ae�, � �a�� e�y �e �o�a�a��....�a� �a��� e�y "��o� �a�ce��a" � �cex �o �e�o�!
C�p��� �a��ca� ��o�: �oec�� Gemind 
Ko��a���
e-mail: crusis2@spaces.ru
Ca��: �eo��a�e� :)







Kapo�e �e�ep� yc�a�o��a:
��e� �a�� /info.php �oec�� �����e c�pa�����))
aut(); �p��ep�o 21 c�po�a
Bc�a���e� �o�:
if ($ank['bloq']==1){
 avatar($ank['id']);
 echo "<font color='red'> ��o� a�ay�� �a��o��po�a� �a �apy�e��e <a href='http://�a� ca��.py/info/all_rules.php'> �pa��� </a> cep��ca!<font>";
 echo "<div class='forum_t'>�p����a: $ank[bloq_p]</div>";
 if ($user['group_access']>=7){
echo "<a href='/bloq.php?id=$ank[id]'> Po���o��po�a�� </a><br/>";
echo "�pay�ep $ank[ua]";}
� �a���e � �o��e �o�a �epe� include_once 'sys/inc/tfoot.php';
�a�p��ae� yc�o��e( ec�� ��o �e ��ae� ��o ��o c�a��� } )
Ha ����o� �po��cye� e�e!

if (isset($user) && $user['group_access']>=7){ echo "[<a href='/bloq.php?id=$ank[id]'> �a��o��po�a�� �a�ce��a </a>]<br/>";}


�a���e ���o���e� �a�poc � ��
ALTER TABLE `user` ADD `bloq` enum('0','1') NOT NULL default '0';
ALTER TABLE `user` ADD `bloq_p` TEXT NOT NULL default '';
�a���e �pocae� �a�� 
bloq.php � �ope�� c�oe�o ca��a:
�a�� user.php � /sys/inc/
� �e�ep� �ce �y�e� pa�o�a�� �a �o��y�!
�� ��o �e �oc�e���� �o�!
�po���a �e ���� �ap��o�!

(c) Gemind 2011 