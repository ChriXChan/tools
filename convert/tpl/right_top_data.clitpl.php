<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"righttop",array('id','id','type','sort','hide','tip','eff','layer','open_id','open_view',"subID",'plat_id'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1
);
buildJson($array, $xml_data);
?>

