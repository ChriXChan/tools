%%----------------------------------------------------
%% 充值特惠
%% @author sy
%%----------------------------------------------------
-module(act_preferential_data).


-export([
	get_rata/3
]).





%% 获取奖池
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_rata({$v['act_id']}, {$v['act_ver']}, {$v['id']}) -> [{$v['recharge']}, {$v['loss']}, [{$v['rate']}]];\n";
}
echo "get_rata(_, _, _) -> false.\n";
?>






