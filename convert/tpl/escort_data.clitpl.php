<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('quality','gain','speed_add','up_loss','one_loss','title'));
$a2 = array(2,"2",array('skill_id','cost','max','sort'));
$a3 = array(3,"3",array('label','val'));
$a4 = array(4,"4",array('id','lev','quality','end_exp'));
$a5 = array(5,"5",array('rank','gain'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4,$a5
);
buildJson($array, $xml_data);
?>		