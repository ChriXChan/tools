%%----------------------------------------------------
%% 跨服团购
%% @author sy
%%----------------------------------------------------
-module(act_group_data).

-include("gain.hrl").

-export([
	goods_data/3
	, base_configure/1
]).



%% 物品数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "goods_data({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$gain}, {$v['loss']}, {$v['limit']}, [{$v['discount']}], {$v['day']}, {$v['area']}];\n";
}
echo "goods_data(_, _, _) -> false.\n";
?>


%% 杂项
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "base_configure({$v['type']}) -> {$v['value']};\n";
}
echo "base_configure(_) -> false.\n";
?>






