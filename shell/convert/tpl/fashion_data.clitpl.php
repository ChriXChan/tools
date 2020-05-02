<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"1",array('id','res_id','client_res_id','main_type','sub_type','name','activate_type','activate_contition','activate_consume','attr','culID','aniH','get_way','sort','desc','hasStep'));
$a2 = array(2,"2",array('id','res_id','name','activate_contition','need_item','attr','ratio','culID','get_way','sort','hasStep','isSkin'));
$a3 = array(3,"3",array('unique_id','id','step','star','max_bless','loss','attr','skin','client_res_id','hasStep','culID'));
$a4 = array(4,"4",array('unique_id','id','step','star','max_bless','loss','attr','skin','client_res_id','hasStep','culID','ratio'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $a1,$a2,$a3,$a4
);
buildJson($array, $xml_data);
?>