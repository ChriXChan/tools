%% -----------------------------------------------------------------------------
%% 跨服BOSS数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(cross_boss_data).

-export([
        get/1
        ,all/0

        ,hp_absorb_skill/1

        ,get_mon/1
    ]).

-include("cross_boss.hrl").
-include("gain.hrl").
-include("condition.hrl").


%% 跨服地图
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$ids = array();
$allids = array();
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
    $allids[] = $row['map_id'];
?>
get(<?php echo $row['map_id']?>) ->
    #cboss_map_data{
        map_id = <?php echo $row['map_id']?><?php echo "\n"?>
        ,points = [<?php echo $row['points']?>]<?php echo "\n"?>
        ,type = <?php echo $row['cross_type']?><?php echo "\n"?>
        ,conds = <?php echo gen_record($row['conds'])?><?php echo "\n"?>
        ,mon = [<?php echo $row['mon']?>]<?php echo "\n"?>
        ,boss = [<?php echo $row['boss']?>]<?php echo "\n"?>
    };
<?php }?>
get(_) ->
    false.

all() -> [<?php echo implode(",", $allids)?>].


%% 跨服BOSS血盾技能
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$ids = array();
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
hp_absorb_skill(<?php echo $row['mon']?>) -> <?php echo $row['skill']?>;
<?php }?>
hp_absorb_skill(_) -> false.


%% 跨服boss
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
get_mon(<?php echo $row['boss_id']?>) ->
    #cboss_mon_data{
        boss_id = <?php echo $row['boss_id']?><?php echo "\n"?>
        ,boss_born = <?php echo $row['boss_born']?><?php echo "\n"?>
        ,roll_item = <?php echo gen_record($row['roll'])?><?php echo "\n"?>
        ,hurt_item1 = <?php echo gen_record($row['hurt1'])?><?php echo "\n"?>
        ,hurt_item2 = <?php echo gen_record($row['hurt2'])?><?php echo "\n"?>
        ,hurt_item3 = <?php echo gen_record($row['hurt3'])?><?php echo "\n"?>
        ,hurt_item4 = <?php echo gen_record($row['hurt4'])?><?php echo "\n"?>
        ,hurt_item5 = <?php echo gen_record($row['hurt5'])?><?php echo "\n"?>
        ,last_item = <?php echo gen_record($row['last'])?><?php echo "\n"?>
        ,drop = <?php echo gen_record($row['drop2'])?><?php echo "\n"?>
        ,first_hurt_item = <?php echo gen_record($row['first_hurt'])?><?php echo "\n"?>
    };
<?php }?>
get_mon(_) ->
    false.
