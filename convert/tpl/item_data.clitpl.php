<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"item",array('base_id','icon','name','group','type','color','star','overlap','use_type','drop','smelt','zhuanshu','lev','condition','effect','attr','extra','desc','desc_output','openview','isuseall','sort'));
$a2 = array(2,"pos",array('id','pos','step'));
$a3 = array(3,"proptype",array('type','desc','group'));
$a5 = array(5,"market",array('first','first','mapping','childs'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a5
);
buildJson($array, $xml_data);
?>