<?php
include_once '../../../sys/inc/start.php';
include_once '../../../sys/inc/compress.php';
include_once '../../../sys/inc/sess.php';
include_once '../../../sys/inc/home.php';
include_once '../../../sys/inc/settings.php';
include_once '../../../sys/inc/db_connect.php';
include_once '../../../sys/inc/ipua.php';
include_once '../../../sys/inc/fnc.php';
include_once '../../../sys/inc/user.php';
only_reg();
$set['title']='开心农场 :: 技能和筹码';
include_once '../../../sys/inc/thead.php';
title();
aut();

include_once '../../inc/str.php';
farm_event();
echo "<div class='mdlc'><span>技能</span><br /></div><div class='menu'>";
echo "<img src='/plugins/farm/img/plus.gif' alt='' class='rpg' /> <a href='selection.php'>选择</a><br />";
echo "<img src='/plugins/farm/img/shield.gif' alt='' class='rpg' /> <a href='razvedka.php'>侦察</a>";
echo "</div>";
echo "<div class='mdlc'><span>设备</span><br /></div><div class='menu'>";
echo "<img src='/plugins/farm/img/electro.png' alt='' class='rpg' /> <a href='zabor.php'>电栅栏</a> (租金)<br />";
echo "<img src='/plugins/farm/img/tep.gif' alt='' class='rpg' /> <a href='teplica.php'>温室</a>";
echo "</div>";

echo "<div class='rowdown'>";
echo "<img src='/plugins/farm/img/garden.png' alt='' class='rpg' /> <a href='/plugins/farm/garden/'>我的土地</a>";
echo "</div>";
include_once '../../../sys/inc/tfoot.php';
?>