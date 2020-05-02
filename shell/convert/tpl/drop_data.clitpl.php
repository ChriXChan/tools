<?php
// 需要生成的字段列表，为空则生成全部字段
$a2 = array(2,"drop",array('id','item_id'));
$a3 = array(3,"dropnormal",array('id','item_id'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a2,$a3
);
buildJson($array, $xml_data);
?>

