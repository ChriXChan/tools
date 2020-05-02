<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','name','open_id','sort'));
$a2 = array(2,"2",array('lev','gain'));
$a3 = array(3,"3",array('type','cond','adjust'));
$a4 = array(4,"4",array('label','value'));
$a5 = array(5,"5",array('month','day','reward','ex_reward'));
$a6 = array(6,"6",array('day','reward','vip_lev'));
$a7 = array(7,"7",array('type','value'));
$a8 = array(8,"8",array('id','website'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8
);
buildJson($array, $xml_data);
?>

