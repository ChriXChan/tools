<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"limit",array('color','zhuanshu', 'max_qx','max_fy','max_gj'));
$a2 = array(2,"base",array('base_id','base_id','pos','attr'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2
);
buildJson($array, $xml_data);
?>

