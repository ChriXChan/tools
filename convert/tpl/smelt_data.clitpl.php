<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"exchange",array('item','cost','limit','role_zhuanshu','is_reset','sort'));
$a2 = array(2,"lev",array('lev','addition','cond'));
$a3 = array(4,"vip",array('vip_lev','num'));
$a4 = array(6,"lottery",array("lev",'one_cost','ten_cost','item'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4
);
buildJson($array, $xml_data);
?>