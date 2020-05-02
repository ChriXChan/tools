<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"map",array('music','music','type','name'));
$a2 = array(2,"skill",array('music','music','type','name'));
$a3 = array(3,"effect",array('music','music','type','name'));
$a4 = array(4,"npc",array('music','music','type','name'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3,$a4
);
buildJson($array, $xml_data);
?>

