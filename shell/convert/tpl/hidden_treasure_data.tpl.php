%% -----------------------------------------------------------------------------
%% 秘境寻宝数据
%% @author mirahs
%% -----------------------------------------------------------------------------
-module(hidden_treasure_data).

-export([
    level/1
    ,shovel_buy/1
    ,label/1
    ,open_reward/1
    ]).

-include("hidden_treasure.hrl").
-include("gain.hrl").


%% 层数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
level(_Level = <?php echo $row['cell']?>) ->
    #ht_data_level{
        level = <?php echo $row['cell']?><?php echo "\n"?>
        ,row = <?php echo $row['row']?><?php echo "\n"?>
        ,col = <?php echo $row['col']?><?php echo "\n"?>
        ,box_num = <?php echo $row['box_num']?><?php echo "\n"?>
        ,box_reward = [<?php echo $row['box_reward'] ?>]<?php echo "\n"?>
        ,box_round_reward = [<?php echo $row['box_round_reward'] ?>]<?php echo "\n"?>
        ,normal_reward = [<?php echo $row['normal_reward'] ?>]<?php echo "\n"?>
        ,loss = <?php echo gen_record($row['loss']) ?><?php echo "\n"?>
    };
<?php } ?>
level(_Level) ->
    false.

%% 铲子购买数据
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
shovel_buy(_Times = <?php echo $row['times']?>) -> {<?php echo gen_record($row['loss']); ?>, <?php echo $row['num']; ?>};
<?php } ?>
shovel_buy(_Times) -> false.

%% 标签
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
?>
label(<?php echo $v['label']?>) -> <?php echo $v['value']?>;
<?php } ?>
label(_Label) -> false.

%% 翻石奖励
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
open_reward(_OpenTimes = <?php echo $row['num']?>) -> <?php echo gen_record($row['reward']); ?>;
<?php } ?>
open_reward(_OpenTimes) -> false.
