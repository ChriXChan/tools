<?php
// 需要生成的字段列表，为空则生成全部字段
$a = array(1,"1",array('then_lv','then_cos','attr','wish_max','wish_rand','wish_range','max_use','special_max_use','index_arr'));
$a2 = array(2,"2",array('then_type','then_attr','pos','icon','prop_id','tips'));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a,$a2
);
buildJson($array, $xml_data);
?>

