<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('suit_id','next_suit_id','total','attr'));
$a2 = array(2,"2",array('base_id','attr','loss','next_id','lev','type'));
$a3 = array(3,"3",array('pos','lev'));
$a4 = array(4,"4",array('lev','score'));
$a5 = array(5,"5",array('id','eqm_pos','pos','item_type','desc','mall_id'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4,$a5
);
buildJson($array, $xml_data);
?>			
