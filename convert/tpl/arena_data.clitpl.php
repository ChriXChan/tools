<?php
// 需要生成的字段列表，为空则生成全部字段
$a = array(1,"1",array('rank','gain','title'));
$a2 = array(2,"2",array('id','num','gain'));
$a3 = array(3,"3",array('count','loss'));
$a4 = array(4,"4",array('label','val','desc'));
$a5 = array(6,"6",array('rank','mon_id','scene_id','attr'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a,$a2,$a3,$a4,$a5
);
buildJson($array, $xml_data);
?>

