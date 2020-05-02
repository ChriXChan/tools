%% -----------------------------------------------------------------------------
%% 护送数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(escort_data).

-export([gain/1
    , buff/1
    , free_rate/1
    , free_total/0
    , up_loss/1
    , one_loss/1
    , max/0
    , all/0
    , skill_cost/1
    , skill_rate/1
    , skill_total/0
    , skill_max/1
    , skill_count/1
    , all_skill/0
    , label/1
    , end_exp/2
    , timer_exp/2
    , rank_gain/1
]).

-include("gain.hrl").

%% 护送奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$max = 0;
$all = array();
foreach ($data as $row) {
    if ($row['quality'] != '' && $row['gain'] != '') {
        $all[] = $row['quality'];
        if ($row['quality'] > $max)
            $max = $row['quality'];
        $gain = gen_record($row['gain']);
        echo "gain({$row['quality']}) -> {$gain};\n";
    }
}
?>
gain(_) -> [].

%% 加速buff
<?php
foreach ($data as $row) {
    if ($row['quality'] != '' && $row['buff_id'] != '')
        echo "buff({$row['quality']}) -> {$row['buff_id']};\n";
}
?>
buff(_) -> false.

%% 免费提品权重
<?php
$total_rate = 0;
foreach ($data as $row) {
    if ($row['quality'] != '' && $row['free_rate'] != '') {
        $total_rate += $row['free_rate'];
        echo "free_rate({$row['quality']}) -> {$row['free_rate']};\n";
    }
}
?>
free_rate(_) -> 0.

%% 免费提品总权重
<?php
echo "free_total() -> {$total_rate}.\n";
?>

%% 手动提升到下一品质的消耗
<?php
foreach ($data as $row) {
    if ($row['quality'] != '' && $row['up_loss'] != '') {
        $loss = gen_record($row['up_loss']);
        echo "up_loss({$row['quality']}) -> {$loss};\n";
    }
}
?>
up_loss(_) -> [].

%% 一键提品到最高品质消耗
<?php
foreach ($data as $row) {
    if ($row['quality'] != '' && $row['one_loss'] != '') {
        $loss = gen_record($row['one_loss']);
        echo "one_loss({$row['quality']}) -> {$loss};\n";
    }
}
?>
one_loss(_) -> [].

%% 最高品质
<?php
echo "max() -> {$max}.\n"
?>

%% 品质列表
all() -> [<?php
$last = array_pop($all);
foreach ($all as $k => $v)
    echo "{$v}, ";
echo "{$last}].\n";
?>

%% 技能兑换消耗点数
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$all = array();
foreach ($data as $row) {
    if ($row['skill_id'] != '' && $row['cost'] != '') {
        $all[] = $row['skill_id'];
        echo "skill_cost({$row['skill_id']}) -> {$row['cost']};\n";
    }
}
?>
skill_cost(_) -> false.

%% 技能随机权重
<?php
$total_rate = 0;
foreach ($data as $row) {
    if ($row['skill_id'] != '' && $row['rate'] != '') {
        $total_rate += $row['rate'];
        echo "skill_rate({$row['skill_id']}) -> {$row['rate']};\n";
    }
}
?>
skill_rate(_) -> 0.

%% 技能随机总权重
<?php
echo "skill_total() -> {$total_rate}.\n";
?>

%% 技能累计次数
<?php
foreach ($data as $row) {
    if ($row['skill_id'] != '' && $row['max'] != '')
        echo "skill_max({$row['skill_id']}) -> {$row['max']};\n";
}
?>
skill_max(_) -> 0.

%% 技能初始次数
<?php
foreach ($data as $row) {
    if ($row['skill_id'] != '' && $row['count'] != '')
        echo "skill_count({$row['skill_id']}) -> {$row['count']};\n";
}
?>
skill_count(_) -> 0.

%% 技能列表
all_skill() -> [<?php
$last = array_pop($all);
foreach ($all as $k => $v)
    echo "{$v}, ";
echo "{$last}].\n";
?>

%% 其他配置
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['label'] != '' && $row['val'] != '') {
        if ($row['label'] == 'start_area' || $row['label'] == 'end_area' || $row['label'] == 'slow_area' || $row['label'] == 'random_area' || $row['label'] == 'prepare_point' || $row['label'] == 'enter_point' || $row['label'] == 'round')
            echo "label({$row['label']}) -> [{$row['val']}];    %% {$row['desc']}\n";
        elseif ($row['label'] == 'once_gain') {
            $gain = gen_record($row['val']);
            echo "label({$row['label']}) -> {$gain};    %% {$row['desc']}\n";
        } else
            echo "label({$row['label']}) -> {$row['val']};    %% {$row['desc']}\n";
    }
}
?>
label(_) -> false.

%% 结算奖励经验
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
$data = array_reverse($data);
foreach ($data as $row) {
    if ($row['lev'] != '' && $row['quality'] != '' && $row['end_exp'] != '')
        echo "end_exp(Level, {$row['quality']}) when Level >= {$row['lev']} -> {$row['end_exp']};    %% {$row['desc']}\n";
}
?>
end_exp(_, _) -> 0.

%% 定时奖励经验
<?php
foreach ($data as $row) {
    if ($row['lev'] != '' && $row['quality'] != '' && $row['timer_exp'] != '')
        echo "timer_exp(Level, {$row['quality']}) when Level >= {$row['lev']} -> {$row['timer_exp']};    %% {$row['desc']}\n";
}
?>
timer_exp(_, _) -> 0.

%% 排名奖励
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$data = array_reverse($data);
foreach ($data as $row) {
    if ($row['rank'] != '' && $row['gain'] != '') {
        $gain = gen_record($row['gain']);
        echo "rank_gain(Rank) when Rank >= {$row['rank']} -> {$gain};    %% {$row['desc']}\n";
    }
}
?>
rank_gain(_) -> false.













