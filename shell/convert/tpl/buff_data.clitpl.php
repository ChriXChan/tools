<?php

$s1 = array(1, '1', array('id', 'lev', "name", "lev", "icon", "time_type", "eff_type", "bodycolor", "color_index", "duration", "disple", "desc", "pos", "script_id","sort_index",'no_cd_mask','effect_id','effect_pos'));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $s1
);
buildJson($array, $xml_data);
?>

