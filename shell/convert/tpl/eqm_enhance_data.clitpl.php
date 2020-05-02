<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"base",array('lev','loss','prob'));
$a2 = array(2,"suit",array('suit_id','next_suit_id','lev','attr'));
$a3 = array(3,"attr",array('pos','lev','attr'));
$a4 = array(4,"limit",array('item_id','lev','next_lev','get_way'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4
);
buildJson($array, $xml_data);
?>

