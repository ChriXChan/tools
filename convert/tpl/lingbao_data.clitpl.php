<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"star",array('id','lev','loss','attr','name','position','getway'));
$a2 = array(2,"level",array('id','lev','loss','attr','getway'));
$a3 = array(3,"skill",array('id','skill_id','skill_desc','res_id','act'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3
);
buildJson($array, $xml_data);
?>
