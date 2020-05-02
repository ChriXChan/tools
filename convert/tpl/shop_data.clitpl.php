<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','shop_type','sort','base_id','num','bind','name','price','limit','limit_p','goods_tips','show_cond','show_param'));
$a2 = array(2,"2",array('id','count','gold','num'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2
);
buildJson($array, $xml_data);
?>

