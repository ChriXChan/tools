<?php
$s3 = array(3, 'enter', array('id', 'id', 'type', 'effect', 'shake', 'time'));
$s6 = array(6, 'collect', array('id', 'id', 'ing_eff', 'model_eff', 'end_eff'));
$s1 = array(1, '1', array('id', "shield_type", "is_boss", "type", "type2", "lv","lv_dec","name", "cid", "headid","collect_id","hp_bar_count","drop", "volume", "enter"=>$s3, "anti_stun", "anti_recover", "anti_jump", "anti_poison", "anti_taunt", "specval", "area_model", "area_effect", "boss_halo", "init_dir", "dead_fly", "dead_effect", "collect"=>$s6));
$s4 = array(4, '4', array('id', 'content', 'type'));
$s5 = array(5, '5', array('id', 'fumo', 'sex', 'weapon', 'arg'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $s1,$s4,$s5
);
buildJson($array, $xml_data);
?>

