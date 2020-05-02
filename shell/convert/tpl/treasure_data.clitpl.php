<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(5,"1",array('id','loss','gain','max','counts','boxID'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1
);
buildJson($array, $xml_data);
?>			
