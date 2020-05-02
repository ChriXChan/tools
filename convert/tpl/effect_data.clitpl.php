<?php

$s1 = array(1, '1', array('id', "src","isloop","layer","dirtype","d_1","d_2","d_3","d_4","d_5","israndomstart","specified_start","specified_end","isblendmode","delay","playtime","scalex","scaley","rotation","needPlay", "dis", "hit_pos", "is_float"));

$s2 = array(2, '2', array('id', "effectId_arr"));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $s1, $s2
);
buildJson($array, $xml_data);
?>

