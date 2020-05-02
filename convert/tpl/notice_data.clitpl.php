<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','id','show_lev','show_pos','show_style','hiden_map'));
$a2 = array(2,"2",array('id','level'));
$a3 = array(3,"3",array('id','level'));
$a4 = array(4,"4",array('id','content','type'));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4
);
buildJson($array, $xml_data);
?>

