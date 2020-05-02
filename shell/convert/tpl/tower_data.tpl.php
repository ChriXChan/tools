%% -----------------------------------------------------------------------------
%% 伏魔塔数据
%% @author pb
%% -----------------------------------------------------------------------------
-module(tower_data).

-export([
        map/1
        ,reborn/1
        ,is_safe/1
        ,down_prob/1
        ,kill_score/1
        ,kill_num/1
        ,map2floor/1
        ,label/1
        ,add_score/1
        ,add_energy/1
        ,buff/1
        ,mon_to_buff/1
        ,floors/0
        ,bagua/0
        ,score_reward/1
        ,scores/0
        ,kill_title/1
        ,kill_titles/0
        ,titles/0
        ,mul_kill_num/0
        ,robot_num/1
        ,robot_fc_rand/1
        ,fc_to_attr/1
        ,skill_energy/1
        ,mon_born_pos/1
        ,killed_energy/1
        ,bagua_score/1
        ,bagua_refresh_score/1
        ,bagua_refresh_score2/1
        ,bagua_buff/1
        ,bagua_title/1
        ,title2buff/1
        ,all_bagua_title/0
        ,bagua_name/1
        ,skill2id/1
        ,areas/0
        ,area_name/1
        ,rank/0
        ,rank_reward/1
        ,cast/1
        ,bugua_refresh_gap/1
        ,pass_reward/1
        ,bagua_gap/1
        ,title_cast/1
        ,mon_per/1
        ,redpacket/1
        ,redpacket_cond/1
        ,redpackets/0
        ,exp/1
    ]).

-include("condition.hrl").
-include("gain.hrl").
-include("common.hrl").
-include("attr.hrl").

%% 地图入口
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
map(<?php echo $row['floor'];?>) -> {<?php echo $row['scene'];?>, util_math:rand_list([<?php echo $row['born_pos']?>])};
<?php }?>
map(_) -> false.

%% 重生次数
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
reborn(<?php echo $row['floor'];?>) -> <?php echo $row['reborn'];?>;
<?php }?>
reborn(_) -> 1.

%% 是否是安全层 is_safe(Floor) -> 0 | 1
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
is_safe(<?php echo $row['floor'];?>) -> <?php echo $row['safe'];?>;
<?php }?>
is_safe(_) -> 0.

%% 掉层概率
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
down_prob(<?php echo $row['floor'];?>) -> <?php echo $row['prob'];?>;
<?php }?>
down_prob(_) -> 0.

%% 击杀积分
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
kill_score(<?php echo $row['floor'];?>) -> <?php echo $row['kill_score'];?>;
<?php }?>
kill_score(_) -> 0.

%% 击杀积分
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
killed_energy(<?php echo $row['floor'];?>) -> <?php echo $row['killed_energy'];?>;
<?php }?>
killed_energy(_) -> 0.

%% 每层所需击杀数量
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
kill_num(<?php echo $row['floor'];?>) -> <?php echo $row['kill_num'];?>;
<?php }?>
kill_num(_) -> 0.

%% 地图对应层数
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
map2floor(<?php echo $row['scene'];?>) -> <?php echo $row['floor'];?>;
<?php }?>
map2floor(_) -> 1.

%% 每次增加逗留积分
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
add_score(<?php echo $row['floor'];?>) -> <?php echo $row['stay_score'];?>;
<?php }?>
add_score(_) -> 0.

%% 每次增加逗留真气
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
add_energy(<?php echo $row['floor'];?>) -> <?php echo $row['stay_energy'];?>;
<?php }?>
add_energy(_) -> 0.

%% buff配置
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
buff(<?php echo $row['floor'];?>) -> {<?php echo $row['buff_pos'];?>, <?php echo $row['buff_mon'];?>, <?php echo $row['buff_num'];?>};
<?php }?>
buff(_) -> false.

%% 每层机器人最大数量
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if (trim($row['robot_num'])!="") {
        echo "robot_num(${row['floor']}) -> ${row['robot_num']};"."\n";
    }
}
?>
robot_num(_) -> 0.

%% 每层机器人战力随机系数
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if (trim($row['robot_rand'])!="") {
        echo "robot_fc_rand(${row['floor']}) -> ${row['robot_rand']};"."\n";
    }
?>
<?php }?>
robot_fc_rand(_) -> false.

%% 通关奖励
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
pass_reward(<?php echo $row['floor'];?>) -> <?php echo gen_record($row['pass_reward']);?>;
<?php }?>
pass_reward(_) -> false.

%% 怪物出生点
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
mon_born_pos(<?php echo $row['floor'];?>) -> util_math:rand_list([<?php echo $row['mon_born_pos']?>]);
<?php }?>
mon_born_pos(_) -> false.

%% 每次刷怪个数
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if (trim($row['mon_per'])!="") {
        echo "mon_per(${row['floor']}) -> ${row['mon_per']};"."\n";
    }
}
?>
mon_per(_) -> 1.

<?php
$last = array_pop($data);
?>
%% 层数
floors() ->[<?php
foreach($data as $v) {
    echo "{$v['floor']}, ";
}
echo "{$last['floor']}].";
?>

%% 基本配置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'first_reward' || $data[$i]['label'] == 'top_reward' || $data[$i]['label'] == 'view_reward' || $data[$i]['label'] == 'bagua_refresh_reward'){
        echo 'label('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['null']."\n"; 
    }elseif($data[$i]['label'] == 'open_day'){
        echo 'label('.$data[$i]['label']. ') -> [' .$data[$i]['value'].'];'."\t%%".$data[$i]['null']."\n";
    }
    else{
        echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['null']."\n";
    }
}
?>
label(_) -> false.

%% 积分奖励
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
score_reward(<?php echo $row['score'];?>) -> <?php echo gen_record($row['reward']);?>;
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


%% 怪物对应BUFF id
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
mon_to_buff(<?php echo $row['mon'];?>) -> <?php echo $row['buff'];?>;
<?php }?>
mon_to_buff(_) -> false.

%% 八卦镜ID列表
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
bagua() ->[<?php
foreach($data as $v) {
    echo "{$v['id']}, ";
}
echo "{$last['id']}].";
?>

%% 八卦镜定时加积分
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
bagua_score(<?php echo $row['id'];?>) -> <?php echo $row['bagua_score']?>;
<?php }?>
bagua_score(_) -> 0.

%% 八卦镜刷新时加积分
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
bagua_refresh_score(<?php echo $row['id'];?>) -> <?php echo $row['bagua_refresh_score']?>;
<?php }?>
bagua_refresh_score(_) -> 0.

%% 八卦镜刷新时加灵气
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
bagua_refresh_score2(<?php echo $row['id'];?>) -> <?php echo $row['bagua_refresh_score2']?>;
<?php }?>
bagua_refresh_score2(_) -> 0.

%% 八卦镜持有刷新间隔
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
bagua_gap(<?php echo $row['id'];?>) -> <?php echo $row['gap']?>;
<?php }?>
bagua_gap(_) -> 300.

%% 八卦镜采集成功BUFF
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
bagua_buff(<?php echo $row['id'];?>) -> <?php echo $row['bagua_buff']?>;
<?php }?>
bagua_buff(_) -> false.

%% 八卦镜采集称号标示位
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
bagua_title(<?php echo $row['id'];?>) -> <?php echo $row['title']?>;
<?php }?>
bagua_title(_) -> false.

%% 八卦镜名字
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
bagua_name(<?php echo $row['id'];?>) -> <<"<?php echo $row['desc']?>">>;
<?php }?>
bagua_name(_) -> <<>>.

%% 技能与采集区映射
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
skill2id(<?php echo $row['skill'];?>) -> <?php echo $row['id']?>;
<?php }?>
skill2id(_) -> false.

%% 采集称号与buff映射
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
title2buff(<?php echo $row['title'];?>) -> <?php echo $row['bagua_buff']?>;
<?php }?>
title2buff(_) -> false.

%% 旗帜刷新广播
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
cast(<?php echo $row['id'];?>) -> <?php echo $row['cast']?>;
<?php }?>
cast(_) -> 0.

%% 八卦镜刷新间隔
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
bugua_refresh_gap(<?php echo $row['id'];?>) -> <?php echo $row['gap']?>;
<?php }?>
bugua_refresh_gap(_) -> 60.

%% 所有采集称号
<?php
$last = array_pop($data);
?>
all_bagua_title() ->[<?php
foreach($data as $v) {
    echo "{$v['title']}, ";
}
echo "{$last['title']}].";
?>


%% 连杀称号
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'kill_num', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
kill_title(Num) when Num >= <?php echo $row['kill_num'];?> -> <?php echo $row['title'];?>;
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
$data = $xml_data[5];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
mul_kill_num() ->[<?php
foreach($data as $v) {
    echo "{$v['kill_num']}, ";
}
echo "{$last['kill_num']}].";
?>

%% 所有连杀称号
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
kill_titles() ->[<?php
foreach($data as $v) {
    echo "{$v['title']}, ";
}
echo "{$last['title']}].";
?>


%% 所有称号
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
titles() ->[label(bagua_title), <?php
foreach($data as $v) {
    echo "{$v['title']}, ";
}
echo "{$last['title']}].";
?>


%% 人物机器人战力转属性
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


%% 真气技能配置
<?php
$data = $xml_data[7];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
skill_energy(<?php echo $row['skill_id'];?>) -> <?php echo $row['energy'];?>;
<?php }?>
skill_energy(_) -> false.

<?php
$data = $xml_data[8];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
%% 层数
areas() ->[<?php
foreach($data as $v) {
    echo "{$v['id']}, ";
}
echo "{$last['id']}].";
?>


<?php
$data = $xml_data[8];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
area_name(<?php echo $row['id'];?>) -> <<"<?php echo $row['desc'];?>">>;
<?php }?>
area_name(_) -> <<>>.

%% 排名奖励
<?php
$data = $xml_data[9];
array_shift($data);
array_shift($data);
$array = array();
for($i=0;$i<sizeof($data);$i++){
    array_push($array, $data[$i]['rank']);
}
$array = array_unique($array);
$last = array_pop($array);
?>
%% 层数
rank() ->[<?php
foreach($array as $v) {
    echo "{$v}, ";
}
echo "{$last}].";
?>

<?php
$data = $xml_data[9];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
rank_reward(_Rank = <?php echo $row['rank'];?>) -> <?php echo gen_record($row['reward']);?>;
<?php }?>
rank_reward(_) -> false.

%% 灵气帮会红包
<?php
$data = $xml_data[10];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
redpacket(<?php echo $row['score2'];?>) -> <?php echo $row['redpacket'];?>;
<?php }?>
redpacket(_) -> false.

%% 灵气帮会红包
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
redpacket_cond(<?php echo $row['redpacket'];?>) -> <?php echo $row['score'];?>;
<?php }?>
redpacket_cond(_) -> false.

<?php
$last = array_pop($data);
?>
%% 积分奖励段
redpackets() ->[<?php
foreach($data as $v) {
    echo "{$v['score2']}, ";
}
echo "{$last['score2']}].";
?>

%% 经验奖励
<?php
$data = $xml_data[11];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
exp(Lev) when Lev >= <?php echo $row['lev'];?> -> <?php echo $row['exp'];?>;
<?php }?>
exp(_) -> 0.