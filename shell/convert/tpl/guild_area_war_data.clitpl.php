<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"base",array('area','color','scene','reward','name','ui_sort','pos','is_area_war'));
$a2 = array(2,"other",array('label','value'));
$a3 = array(3,"score_personal",array('score','reward'));
$a6 = array(6,"title",array('title','res','size'));
$a7 = array(7,"skill",array('skill_id','energy','short_key'));


//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3,$a6,$a7
);
buildJson($array, $xml_data);
?>

