%%----------------------------------------------------
%% 等级投资和月投资
%% @author sy
%%----------------------------------------------------
-module(act_fortune_data).

-include("gain.hrl").

-export([
	get_reward/4
	,get_invest/4
]).





%% 获取奖励
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_reward({$v['id']}, {$v['act_id']}, {$v['ver']}, {$v['type']}) -> [{$v['value']}, {$gain}];\n";
}
echo "get_reward(_, _, _, _) -> false.\n";
?>

%% 获取投资种类
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_invest({$v['id']}, {$v['act_id']}, {$v['ver']}, {$v['type']}) -> {$v['gold']};\n";
}
echo "get_invest(_, _, _, _) -> false.\n";
?>





