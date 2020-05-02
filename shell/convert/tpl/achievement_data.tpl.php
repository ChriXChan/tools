%%----------------------------------------------------
%% 成就数据
%% @author linkeng
%%----------------------------------------------------
-module(achievement_data).

-export([label_to_type/1
    , count_types/0
    , types/1
    , groups/1
    , get/1
    , all/0
    , lev_reward/1
    , point_lev/1
    , group_title/1
    , all_group/0
]).

-include("achievement.hrl").
-include("gain.hrl").
-include("condition.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$temp = array();
$type = array();
$count = array();
$group = array();
foreach ($data as $v) {
    $temp[$v['type']][] = $v['id'];
    $type[$v['type']] = $v['label'];
    $group[$v['group']][] = $v['id'];
    if($v['count'] > 0){
        $count[$v['label']] = $v['type'];
    }
}
?>
%% 各成就详细信息
<?php
foreach ($data as $v){
    echo "get({$v['id']}) -> #achievement_data{id = {$v['id']}, group = {$v['group']}, type = {$v['type']}, label = {$v['label']}, count = {$v['count']}, require = " . gen_record($v['require']) . ", point = {$v['point']}, items = " . gen_record($v['items']) . "};\n";
}
?>
get(_) -> false.

%% 全部成就id
all() -> [<?php
$last = array_pop($data);
foreach ($data as $v){
    echo "{$v['id']}, ";
}
echo $last['id']
?>].

%%
<?php
foreach ($type as $k => $v){
    echo "label_to_type({$v}) -> {$k};\n";
}
?>
label_to_type(_) -> 0.

%% 统计次数的类型
count_types() -> [<?php
$last = array_pop($count);
foreach ($count as $k => $v){
    echo "{$v}, ";
}
echo $last
?>].

%% 各类型成就id列表
<?php
foreach ($temp as $k => $t) {
    $last = array_pop($t);
    echo "types({$k}) -> [";
    foreach ($t as $v) {
        echo "{$v}, ";
    }
    echo "{$last}];\n";
}
?>
types(_) -> [].

%% 各章节成就id列表
<?php
foreach ($group as $k => $g) {
    $last = array_pop($g);
    echo "groups({$k}) -> [";
    foreach ($g as $v) {
        echo "{$v}, ";
    }
    echo "{$last}];\n";
}
?>
groups(_) -> [].

<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$data1 = array_reverse($data);
?>
%% 点数对应阶段
<?php
foreach($data1 as $v) {
    $v['title'] = $v['title'] ? $v['title'] : 0;
    echo "point_lev(Point) when Point >= {$v['point']} -> {$v['lev']};\n";
}
?>
point_lev(_) -> 0.

%% 阶段奖励
<?php
foreach($data1 as $v) {
    echo "lev_reward(Lev) when Lev >= {$v['lev']} -> " . gen_record($v['gain']) . ";\n";
}
?>
lev_reward(_) -> [].

%% 章节奖励称号
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $v){
   echo "group_title({$v['group']}) -> {$v['title']};\n";
}
?>
group_title(_) -> 0.

%% 全部章节
all_group() ->[<?php
$last = array_pop($data);
foreach ($data as $v){
    echo "{$v['group']}, ";
}
echo $last['group']
?>].