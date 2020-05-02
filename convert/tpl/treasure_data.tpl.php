%% -----------------------------------------------------------------------------
%% 文本数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(treasure_data).

-include("gain.hrl").

-export([map/1
    , pos/1
    , loss/1
    , dup_id/1
    , event_list/0
    , event_total/0
    , item_list/0
    , item_total/0
    , award/1
    , all_award/0
]).

%% 地图
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$data = array_reverse($data);
foreach ($data as $v) {
    if ($v['level'] != '' && $v['map'] != '') {
        echo "map(Level) when Level >= {$v['level']} -> {$v['map']};\n";
    }
}
?>
map(_) -> 0.

%% 坐标
<?php
foreach ($data as $v) {
    if ($v['level'] != '' && $v['pos'] != '') {
        echo "pos(Level) when Level >= {$v['level']} -> [{$v['pos']}];\n";
    }
}
?>
pos(_) -> [].

%% 消耗
<?php
foreach ($data as $v) {
    if ($v['level'] != '' && $v['loss'] != '') {
        $loss = gen_record($v['loss']);
        echo "loss(Level) when Level >= {$v['level']} -> {$loss};\n";
    }
}
?>
loss(_) -> [].

%% 副本
<?php
foreach ($data as $v) {
    if ($v['level'] != '' && $v['dup_id'] != '') {
        echo "dup_id(Level) when Level >= {$v['level']} -> {$v['dup_id']};\n";
    }
}
?>
dup_id(_) -> 0.

%% 事件概率
event_list() -> [<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$last = array_pop($data);
$total_ratio = 0;
foreach ($data as $v) {
    if ($v['type'] != '' && $v['ratio'] != '') {
        $total_ratio += $v['ratio'];
        echo "{{$v['type']}, {$v['ratio']}}, ";
    }
}
$total_ratio += $last['ratio'];
echo "{{$last['type']}, {$last['ratio']}}].\n";
?>

%% 事件总概率
<?php
echo "event_total() -> {$total_ratio}.\n";
?>

%% 物品事件奖励
item_list() -> [
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$last = array_pop($data);
$total_ratio = 0;
foreach ($data as $v) {
    if ($v['gain'] != '' && $v['ratio'] != '') {
        $total_ratio += $v['ratio'];
        $gain = gen_record($v['gain']);
        echo "{{$gain}, {$v['ratio']}}\n    , ";
    }
}
$total_ratio += $last['ratio'];
$gain = gen_record($last['gain']);
echo "{{$gain}, {$last['ratio']}}\n    ].\n";
?>

%% 物品奖励总概率
<?php
echo "item_total() -> {$total_ratio}.\n";
?>

%% 阶段奖励
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    if ($v['count'] != '' && $v['gain'] != '') {
        $gain = gen_record($v['gain']);
        echo "award({$v['count']}) -> {$gain};\n";
    }
}
?>
award(_) -> [].

%% 全部阶段奖励
all_award() -> [<?php
$last = array_pop($data);
foreach ($data as $v) {
    if ($v['count'] != '' && $v['gain'] != '') {
        echo "{$v['count']}, ";
    }
}
echo "{$last['count']}].\n";
?>








