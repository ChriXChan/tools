
<?php
// 需要生成的字段列表，为空则生成全部字段

$a1 = array(1,"1",array('level','times','box','tips','mondec'));
$a2 = array(5,"5",array('index','id','lev','attr','attr_grow','hurt1','hurt2','hurt3','hurt4','hurt5','last','drop','drop2','show'));
$a3 = array(3,"3",array('label','val','desc'));
$a4 = array(4,"4",array('res','reward'));
$a5 = array(6,"6",array('id','sub_lev'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4,$a5
);
buildJson($array, $xml_data);
?>

