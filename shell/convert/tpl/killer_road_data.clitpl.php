<?php
// 需要生成的字段列表，为空则生成全部字段
$a2 = array(2,"other",array('label','value'));
$a4 = array(4,"scoreReward",array('score','reward'));
$a5 = array(5,"title",array('title','res','size'));
$a6 = array(6,"skill",array('skill_id','energy','short_key'));


//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a2,$a4,$a5,$a6
);
buildJson($array, $xml_data);
?>

