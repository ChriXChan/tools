<?php

//表2任务内容
//$s2 = array(2, 'subtask', array('index', 'id', "targetName", "type", "targetId", "amount", "sceneId", "scene_name", "x", "y", "teleportflag"));
$s1 = array(1, '1', array('id', 'content', 'show_lev', 'show_pos', 'show_prefixes', 'hiden_map'));
$s2 = array(2, '2', array('id', 'subject', 'content'));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $s1, $s2
);
buildJson($array, $xml_data);
?>

