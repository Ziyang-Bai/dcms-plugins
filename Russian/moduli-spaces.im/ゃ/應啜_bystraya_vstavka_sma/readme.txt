���������:
����������� � ������!
� ������ ��� ���� ����� ����� (��������: /guest/index.php), �������� � ���, ��� �������� � �������:

��� �������� �� ���������:
echo "<form method='post' name='message'>";
echo "<textarea cols='20' rows='2' name='msg'></textarea><br>";
echo "<input value='��������' type='submit' name='add' />";
echo "</form>";

��� ������ ��������� ����� ���������:
echo "<form method='post' name='message'>";
// �������� ��������
echo "<script src='/js/qbbcodes.js'></script>";
include ('../js/bbcodes.php');
// �����
echo "<textarea cols='20' rows='2' name='msg'></textarea><br>";
// �������� ��������
echo "<script src='/js/qsmiles.js'></script>";
include ('../js/smiles.php');
// �����
echo "<input value='��������' type='submit' name='add' />";
echo "</form>";

��������!
���� ��� ����� �� message (<form name='message'>) � ��� ���������� ���� �� msg (<textarea name='msg'>), �� �������� �� �����!!!

����� ��������/���������/������� ������ ��������� �������, �������/�������/������ ����� ������: <a href="javascript:%20x()" onclick="DoSmilie('����� ��� �������');"><img src="/����_�_��������.png" alt=""></a> (� ����� /js/qsmiles.php), ����� � � ��-������ <a href="javascript:tag('�������� ����', '�������� ����')"><img src="/����_�_��������.png" alt=""></a> (� ����� /js/qbbcodes.php).

�� ���� �������� ��� ���� ����������� ������ � ���������, ������ �� e-mail: DCMS_WAP@spaces.ru
����� ��������� ��� ����� ����, �� �������, ���������!