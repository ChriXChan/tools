%% -----------------------------------------------------------------------------
%% 天尊归位数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(arena_data).

-export([rank_award/1,rank_title/1,battle_count_award/1,buy_count/1,label/1,battle_aim/1,mon_config/1,mon_grow/1,mon_grow_fc/1,battle_count_ids/0]).

-include("gain.hrl").
-include("common.hrl").
-include("tianzhun.hrl").



%%排名奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i=0;$i < sizeof($data);$i++){
    $row = $data[$i];
    ?>rank_award(Rank) when Rank =< <?php echo $row['rank'];?> -> <?php echo gen_record($data[$i]['gain']);?>;
<?php }?>
rank_award(_) -> [].


<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i=0;$i < sizeof($data);$i++){
    $row = $data[$i];
    ?>rank_title(Rank) when Rank =< <?php echo $row['rank'];?> -> <?php echo $data[$i]['title'];?>;
<?php }?>
rank_title(_) -> 0.


%%挑战次数奖励
<?php
$data = $xml_data[1];
$scores = array();
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    $scores[] = $row['id'];
    ?>
battle_count_award(<?php echo $row['id']?>) -> {<?php echo $row['num']?>,<?php echo gen_record($row['gain'])?>};
<?php }?>
battle_count_award(_) -> false.

%% ID列表
battle_count_ids() -> [<?php echo implode(",", $scores);?>].

%%购买次数
<?php
$data = $xml_data[2];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    ?>
buy_count(<?php echo $row['count']?>) -> <?php echo gen_record($row['loss'])?>;
<?php }?>
buy_count(_) -> [].

%%其他配置
<?php
$data = $xml_data[3];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    ?>
label(<?php echo $row['label']?>) -> [<?php echo $row['val']?>];
<?php }?>
label(_) -> [].


%%挑战目标生成
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for($i=0;$i < sizeof($data);$i++){
    $row = $data[$i];
    ?>battle_aim(Rank) when Rank =< <?php echo $row['rank'];?> -> {<?php echo $data[$i]['high'];?>,<?php echo $data[$i]['low'];?>};
<?php }?>
battle_aim(_) -> [].

%% 怪物配置
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for($i=0;$i < sizeof($data);$i++){
    $row = $data[$i];
?>mon_config(Rank) when Rank =< <?php echo $row['rank'];?> -> {<?php echo $data[$i]['mon_id'];?>,<?php echo $data[$i]['scene_id'];?>,<?php echo $row['attr']?>,<?php echo $row['limit_max']?>,<?php echo $row['points']?>,<?php echo $row['boss_born']?>};
<?php }?>
mon_config(_) -> [].

%%怪物成长
<?php
$data = $xml_data[6];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    ?>
mon_grow(<?php echo $row['id']?>) -> {[<?php echo attr_to_int($row['attr'])?>],[<?php echo attr_to_int($row['attr_grow_1'])?>],[<?php echo attr_to_int($row['attr_grow_2'])?>]};
<?php }?>
mon_grow(_) -> [].


%%怪物战力
<?php
$data = $xml_data[6];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    ?>
mon_grow_fc(<?php echo $row['id']?>) -> {<?php echo $row['pow']?>,<?php echo $row['pow1']?>};
<?php }?>
mon_grow_fc(_) -> [].