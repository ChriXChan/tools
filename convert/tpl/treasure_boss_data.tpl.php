%% -----------------------------------------------------------------------------
%% 文本数据
%% @author mirahs
%% -----------------------------------------------------------------------------
-module(treasure_boss_data).

-include("treasure_boss.hrl").
-include("gain.hrl").

-export([
    get/1
    ,get_boss/1
    ,label/1
    ,box_reward/1
    ,boss_reward/2
    ,small_level_boss/1
]).


%% 寻宝数据
<?php
$data = $xml_data[0];
$idx_last = count($data) - 1;
for ($i = 2; $i < count($data); $i++) {
    $row = $data[ $i ];
    if ($i != $idx_last) { ?>
get(Times) when Times =< <?php echo $row['times'] ?> -> {[<?php echo $row['mon'] ?>], <?php echo $row['box'] ?>, <?php echo $row['box_base_num'] ?>};
<?php } else { ?>
get(_Times) -> {[<?php echo $row['mon'] ?>], <?php echo $row['box'] ?>, <?php echo $row['box_base_num'] ?>}.
<?php } } ?>


%% boss数据
<?php
$data = $xml_data[1];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[ $i ];
?>
get_boss(_Id = <?php echo $row['id'] ?>) ->
    #treasure_boss_data{
        id = <?php echo $row['id'];?><?php echo "\n";?>
        ,attr = [<?php echo attr_to_int($data[$i]['attr']); ?>]<?php echo "\n";?>
        ,attr_grow = [<?php echo attr_to_int($data[$i]['attr_grow']); ?>]<?php echo "\n";?>
        ,pos = [<?php echo $row['pos'];?>]<?php echo "\n";?>
    };
<?php } ?>
get_boss(_Id) -> false.


%% 其他配置
<?php
$data = $xml_data[2];
for ($i = 2; $i < count($data); $i++)
{
    $row = $data[$i];
    if ($row['label'] == 'box_pos')
    {
        $result = '[' . $row['val'] . ']';
    }
    else
    {
        $result = $row['val'];
    }
?>
label(<?php echo $row['label']?>) -> <?php echo $result; ?>;
<?php } ?>
label(_Label) -> false.


%% 宝箱奖励
<?php
$data = $xml_data[3];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[ $i ];
?>
box_reward(_Res = <?php echo $row['res']?>) -> <?php echo gen_record($row['reward']);?>;
<?php } ?>
box_reward(_Res) -> false.


%% boss奖励
<?php
$data = $xml_data[4];
$boss_rewards = array();
for ($i = 2; $i < count($data); $i++) {
    $row = $data[ $i ];
    $boss_rewards[ $row['id'] ][ ] = $row;
}

foreach ($boss_rewards as $boss_id => $boss_reward) {
    $idx_last = count($boss_reward) - 1;
    for ($j = 0; $j < count($boss_reward); $j++) {
        $row = $boss_reward[ $j ];
        $hurt1 = gen_record($row['hurt1']);
        $hurt2 = gen_record($row['hurt2']);
        $hurt3 = gen_record($row['hurt3']);
        $hurt4 = gen_record($row['hurt4']);
        $hurt5 = gen_record($row['hurt5']);
        $last = gen_record($row['last']);
        $drop = gen_record($row['drop']);
        if ($j != $idx_last) {
            echo "boss_reward(_BossId = {$boss_id}, WorldLevel) when WorldLevel =< {$row['lev']} -> {{$hurt1},{$hurt2},{$hurt3},{$hurt4},{$hurt5},{$last},{$drop}};\n";
        } else {
            echo "boss_reward(_BossId = {$boss_id}, _WorldLevel) -> {{$hurt1},{$hurt2},{$hurt3},{$hurt4},{$hurt5},{$last},{$drop}};\n";
        }
    }
}
?>
boss_reward(_BossId, _WorldLevel) -> false.

%% 世界等级减少boss
<?php
$data = $xml_data[5];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[ $i ];
?>
small_level_boss(_BossId = <?php echo $row['id']?>) -> <?php echo $row['sub_lev']; ?>;
<?php } ?>
small_level_boss(_BossId) -> false.

