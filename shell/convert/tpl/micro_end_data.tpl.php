%%----------------------------------------------------
%% 平台微端
%% @author sy
%%----------------------------------------------------
-module(micro_end_data).

-include("gain.hrl").

-export([
	get_reward/3
]).





%% 获取奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$reward = gen_record($v['reward']);
    echo "get_reward({$v['act_id']}, {$v['act_ver']}, {$v['id']}) -> [{$reward}];\n";
}
echo "get_reward(_, _, _) -> false.\n";
?>



