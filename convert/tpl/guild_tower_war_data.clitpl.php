<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"other",array('label','value'));
$a3 = array(3,"scoreReward",array('score','reward'));
$a4 = array(4,"title",array('title','res','size'));
$a5 = array(5,"towerLvUp",array('level','stone'));
$a6 = array(6,"rankReward",array('rank','reward','label'));
$a7 = array(7,"towerPos",array('id','tower_pos'));
$a8 = array(8,"buffID",array('buff2'));
$a10 = array(10,"skill",array('skill_id','energy','short_key'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a3,$a4,$a5,$a6,$a7,$a8,$a10
);
buildJson($array, $xml_data);
?>

