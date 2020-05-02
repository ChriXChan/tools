
<?php
// 需要生成的字段列表，为空则生成全部字段
$a = array(1,"1",array('id','tab','open_type','open_value','upgrade_type','prev_id','skin_id','skill_id','skill_get_lv',"name","culID","culFight","hasAD",'hasRune','sort','rune_image'));
$a2 = array(2,"2",array('key','id','lv','loss','exp_add','exp_max','attr','role_lv',"dec","ext_cond",'upgrade_type'));
//阵法
$a3 = array(3,"3",array('label','value','plain'));
//天书获得引导
$a4 = array(4,"4",array('id','id','book_id','show','tab','desc','sort'));
$a5 = array(5,"5",array('num','id','hole','hole_type','open_lv','name','getway','desc'));
$a6 = array(6,"6",array('id','base_id','lv','m_exp','lv_exp','name','b_attr','suit','item_type'));
$a7 = array(7,"7",array('id','base_id','attr','attr_per','open_lv','type_name'));
$a8 = array(8,"8",array('id','suit_id','num','s_attr','s_name'));
$a9 = array(9,"9",array('day','reward'));
$a10 = array(10,"10",array('id','exp'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$a9,$a10
);
buildJson($array, $xml_data);
?>

