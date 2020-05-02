%%----------------------------------------------------
%% 合服累充/累消
%% @author sy
%%----------------------------------------------------
-module(act_rank_data).

-include("gain.hrl").

-export([
	get_target_reward/3
	, get_rank_reward/3
	, get_limit/2
]).





%% 获取目标奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_target_reward({$v['act_id']}, {$v['act_ver']}, {$v['id']}) -> [{$v['day']}, {$v['type']}, {$v['value']}, {$gain}];\n";
}
echo "get_target_reward(_, _, _) -> false.\n";
?>

%% 获取目标奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_rank_reward({$v['act_id']}, {$v['day']}, {$v['value']}) -> {$gain};\n";
}
echo "get_rank_reward(_, _, _) -> false.\n";
?>

%% 获取限制
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_limit({$v['act_id']}, {$v['act_ver']}) -> {$v['value']};\n";
}
echo "get_limit(_, _) -> false.\n";
?>








