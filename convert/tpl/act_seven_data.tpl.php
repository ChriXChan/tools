%%----------------------------------------------------
%% 活动抽奖
%% @author sy
%%----------------------------------------------------
-module(act_seven_data).

-include("gain.hrl").

-export([
	get_target_reward/3
	,get_final_reward/3
]).





%% 获取最终奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_final_reward({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$v['day']}, {$gain}];\n";
}
echo "get_final_reward(_, _, _) -> false.\n";
?>

%% 获取目标奖励
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_target_reward({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$v['day']}, {$v['target']}, {$gain}];\n";
}
echo "get_target_reward(_, _, _) -> false.\n";
?>





