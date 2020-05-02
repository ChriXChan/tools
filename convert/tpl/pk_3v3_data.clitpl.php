<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"level",array('id','lev','win_reward','lose_reward'));
$a2 = array(2,"other",array('label','value','desc'));
$a3 = array(3,"title",array('title','res','size'));
$a6 = array(6,"scoreReward",array('score','reward'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3,$a6
);
buildJson($array, $xml_data);
?>

