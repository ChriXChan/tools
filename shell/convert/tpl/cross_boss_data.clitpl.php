<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','map_id','points','refresh','conds','mon','boss','show_tips'));
$a3 = array(3,"3",array('boss_id','boss_born','roll','hurt1','hurt2','hurt3','hurt4','hurt5','last','drop','drop2','show_tips','first_hurt'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a3
);
buildJson($array, $xml_data);
?>			
