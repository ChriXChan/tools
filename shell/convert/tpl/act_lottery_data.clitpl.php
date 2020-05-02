<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','act_id','ver','day','gain'));
$a4 = array(4,"4",array('id','act_id','ver','num','cost_gold','cost_silver','limit'));
$a5 = array(5,"5",array('act_id','ver','num'));
$a6 = array(6,"6",array('id','act_id','ver','day','gain','point','limit'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a4,$a5,$a6
);
buildJson($array, $xml_data);
?>

