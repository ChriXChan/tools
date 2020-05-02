<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"output",array('type','type', 'per','total','open_id','desc','tip','fly','sort','reset','findback'));
$a2 = array(2,"base",array('step','star','value','reward','attr','name','type','period','rein','rein_req'));
$a3 = array(3,"other",array('label','value'));
$a4 = array(4,"reward",array('id','id', 'reward'));
$a5 = array(5,"steps",array('type','steps'));
$a6 = array(6,"6",array('type','index'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4,$a5,$a6
);
buildJson($array, $xml_data);
?>

