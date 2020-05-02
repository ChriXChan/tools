<?php
// 需要生成的字段列表，为空则生成全部字段
$a1 = array(1,"base",array('floor','safe','reborn','kill_num','scene','pass_reward'));
$a2 = array(2,"other",array('label','value'));
$a3 = array(3,"scoreReward",array('score','reward'));
$a5 = array(5,"collectSkill",array('id','skill','title','desc'));
$a6 = array(6,"title",array('title','res','size'));
$a8 = array(8,"skill",array('skill_id','energy','short_key'));
$a9 = array(9,"collectPt",array('id','pos','scene','mon_pos','desc'));
$a10 = array(10,"rankReward",array('rank','reward','label'));
$a11 = array(11,"lingqiReward",array('score2','redpacket','score'));
//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
	$a1,$a2,$a3,$a5,$a6,$a8,$a9,$a10,$a11
);
buildJson($array, $xml_data);
?>

