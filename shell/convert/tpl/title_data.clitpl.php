<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"title",array('id','id','name','srvid','type','attr','unique','act_desc','title_desc','open_type','act_show','act_show_desc','high'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1
);
buildJson($array, $xml_data);
?>

