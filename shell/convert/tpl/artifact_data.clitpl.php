<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"attr",array('id','job','ratio'));
$a2 = array(2,"base",array('id','type','link','open_view','desc','name_ui','attr'));
$a3 = array(3,"other",array('label','value'));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3
);
buildJson($array, $xml_data);
?>

