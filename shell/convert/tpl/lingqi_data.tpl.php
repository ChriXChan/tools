%% -----------------------------------------------------------------------------
%% 宠物数据
%% @author lijingfeng
%% -----------------------------------------------------------------------------
-module(lingqi_data).

-export([
    get_lingqi/1
    ,get_lingqi_update/3

    ,get_equip_upgrade/1
    ,get_equip_level/3
]).

-include("lingqi.hrl").
-include("gain.hrl").
-include("item.hrl").


%%灵器基础数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "get_lingqi(" . $data[$i]['id'] . ") -> #lingqi_data{id = " . $data[$i]['id'] .
            ", condition = ".$data[$i]['cond'] .
            ", cond_level = " . $data[$i]['cond_level'] . "};\n";
    }
}
?>
get_lingqi(_) -> false.


%%灵器升级
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "get_lingqi_update(" . $data[$i]['id'] .",".$data[$i]['stage'].",".$data[$i]['star'].") -> #lingqi_update_data{id = " . $data[$i]['id'] .
            ", stage = ".$data[$i]['stage'] .
            ", star = ".$data[$i]['star'] .
            ", max_bless = ".$data[$i]['max_bless'] .
            ", is_update = ".$data[$i]['is_update'] .
            ", succ = [".$data[$i]['succ'] . ']'.
            ", bless_range = ".$data[$i]['bless_range'] .
            ", loss = ".gen_record($data[$i]['loss']).
            ", attr = [" . attr_to_int($data[$i]['attr']) ."]};"."\n";
    }
}
?>
get_lingqi_update(_,_,_) -> false.


%% 灵器装备提升品质数据
<?php
$data = $xml_data[2];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[ $i ];
?>
get_equip_upgrade(_EquipId = <?php echo $row['id']; ?>) -> {<?php echo gen_record($row['loss']);?>, <?php echo $row['next_id']; ?>, <?php echo $row['last_id']; ?>};
<?php } ?>
get_equip_upgrade(_EquipId) -> false.


%% 灵器装备升级数据
<?php
$data = $xml_data[3];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[ $i ];
?>
get_equip_level(_LingqiId = <?php echo $row['lingqi_id']; ?>, _Pos = <?php echo $row['pos']; ?>, _Lev = <?php echo $row['level']; ?>) ->
    #lingqi_equip_level_data{
        id = <?php echo $row['lingqi_id'];?><?php echo "\n";?>
        ,pos = <?php echo $row['pos'];?><?php echo "\n";?>
        ,step = <?php echo $row['step'];?><?php echo "\n";?>
        ,lev = <?php echo $row['level'];?><?php echo "\n";?>
        ,attr = [<?php echo attr_to_int($data[$i]['attr']); ?>]<?php echo "\n";?>
        ,loss = <?php echo gen_record($row['loss']);?><?php echo "\n";?>
    };
<?php } ?>
get_equip_level(_LingqiId, _Pos, _Lev) -> false.
