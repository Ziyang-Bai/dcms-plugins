/////
////	D.C.R.T
///	 ICQ: 2711149 
//	   E-MAIL: d.c.r.t@mail.ru
/
--------------------------------------------

���������:
1) ����������� �����

2) ��������� ������:

# ALTER TABLE `user` ADD `horo` INT NOT NULL DEFAULT '1', ADD `lhoro` INT NOT NULL DEFAULT '0'

3) � ����� sys/inc/user.php � �����(����� ?>) ���������:
horoskop();

4) � ����� anketa.php ��� ����� "���� ��������" ���������:
echo $sethoroskop;

5) ���.