<?php

//表2挂机点
$s2 = array(2, 'monsterpoint', array('index', 'id', "rawid", "posx", "posy", "autofindmpdelay", "is_hangup", "is_see"));
//表3传送点
$s3 = array(3, 'exits', array('index', 'id', "title", "posx", "posy", "radius", "sid", "tx", "ty", "cid", "is_see"));
//表4npc
$s4 = array(4, 'npc', array('index', 'id', "npctitle", "rawid", "usetype", "radius", "vradius", "posx", "posy", "order", "dialogid", "dir", "turn_dir_type","is_show","is_see"));
//表5场景特效
$s5 = array(5, 'npceffect', array('index', 'id', "posx", "posy", "effid", "eff_layer", "is_ignore","eff_type"));
$s7 = array(7, 'jumpcross', array('index', 'x1', "y1", "x2", "y2", "scene"));
$s6 = array(6, 'jumpexit', array('index', 'id', "title", "posx", "posy", "radius", "tx", "ty", "jump_action", "cid", "is_see","param"));

$s1 = array(1, '1', array('id', 'name', 'desc', 'maptype', 'resid', 'mapbg','limit_num', 'off_x', 'off_y', 'pkflag', 'teleportflag', 'safeposx', 'safeposy', 'lowlevel', 'low_zhuanshu', 'music', 'level_range', 'auto', 'monsterpoint'=>$s2, 'exits'=>$s3, 'npc'=>$s4, 'npceffect'=>$s5, 'relivepoint', 'dup_id', 'role_down_light', 'role_down_light_alpha', 'jump_cross'=>$s7, 'jump' => $s6,'coordinate','is_shoes','weather','intro_id', 'relive_type'));

$s8 = array(8, 'trap', array('id', 'sceneid', "posx", "posy", "effid", "layer", "radius", "normal", "move", "jump"));
$s9 = array(9, 'areaeffect', array('id', 'eff', "eff_gap", "fastmove_eff", "fastmove_gap", "jumpstart_eff", "jumpend_eff"));

//有N个表就生成N个array，变量名和顺序对应上面的
$array = array(
    $s1,$s8,$s9
);
buildJson($array, $xml_data);
?>

