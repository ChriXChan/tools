%%----------------------------------------------------
%% 充值翻倍
%% @author sy
%%----------------------------------------------------
-module(act_double_data).

-export([
	get_goal/3
	, get_turntable/3
]).








%% 获取充值消费目标
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_goal({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$v['recharge']}, {$v['consume']}];\n";
}
echo "get_goal(_, _, _) -> false.\n";
?>


%% 获取参与奖
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_turntable({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$v['base']}, [{$v['rate']}]];\n";
}
echo "get_turntable( _, _, _) -> false.\n";
?>



