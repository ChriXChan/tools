<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('only_id','id','index','target1','target2','target3','gain1','gain2','gain3'));
$a2 = array(2,"2",array('label','value'));
$a3 = array(3,"3",array('id','open_day'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3
);
buildJson($array, $xml_data);
?>