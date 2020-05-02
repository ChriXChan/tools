<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','group','label','type','count','require','require_desc','point','items',"way_type"));
$a2 = array(2,"2",array('lev','point','fight','skin','gain'));
$a3 = array(3,"3",array('group','name','title','sort'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3
);
buildJson($array, $xml_data);
?>

