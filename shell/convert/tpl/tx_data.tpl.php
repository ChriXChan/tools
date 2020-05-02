%%----------------------------------------------------
%% 
%% @author sy
%%----------------------------------------------------
-module(tx_data).

-include("gain.hrl").

-export([
	get_reward/3
	,get_hall_reward/3
]).



%% 奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_reward({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$v['type']}, {$v['limit']}, {$gain}];\n";
}
echo "get_reward(_, _, _) -> false.\n";
?>

%% QQ大厅奖励
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_hall_reward(_LibId = {$v['id']}, _ActId = {$v['act_id']}, _Ver = {$v['act_ver']}) -> {{$v['type']}, {$v['limit']}, {$gain}};\n";
}
echo "get_hall_reward(_LibId, _ActId, _Ver) -> false.\n";
?>
