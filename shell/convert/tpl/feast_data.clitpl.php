<?php
// 需要生成的字段列表，为空则生成全部字段
$s1 = array(1,"1",array('color','color','table_num','role_num','dig_num','cost','pos','mon','name','subject','host_reward','guest_reward','order'));
$s2 = array(2,"2",array('index','index','time'));
$s3 = array(3,"3",array('index','refresh_time'));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$s1,$s2,$s3
);
buildJson($array, $xml_data);
?>

