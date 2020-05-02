<?php
// 需要生成的字段列表，为空则生成全部字段
$c1 = array('custom_show', 'max_wave', 'box_show', 'max_collect', 'guild_guard_mon_cond');
$a1 = array(1,"base",array('label','value'));
$a2 = array(2,"holy",array('flag_lev','flag_lev','flag_exp','attr','master_attr','max_member','step','max_skill_level'));
$a3 = array(3,"welfare",array('level','job','reward'));
$a4 = array(4,"skill",array('skill_id','skill_level','loss','attr'));
$a5 = array(5,"prestige",array('id','id','name','reputation','total_count'));
$a6 = array(6,"act",array('id','active'));
$a7 = array(7,"towerDefend",array('label','value', 'CLI_FIELDS'=>$c1));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4,$a5,$a6,$a7
);
buildJson($array, $xml_data);
?>