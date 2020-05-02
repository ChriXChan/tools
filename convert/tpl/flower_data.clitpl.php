<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','color','name','charm','spouse_sweetness','gain','effect_id','can_buy'));
$a2 = array(2,"2",array('id','content'));
$a3 = array(3,"weather_pri",array('id','id','id_pri','cla','cla_pri'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3
);
buildJson($array, $xml_data);
?>

