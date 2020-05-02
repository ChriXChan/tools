<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"fun_open",array('open_id','open_id','fun_name','open_type','open_lv','open_day','lev','open_eff','fun_tip','sub_fun','open_ind'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1
);
buildJson($array, $xml_data);
?>

