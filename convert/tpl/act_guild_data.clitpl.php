<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','act_id','act_ver','day','gain1','gain2','gain3','color'));
$a2 = array(2,"2",array('id','act_id','act_ver','day','gain1','gain2','gain3','is_master'));
$a3 = array(3,"3",array('id','act_id','act_ver','day','type'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3
);
buildJson($array, $xml_data);
?>

