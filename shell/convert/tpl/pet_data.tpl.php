%% -----------------------------------------------------------------------------
%% 宠物数据
%% @author lijingfeng
%% -----------------------------------------------------------------------------
-module(pet_data).

-export([
        get_pet/1
        ,get_pet_skill/2
        ,get_pet_zhenfa/1
        ,get_pet_zhenfa_level/3
        ,get_pet_zhenfa_skill/2

        ,get_equip_upgrade/1
        ,get_skill_step/2
    ]).

-include("pet.hrl").
-include("gain.hrl").
-include("item.hrl").

%%宠物基础数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
    	echo "get_pet(" . $data[$i]['id'] . ") -> #pet_data{id = " . $data[$i]['id'] .",type = ".$data[$i]['type'].', name = <<"'.$data[$i]['name'].'">>' .
            ", skill_id = " . $data[$i]['skill_id'] . ", activate_props = ". gen_record($data[$i]['activate_props']).
            ", attr = [" . attr_to_int($data[$i]['attr']) ."]".",skin_id = ".$data[$i]['skin_id']."};". "\n";
    }
}
?>
get_pet(_) -> false.


%%宠物技能
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['skill_id']))!=""){
    	echo "get_pet_skill(" . $data[$i]['skill_id'] ."," .$data[$i]['skill_level'] . 
    	") -> #pet_skill_data{skill_id = " . $data[$i]['skill_id'] .",skill_step = " .$data[$i]['skill_step'] .",skill_level = " .$data[$i]['skill_level'] .", attr = [" 
    	 .attr_to_int($data[$i]['attr']) ."],need_item = ". $data[$i]['need_item'].",item_count = ". $data[$i]['item_count'] ."};". "\n";
    }
}
?>
get_pet_skill(_,_) -> false.


%%宠物阵法
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
    	echo "get_pet_zhenfa(" . $data[$i]['id'] .") -> #pet_zhenfa_data{id = " . $data[$i]['id'] .",main_pet = " .$data[$i]['main_pet'] .", sub_pet = [" 
    	 .$data[$i]['sub_pet']."],skill_id = ". $data[$i]['skill_id'].',name = <<"'. $data[$i]['name'].'">>'."};". "\n";
    }
}
?>
get_pet_zhenfa(_) -> false.



%%宠物阵法升级
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
    	echo "get_pet_zhenfa_level(" . $data[$i]['id'] .",".$data[$i]['level'].",".$data[$i]['star'].") -> #pet_zhenfa_level_data{id = " . $data[$i]['id'] .",level = " .$data[$i]['level'] 
    	.",star = ".$data[$i]['star'].",wish_max = ".$data[$i]['wish_max'].",wish_rand = [".$data[$i]['wish_rand']."]".
    	",wish_range = [".$data[$i]['wish_range'] . "],succ = ".$data[$i]['succ'].", star_loss = ".gen_record($data[$i]['star_loss']).",attr = [". attr_to_int($data[$i]['attr'])."],skill_id =". $data[$i]['skill_id']."};". "\n";
    }
}
?>
get_pet_zhenfa_level(_,_,_) -> false.

%%宠物阵法技能
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['skill_id']))!=""){
    	echo "get_pet_zhenfa_skill(" . $data[$i]['skill_id'] .",".$data[$i]['skill_level'].") -> #pet_zhenfa_skill_data{skill_id = " . $data[$i]['skill_id'] .",skill_level = " .$data[$i]['skill_level'] .", attr = [". attr_to_int($data[$i]['attr'])."]};". "\n";
    }
}
?>
get_pet_zhenfa_skill(_,_) -> false.


%% 宠物装备提升品质数据
<?php
$data = $xml_data[6];
for ($i = 2; $i < count($data); $i++) {
	$row = $data[ $i ];
?>
get_equip_upgrade(_EquipId = <?php echo $row['id']; ?>) -> {<?php echo gen_record($row['loss']);?>, <?php echo $row['next_id']; ?>, <?php echo $row['last_id']; ?>};
<?php } ?>
get_equip_upgrade(_EquipId) -> false.


%% 宠物技能阶数数据
<?php
$data = $xml_data[7];
for ($i = 2; $i < count($data); $i++) {
	$row = $data[ $i ];
?>
get_skill_step(_PetId = <?php echo $row['id']; ?>, _Step = <?php echo $row['step']; ?>) ->
	#pet_skill_step_data{
        id = <?php echo $row['id'];?><?php echo "\n";?>
        ,step = <?php echo $row['step'];?><?php echo "\n";?>
        ,loss = <?php echo gen_record($row['loss']);?><?php echo "\n";?>
        ,attr = [<?php echo attr_to_int($data[$i]['attr']); ?>]<?php echo "\n";?>
        ,wish_rand = [<?php echo $row['wish_rand'];?>]<?php echo "\n";?>
        ,wish_range = <?php echo $row['wish_range'];?><?php echo "\n";?>
        ,equip_step = <?php echo $row['equip_step'];?><?php echo "\n";?>
        ,lev = <?php echo $row['lev'];?><?php echo "\n";?>
        ,wish_max = <?php echo $row['wish_max'];?><?php echo "\n";?>
    };
<?php } ?>
get_skill_step(_PetId, _Step) -> false.
