%%----------------------------------------------------
%% 折扣商店
%% @author sy
%%----------------------------------------------------
-module(act_discount_data).

-include("gain.hrl").

-export([
	shop_configure/3
]).





%% 商店配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
	$loss = gen_record($v['loss']);
    echo "shop_configure({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$v['day']}, {$gain}, {$v['times']}, {$loss}, {$v['limit']}];\n";
}
echo "shop_configure(_, _, _) -> false.\n";
?>




