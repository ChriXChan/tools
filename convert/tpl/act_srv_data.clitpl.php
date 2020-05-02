<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','ver','index','type', 'plat_limit'));
$a2 = array(2,"2",array('id','act_id','ver','day','loss','gain','conds','ex_rule'));
$a3 = array(3,"3",array('id','loss','day','gain2','init_gold','add_gold','gain1_show','pool_name','add_desc'));
$a4 = array(4,"4",array('label','value'));
$a5 = array(5,"5",array('id','day','cond','gain','act_id','ver','guide','url','icon_id'));
$a6 = array(6,"6",array('id','day','cond','gain'));
$a7 = array(7,"7",array('id','cond','gain'));
$a8 = array(8,"8",array('id','day','cond','limit','gain','loss','discount_type'));
$a9 = array(9,"9",array('id','act_id','ver','day','gain','limit','gold'));
$a10 = array(10,"10",array('id','act_id','ver','day','gain','gain_first','val','type'));
$a11 = array(11,"11",array('id','act_id','ver','day','gain_1','gain_2','gain_3','gain_4','rank_step','step','title','type'));
$a12 = array(12,"12",array('id','chief_reward','reward','desc','open_view'));
$a13 = array(13,"13",array('id','act_id','ver','day','reward'));
$a14 = array(14,"14",array('id','act_id','ver','gold','reward'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$a9,$a10,$a11,$a12,$a13,$a14
);
buildJson($array, $xml_data);
?>

