%%----------------------------------------------------
%% 活动抽奖
%% @author sy
%%----------------------------------------------------
-module(act_integral_data).

-include("gain.hrl").

-export([
	go_shop/3
]).





%% 获取积分商城信息
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
	$loss = gen_record($v['loss']);
    echo "go_shop({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$v['day']}, {$gain}, {$loss}, {$v['limit']}];\n";
}
echo "go_shop(_, _, _) -> false.\n";
?>





