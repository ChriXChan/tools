<?php
// 需要生成的字段列表，为空则生成全部字段
//$a1 = array(1,"base",array('color','color','cost','reward','desc','name'));
//$a3 = array(3,"flower",array('color','color','loss','gain','friend_gain'));
//$a4 = array(4,"effect",array('id','id','id_pri','cla','cla_pri'));
//$a5 = array(5,"message",array('id','id','content'));
$a1 = array(1,"wedding",array('color','desc','cost','reward_male_client','reward_female_client','name','title'));
$a2 = array(2,"other",array('label','value'));
$a3 = array(3,"ringAndchild",array('num','type','step','res_id','skill_desc','attr_act_need_we_step','attr_ratio','culID'));
$a4 = array(4,"ringAndchildStep",array('num','type','step','star','is_update','max_bless','succ','bless_range','loss','attr'));
$a5 = array(5,"talk",array('id','desc'));
//$a7 = array(8,"time",array('time','time','time_end'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3,$a4,$a5
);
buildJson($array, $xml_data);
?>