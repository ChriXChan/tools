<?php
// 需要生成的字段列表，为空则生成全部字段
$a3 = array(3,"gcd",array('gcd','gcd', 'cd'));
$a4 = array(4,"career",array('career','max', 'min'));
$a2 = array(2,"desc",array('id','desc_calc','desc'));
$a1 = array(1,"base",array('id','id','name','genre','skill_type','max_lv','dis','num','range','radius','center','type','efftype','ig_cd', 'cd','gcd'=>$a3,'priority','pose_time','icon','sc', 'attack_index', 'hit_index', 'spectype', 'spectime','down_horse','desc'=>$a2,'open_type', 'c_need_target', 'pre_attack_type'));
$a5 = array(5,"5",array('id','lev','conds','loss'));
$a6 = array(6,"6",array('id','lev','fc'));
$a8 = array(8,"talent",array('id','val'));
$a9 = array(9,"comb",array('id','main_id', 'secondary_id', 'target_id','type','desc','tab'));
$a10 = array(10,"combTemp",array('id','skill_id', 'opentype','type','desc'));
$a11 = array(12,"advance",array('skill_id','fun','type','sort'));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a9,$a10,$a4,$a11
);
buildJson($array, $xml_data);
?>

