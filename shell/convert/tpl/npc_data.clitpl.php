<?php

$s1 = array(1, '1', array('id', "name", "cid", "notshadow", "notname", "notclick", "title"));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $s1,
);
buildJson($array, $xml_data);
?>

