<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('type'));
$a2 = array(2,"2",array('type','item'));
$a3 = array(3,"3",array('id','type','limit','gain','loss','old_price'));
$a4 = array(4,"4",array('type','title'));
$a5 = array(5,"5",array('type','boss','gain','limit','dug_id'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3,$a4,$a5
);
buildJson($array, $xml_data);
?>

