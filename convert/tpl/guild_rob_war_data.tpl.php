%% -----------------------------------------------------------------------------
%% 帮会混战数据
%% @author pb
%% -----------------------------------------------------------------------------
-module(guild_rob_war_data).

-export([
        label/1
        ,box/1
        ,bosspos/1
        ,boxpos/1
        ,all_boss/0
        ,score_reward/1
        ,scores/0
        ,mon2score/1
        ,type/1
        ,rank/0
        ,rank_reward/1
        ,fc_to_attr/1
        ,exp/1
    ]).

-include("condition.hrl").
-include("gain.hrl").
-include("common.hrl").
-include("attr.hrl").

%% 基本配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'view_reward'){
        echo 'label('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n"; 
    } elseif ($data[$i]['label'] == 'collect_silver_pos' || $data[$i]['label'] == 'collect_gold_pos' || $data[$i]['label'] == 'hang_pos') {
        echo 'label('.$data[$i]['label']. ') -> [' .$data[$i]['value'].'];'."\t%%".$data[$i]['desc']."\n"; 
    } else{
        echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
label(_) -> false.

%% BOSS宝箱信息
<?php 
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $boss_id = $row['boss_id'];
    $mon_id = $row['mon_id'];
    echo "box({$boss_id}) -> {$mon_id};\n";
}
?>
box(_) -> false.

%% BOSS坐标信息
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $id = $row['id'];
    $boss_id = $row['boss_id'];
    $boss_pos = $row['boss_pos'];
    echo "bosspos({$boss_id}) -> {$boss_pos};\n";
}
?>
bosspos(_) -> false.

%% BOSS宝箱坐标信息
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $id = $row['id'];
    $boss_id = $row['boss_id'];
    $boss_box_pos = $row['boss_box_pos'];
    echo "boxpos({$boss_id}) -> [{$boss_box_pos}];\n";
}
?>
boxpos(_) -> false.

<?php
$last = array_pop($data);
?>
%% 所有ID
all_boss() ->[<?php
foreach($data as $v) {
    echo "{$v['boss_id']}, ";
}
echo "{$last['boss_id']}].";
?>


%% 积分奖励
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    $reward = gen_record($row['reward']);
    $score = $row['score'];
    echo "score_reward({$score}) -> {$reward};\n";
?>
<?php }?>
score_reward(_) -> false.

<?php
$last = array_pop($data);
?>
%% 积分奖励段
scores() ->[<?php
foreach($data as $v) {
    echo "{$v['score']}, ";
}
echo "{$last['score']}].";
?>

%% 怪物积分
<?php 
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $score = $row['score'];
    $mon_id = $row['mon_id'];
    echo "mon2score({$mon_id}) -> {$score};\n";
}
?>
mon2score(_) -> 0.

%% 怪物类型
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $type = $row['type'];
    $mon_id = $row['mon_id'];
    echo "type({$mon_id}) -> {$type};\n";
}
?>
type(_) -> 1.

<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
$array = array();
for($i=0;$i<sizeof($data);$i++){
    array_push($array, $data[$i]['rank']);
}
$array = array_unique($array);
$last = array_pop($array);
?>
%% 所有帮会积分排名
rank() ->[<?php
foreach($array as $v) {
    echo "{$v}, ";
}
echo "{$last}].";
?>

%% 帮会积分排名奖励
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
rank_reward(_Rank = <?php echo $row['rank'];?>) -> <?php echo gen_record($row['reward']);?>;
<?php }?>
rank_reward(_) -> false.

%% BOSS战力转属性
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
fc_to_attr(Fc) ->#attr{<?php
foreach($data as $v) {
    echo "{$v['attr']} = util_math:floor(Fc*"."{$v['arg']}/1000"."), ";
}
echo "{$last['attr']} = util_math:floor(Fc*"."{$last['arg']}/1000".")}.";
?>


%% 经验奖励
<?php
$data = $xml_data[7];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
exp(Lev) when Lev >= <?php echo $row['lev'];?> -> <?php echo $row['exp'];?>;
<?php }?>
exp(_) -> 0.