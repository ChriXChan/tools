%% -----------------------------------------------------------------------------
%% 精英BOSS数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(elite_boss_data).

-export([
        get/1
        ,all/0
        ,all/1
        ,base_to_id/1
        ,map_to_base/1
        ,base_to_cross_type/1
        ,hp_absorb_skill/1
    ]).

-include("elite_boss.hrl").
-include("gain.hrl").

<?php
$data = $xml_data[0];
$ids = array();
$allids = array();
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
    $allids[] = $row['id'];
    $ids[$row['cross_type']][] = $row['id'];
?>
get(<?php echo $row['id']?>) ->
    #eboss_base{
        map_id = <?php echo $row['map_id']?><?php echo "\n"?>
        ,type = <?php echo $row['cross_type']?><?php echo "\n"?>
        ,points = [<?php echo $row['points']?>]<?php echo "\n"?>
        ,refresh = <?php echo $row['refresh']?><?php echo "\n"?>
        ,boss_id = <?php echo $row['boss_id']?><?php echo "\n"?>
        ,boss_born = <?php echo $row['boss_born']?><?php echo "\n"?>
        ,hurt_item1 = <?php echo gen_record($row['hurt1'])?><?php echo "\n"?>
        ,hurt_item2 = <?php echo gen_record($row['hurt2'])?><?php echo "\n"?>
        ,hurt_item3 = <?php echo gen_record($row['hurt3'])?><?php echo "\n"?>
        ,last_hurt = <?php echo gen_record($row['last'])?><?php echo "\n"?>
        ,loss = <?php echo gen_record($row['loss'])?><?php echo "\n"?>
        ,roll_item = <?php echo gen_record($row['roll'])?><?php echo "\n"?>
        ,drop = <?php echo gen_record($row['drop2'])?><?php echo "\n"?>
    };
<?php }?>
get(_) ->
    false.

all() -> [<?php echo implode(",", $allids)?>].

<?php foreach($ids as $k=>$v){
?>
all(<?php echo $k?>) -> [<?php echo implode(",", $v)?>];
<?php }?>
all(_) -> [].

<?php
$data = $xml_data[0];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
base_to_id(<?php echo $row['boss_id']?>) -> <?php echo $row['id']?>;
<?php }?>
base_to_id(_) -> 0.

<?php
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
base_to_cross_type(<?php echo $row['boss_id']?>) -> <?php echo $row['cross_type']?>;
<?php }?>
base_to_cross_type(_) -> false.

<?php
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
map_to_base(<?php echo $row['map_id']?>) -> <?php echo $row['boss_id']?>;
<?php }?>
map_to_base(_) -> 0.


%% 精英BOSS血盾技能
<?php
$data = $xml_data[1];
$ids = array();
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
hp_absorb_skill(<?php echo $row['mon']?>) -> <?php echo $row['skill']?>;
<?php }?>
hp_absorb_skill(_) -> false.
