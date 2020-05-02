<?php

$s1 = array(1, 'Model', array('id', "frame", "actionNum"));
$s2 = array(2, 'Frame', array('index', "id", "dir_1", "dir_2", "dir_3", "dir_4", "dir_5", "delay", "file_1", "file_2", "file_3", "file_4", "file_5"));
$s3 = array(3, 'WeaponModel', array('id', "frame"));
$s4 = array(4, 'WeaponFrame', array('index', "id", "dir_1", "dir_2", "dir_3", "dir_4", "dir_5", "delay", "file_1", "file_2", "file_3", "file_4", "file_5"));
$s5 = array(5, 'HorseModel', array('id', "frame"));
$s6 = array(6, 'HorseFrame', array('index', "id", "dir_1", "dir_2", "dir_3", "dir_4", "dir_5", "delay", "file_1", "file_2", "file_3", "file_4", "file_5"));
$s7 = array(7, 'WingModel', array('id', "frame"));
$s8 = array(8, 'WingFrame', array('index', "id", "dir_1", "dir_2", "dir_3", "dir_4", "dir_5", "delay", "file_1", "file_2", "file_3", "file_4", "file_5"));
$s9 = array(9, 'WheelModel', array('id', "frame"));
$s10 = array(10, 'WheelFrame', array('index', "id", "dir_1", "dir_2", "dir_3", "dir_4", "dir_5", "delay", "file_1", "file_2", "file_3", "file_4", "file_5"));
$s11 = array(11, 'actionnum', array('index', "attack", "jump", "fastmove"));
$s12 = array(12, 'height', array('id', "value"));
$s13 = array(13, 'layer', array('id', "value"));
$s14 = array(14, 'fabaoy', array('id', "value"));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $s1,$s2,$s3,$s4,$s5,$s6,$s7,$s8,$s9,$s10,$s11,$s12,$s13,$s14
);
buildJson($array, $xml_data);
?>

