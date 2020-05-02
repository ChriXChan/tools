<?php
$s1 = array(1, 'base', array('id', 'name', 'next_main', 'desc1', 'desc2', 'desc3', 'type', 'level', 'accept_npc', 'commit_npc', 'award', 'showReward', 'auto_submit', 'chapter', 'chapter_title', 'chapter_progress', 'progress', 'fly', 'transfer', 'jump'));
$s2 = array(2, 'dailyStep', array('num', 'reward'));
$s3 = array(3, 'gDailyStep', array('num', 'reward'));
$s6 = array(6, 'daily', array('label', 'reward', "circle","cost","reset"));
$s9 = array(9, 'other', array('label', 'value'));
$s10 = array(10, 'simpleTask', array('id', 'award', 'progress'));
$s12 = array(12, 'dailyLuckyDraw', array('pos', 'item_id'));
$s14 = array(14, 'funRemind', array('id', 'sort', 'title', 'link', 'open_view', 'comp_hide', 'dug_type'));
$s15 = array(15, 'xuanshangBox', array('pos', 'reward'));
$s17 = array(17, 'cityWarTaskReward', array('id', 'loss', 'own_box', 'box'));
$s18 = array(18, 'cityWarTaskProg', array('id', 'num','own_num_reward','num_reward'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $s1,$s2,$s3,$s6,$s9,$s10,$s12,$s14,$s15,$s17,$s18
);
buildJson($array, $xml_data);
?>

