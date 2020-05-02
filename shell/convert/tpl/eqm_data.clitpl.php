<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"equip",array('id','num','prob1','prob2','prob3','prob4','prob5','prob6','prob7','prob10','prob11'));
$a2 = array(2,"pool",array('id','pool'));
$a3 = array(3,"equipgather",array('id','num','attr','gain','name','skin','group','fightingNum'));
$a4 = array(4,"equipgathergroup",array('item_id','group','get_way'));
$a5 = array(5,"eqmred",array('orange_id','cost','red_id'));
$a6 = array(6,"eqmredmat",array('red_id','mt','add'));
$a7 = array(7,"ring",array('level','level','score','skill','name'));
$a8 = array(8,"score",array('red_id','score'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8
);
buildJson($array, $xml_data);
?>

