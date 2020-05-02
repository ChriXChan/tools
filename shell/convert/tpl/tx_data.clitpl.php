<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"zone",array('id','id','act_id','act_ver','limit','type','gain'));
$a2 = array(2,"hall",array('id','id','act_id','act_ver','limit','type','gain'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2
);
buildJson($array, $xml_data);
?>

