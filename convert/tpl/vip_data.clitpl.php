<?php
// 需要生成的字段列表，为空则生成全部字段
$c1 = array('infinite_trans', 'pet_add_rate', 'stren_add_rate', 'exp_add_rate', 'task_add_rate','add_bind_yuan','tianzhun');
$a1 = array(1,"level",array('lev','lev','gold','lev_item','lev_title','week_item','show_id','show_sex','show_list'));
$a2 = array(2,"vipAtt",array('index','type','desc','flag','V1','V2','V3','V4','V5','V6','V7','V8','V9','V10'));
$a3 = array(3,"privilege",array('type','cost_gold','cost_gold_valid','cost_item','valid','gain','buff_id','doc',"forever_doc",'pic','name','fight_num','buy_doc','show_sex','act_tips'));
$a4 = array(4,"picDec",array('pic_id','dec'));
$a5 = array(5,"privilegeAtt",array('label','dec','value', 'CLI_FIELDS'=>$c1));
$a6 = array(6,"6",array('id','desc'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3,$a4,$a5,$a6
);
buildJson($array, $xml_data);
?>


