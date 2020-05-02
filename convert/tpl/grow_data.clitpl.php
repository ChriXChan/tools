<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"base",array('type','step', 'loss','attr','reward','zz_num','cz_num','clean','wish_max','skin_id'));
$a2 = array(2,"skill",array('type','lv','attr','name'));
$a3 = array(3,"dan",array('type','type', 'zz_id','cz_id','zz_attr','cz_attr','cz_attr_percent'));
$a4 = array(4,"talent",array('type','type','list'));
$a5 = array(5,"equip",array('type','pos', 'name','getway','desc'));
$a6 = array(6,"other",array('type', 'fun_open_id','equip_group'));
$a7 = array(8,"upgrade",array('id','id','type','step','gain','prompt','desc','getway','open_day'));
$a8 = array(9,"wish",array('day','type'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8
);
buildJson($array, $xml_data);
?>

