<?php
// 需要生成的字段列表，为空则生成全部字段
$a = array(1,"1",array('id','type','name','name_color','skill_id','activate_props','attr','skin_id','culID','talent_tip','talent_name','skill_name',"sort","showneed","hasAD"));
$a2 = array(2,"2",array('num','skill_id','skill_level','attr','need_item','item_count',"skill_step"));
//阵法
$a3 = array(3,"3",array('id','main_pet','sub_pet','skill_id','name',"sort","skill_name","showneed"));
$a4 = array(4,"4",array('num','id','level','star','wish_max','wish_rand','wish_range','succ','star_loss','attr','skill_id'));
$a5 = array(5,"5",array('num','skill_id','skill_level','attr'));
$a6 = array(6,"6",array('num','type','pos','name','getway','desc'));
$a7 = array(7,"7",array('id','loss','next_id','pos','type','last_id','score'));
$a8 = array(8,"8",array('num','id','type','step','loss','attr','equip_step','lev','wish_max'));
$a9 = array(9,"9",array('equip','dug'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$a9
);
buildJson($array, $xml_data);
?>

