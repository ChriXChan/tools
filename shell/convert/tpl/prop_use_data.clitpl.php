<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"propuse",array('base_id','type','desc','view','icon','title','noalert','close_time','close_label','btn_word','close_btn','lev','param','noalert_type','limit','trigger'));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1
);
buildJson($array, $xml_data);
?>

