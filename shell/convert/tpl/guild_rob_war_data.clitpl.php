<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"other",array('label','value'));
$a2 = array(2,"boss",array('id','boss_id','mon_id','boss_pos','boss_box_pos'));
$a3 = array(3,"scoreReward",array('score','reward'));
$a4 = array(4,"title",array('title','res','size'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3,$a4
);
buildJson($array, $xml_data);
?>

