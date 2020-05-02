<?php
// 需要生成的字段列表，为空则生成全部字段
$c1 = array('force_ts_max','force_ts_shop_one');
$a1 = array(1,"1",array('id','map_id','loss','points','refresh','boss_id','roll','hurt1','hurt2','hurt3','hurt4','hurt5','last','drop','drop2','box_reward','box_loss','show_tips','first_hurt','showStar'));
$a4 = array(4,"4",array('label','value', 'CLI_FIELDS'=>$c1));
$a5 = array(5,"5",array('times','loss'));
$a6 = array(6,"6",array('vip','times'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a4,$a5,$a6
);
buildJson($array, $xml_data);
?>			
