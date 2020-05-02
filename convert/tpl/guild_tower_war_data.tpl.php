%% -----------------------------------------------------------------------------
%% 帮会守塔战数据
%% @author pb
%% -----------------------------------------------------------------------------
-module(guild_tower_war_data).

-export([
        label/1
        ,box_num/1
        ,box2stone/1
        ,color2box/1    
        ,all_box/0
        ,all_color/0
        ,score_reward/1
        ,scores/0
        ,kill_title/1
        ,title_cast/1
        ,mul_kill_num/0
        ,lev2stone/1
        ,lev2baseid/2
        ,lev2exp/1
        ,lev2score/1
        ,succ_score/1
        ,base_score/1
        ,max_lev/0
        ,rank/0
        ,rank_reward/1
        ,born_pos/1
        ,tower_pos/1
        ,hurt/2
        ,buff1/2
        ,buff2/2
        ,exp/1
        ,skill_energy/1
        ,fashion_id/1
        ,all_fashion/0
    ]).

-include("condition.hrl").
-include("gain.hrl").
-include("common.hrl").

%% 基本配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'view_reward'){
        echo 'label('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n"; 
    } elseif ($data[$i]['label'] == 'pos' || $data[$i]['label'] == 'hang_pos') {
        echo 'label('.$data[$i]['label']. ') -> [' .$data[$i]['value'].'];'."\t%%".$data[$i]['desc']."\n"; 
    } else{
        echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
label(_) -> false.

%% 宝箱数量
<?php 
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $num = $row['num'];
    $mon_id = $row['mon_id'];
    echo "box_num({$mon_id}) -> {$num};\n";
}
?>
box_num(_) -> 0.

%% 宝箱采集后增加矿石数量
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $stone = $row['stone'];
    $mon_id = $row['mon_id'];
    echo "box2stone({$mon_id}) -> {$stone};\n";
}
?>
box2stone(_) -> 0.

%% 宝箱品质
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $color = $row['color'];
    $mon_id = $row['mon_id'];
    echo "color2box({$color}) -> {$mon_id};\n";
}
?>
color2box(_) -> false.

<?php
$last = array_pop($data);
?>
%% 所有宝箱
all_box() ->[<?php
foreach($data as $v) {
    echo "{$v['mon_id']}, ";
}
echo "{$last['mon_id']}].";
?>

%% 所有宝箱品质
all_color() ->[<?php
foreach($data as $v) {
    echo "{$v['color']}, ";
}
echo "{$last['color']}].";
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

%% 连杀称号
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'kill_num', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if($row['kill_num'] > 0) {
        echo 'kill_title(Num) when Num >= '. $row['kill_num']. ' -> '.$row['title'].";\n";
    }
?>
<?php }?>
kill_title(_) -> false.

%% 称号是否广播
<?php
$data = array_sort($data, 'kill_num', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
title_cast(<?php echo $row['title'];?>) -> <?php echo $row['cast'];?>;
<?php }?>
title_cast(_) -> 0.

%% 所有连杀称号
<?php
$data = array_sort($data, 'kill_num', SORT_ASC);
$last = array_pop($data);
?>
mul_kill_num() ->[<?php
foreach($data as $v) {
    echo "{$v['kill_num']}, ";
}
echo "{$last['kill_num']}].";
?>


%% 塔升级所需矿石
<?php 
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $lev = $row['level'];
    $stone = $row['stone'];
    echo "lev2stone({$lev}) -> {$stone};\n";
}
echo "lev2stone(_) -> ?UINT32_MAX.\n"
?>

%% 塔base_id
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $lev = $row['level'];
    $base_id = $row['base_id'];
    echo "lev2baseid({$lev}, Id) -> lists:nth(Id, [{$base_id}]);\n";
}
echo "lev2baseid(_, _) -> false.\n"
?>

%% 经验加成比例
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $lev = $row['level'];
    $exp = $row['exp'];
    echo "lev2exp({$lev}) -> {$exp};\n";
}
echo "lev2exp(_) -> 0.\n"
?>

%% 塔定时加积分
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $lev = $row['level'];
    $score = $row['score'];
    echo "lev2score({$lev}) -> {$score};\n";
}
echo "lev2score(_) -> 0.\n"
?>

%% 塔渡劫成功积分
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $lev = $row['level'];
    $score = $row['succ_score'];
    echo "succ_score({$lev}) -> {$score};\n";
}
echo "succ_score(_) -> 0.\n"
?>

%% 开始塔渡劫积分
<?php 
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $lev = $row['level'];
    $score = $row['base_score'];
    echo "base_score({$lev}) -> {$score};\n";
}
echo "base_score(_) -> 0.\n"
?>

%% 最高等级
<?php
$max_lev = 0;
for ($i = 0; $i < count($data); $i++) {
    $lev = $row['level'];
    if($lev > $max_lev){
        $max_lev = $lev;
    }
}
echo "max_lev() -> {$max_lev}.\n";
?>

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

%% 出生点/复活点
<?php 
$data = $xml_data[6];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $id = $row['id'];
    $pos = $row['pos'];
    echo "born_pos({$id}) -> [{$pos}];\n";
}
echo "born_pos(_) -> [].\n"
?>

%% 塔坐标
<?php
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $id = $row['id'];
    $pos = $row['tower_pos'];
    echo "tower_pos({$id}) -> {$pos};\n";
}
echo "tower_pos(_) -> false.\n"
?>

<?php 
$data = $xml_data[7];
array_shift($data);
array_shift($data);
$array1 = array();
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $vip = $row['vip'];
    $array1[$vip][] = $row;
}
foreach ($array1 as $vip => $array2) {
    $array2 = array_sort($array2, 'job', SORT_ASC);
    for ($i = 0; $i < count($array2); $i++) {
        $row = $array2[$i];
        $job = $row['job'];
        $hurt = $row['hurt'];
        echo "hurt(Vip, Job) when Vip >= {$vip} andalso Job =< {$job} -> {$hurt};\n";
    }
}
echo "hurt(_, _) -> 0.\n\n";

foreach ($array1 as $vip => $array2) {
    $array2 = array_sort($array2, 'job', SORT_ASC);
    for ($i = 0; $i < count($array2); $i++) {
        $row = $array2[$i];
        $job = $row['job'];
        $buff1 = $row['buff1'];
        echo "buff1(Vip, Job) when Vip >= {$vip} andalso Job =< {$job} -> {$buff1};\n";
    }
}
echo "buff1(_, _) -> 0.\n\n";

foreach ($array1 as $vip => $array2) {
    $array2 = array_sort($array2, 'job', SORT_ASC);
    for ($i = 0; $i < count($array2); $i++) {
        $row = $array2[$i];
        $job = $row['job'];
        $buff2 = $row['buff2'];
        echo "buff2(Vip, Job) when Vip >= {$vip} andalso Job =< {$job} -> {$buff2};\n";
    }
}
echo "buff2(_, _) -> 0.\n";
?>

%% 经验奖励
<?php
$data = $xml_data[8];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
exp(Lev) when Lev >= <?php echo $row['lev'];?> -> <?php echo $row['exp'];?>;
<?php }?>
exp(_) -> 0.

%% 真气技能配置
<?php
$data = $xml_data[9];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
skill_energy(<?php echo $row['skill_id'];?>) -> <?php echo $row['energy'];?>;
<?php }?>
skill_energy(_) -> false.

%% 排名第一帮会时装
<?php
$data = $xml_data[10];
array_shift($data);
array_shift($data);
$array_all = array();
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    $job = $row['job'];
    $fashion_id = $row['fashion_id'];
    $array_all[] = $fashion_id;
    echo "fashion_id({$job}) -> {$fashion_id};\n";
}
echo "fashion_id(_) -> false.\n";
$array_all = array_unique($array_all);
$last = array_pop($array_all);
?>

%% 所有宝箱
all_fashion() ->[<?php
foreach($array_all as $v) {
    echo "{$v}, ";
}
echo "{$last}].";
?>