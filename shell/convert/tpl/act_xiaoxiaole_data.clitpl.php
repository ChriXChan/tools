<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','act_id','ver','obj_id','obj_name','gain','xiaoxiao_award'));
$a3 = array(3,"3",array('id','act_id','ver','type','num','limt','cost_list','extra_gain'));
$a4 = array(4,"4",array('id','act_id','ver','daily_free_clean_cnt','add_cnt_lottery_cnt'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a3,$a4
);
buildJson($array, $xml_data);
?>

