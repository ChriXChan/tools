%%----------------------------------------------------
%% 活动抽奖
%% @author sy
%%----------------------------------------------------
-module(act_lottery_data).

-include("gain.hrl").

-export([
	get_reward/2
	,get_rote/4
	,get_data/1
	,get_loss/3
	,get_int/2
	,get_item/4
	,get_limit/3
	, get_limit1/3
]).

%% 奖品信息
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_reward({$v['act_id']},{$v['day']}) -> [{$v['gain']}];\n";
}
echo "get_reward(_,_) -> false.\n";
?>

%% 概率
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_rote({$v['act_id']},{$v['ver']}, {$v['day']}, N) when N >= {$v['times']} -> [{$v['rote']}];\n";
}
echo "get_rote(_, _, _, _) -> false.\n";
?>

%% 基本配置
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_data({$v['label']}) -> {$v['value']};\n";
}
echo "get_data(_) -> false.\n";
?>

%% 消耗配置
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$loss1 = gen_record($v['cost_gold']);
	$loss2 = gen_record($v['cost_silver']);
	$gain = gen_record($v['gain']);
    echo "get_loss({$v['act_id']},{$v['ver']},{$v['num']}) -> [{$loss1},{$loss2},{$gain}];\n";
}
echo "get_loss(_,_,_) -> false.\n";
?>

%% 积分
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_int({$v['act_id']},{$v['ver']}) -> {$v['num']};\n";
}
echo "get_int(_,_) -> false.\n";
?>

%% 积分兑换
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_item({$v['id']},{$v['act_id']},{$v['ver']},{$v['day']}) -> [{$gain}, {$v['point']}, {$v['limit']}];\n";
}
echo "get_item(_,_,_,_) -> false.\n";
?>

%% 次数限制
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_limit({$v['act_id']},{$v['ver']},N) when N >= {$v['times']} -> [{$v['limit1']}, {$v['limit2']}, {$v['limit3']}];\n";
}
echo "get_limit(_, _, _) -> false.\n";
?>

%% 单独获取次数的限制
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_limit1({$v['act_id']},{$v['ver']},{$v['num']}) -> [{$v['limit']}];\n";
}
echo "get_limit1(_,_,_) -> false.\n";
?>







