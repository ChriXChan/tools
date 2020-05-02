<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"cell",array('cell','start_pos', 'row','col','loss','res'));
$a2 = array(2,"times",array('times','loss','num'));
$a3 = array(3,"other",array('label','value'));
$a4 = array(4,"pro",array('num','reward'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4
);
buildJson($array, $xml_data);
?>

