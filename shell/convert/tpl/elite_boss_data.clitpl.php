<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','map_id','points','boss_id','loss','roll','hurt1','hurt2','hurt3','last','drop','drop2','show_tips'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1
);
buildJson($array, $xml_data);
?>
