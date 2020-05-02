<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"base",array('type','group','desc','view','data','level','npc','param'));
$a2 = array(2,"list",array('list_type','list','title'));
$a3 = array(3,"recommend",array('sort','type','desc','min_lev','max_lev'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3
);
buildJson($array, $xml_data);
?>

