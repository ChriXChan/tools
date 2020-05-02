%% -----------------------------------------------------------------------------
%% 狂暴BOSS数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(rage_boss_data).

-export([
        get/1
        ,hp_absorb_skill/1
        ,get_boss/1

        ,all/0
    ]).

-include("rage_boss.hrl").
-include("gain.hrl").

%% 地图数据
<?php
$data = $xml_data[0];
$allids = array();
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
    $allids[] = $row['map_id'];
?>
get(_MapId = <?php echo $row['map_id']?>) ->
    #rboss_base{
        map_id = <?php echo $row['map_id']?><?php echo "\n"?>
        ,boss_id = [<?php echo $row['boss_id']?>]<?php echo "\n"?>
        ,boss_born = [<?php echo $row['boss_born']?>]<?php echo "\n"?>
        ,boss_lines = <?php if (trim($row['boss_lines']) == '') { echo '[]'; } else { echo '[' . trim($row['boss_lines']) . ']'; }?><?php echo "\n"?>
        ,boss_num = <?php echo $row['boss_num']?><?php echo "\n"?>
        ,boss_max = <?php echo $row['boss_max']?><?php echo "\n"?>
    };
<?php }?>
get(_) ->
    false.

%% BOSS血盾技能
<?php
$data = $xml_data[1];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
hp_absorb_skill(<?php echo $row['mon']?>) -> <?php echo $row['skill']?>;
<?php }?>
hp_absorb_skill(_) -> false.

%% BOSS数据
<?php
$data = $xml_data[2];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
get_boss(_BossBaseId = <?php echo $row['boss_id']?>) ->
    #rboss_base_mon{
        roll_item = <?php echo gen_record($row['roll'])?><?php echo "\n"?>
        ,hurt_item1 = <?php echo gen_record($row['hurt1'])?><?php echo "\n"?>
        ,hurt_item2 = <?php echo gen_record($row['hurt2'])?><?php echo "\n"?>
        ,hurt_item3 = <?php echo gen_record($row['hurt3'])?><?php echo "\n"?>
        ,last_item = <?php echo gen_record($row['last'])?><?php echo "\n"?>
        ,drop = <?php echo gen_record($row['drop2'])?><?php echo "\n"?>
        ,first_hurt_item = <?php echo gen_record($row['first_hurt'])?><?php echo "\n"?>
    };
<?php }?>
get_boss(_BossBaseId) ->
    false.

all() -> [<?php echo implode(",", $allids)?>].
