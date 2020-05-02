%%----------------------------------------------------
%% 活动抽奖
%% @author sy
%%----------------------------------------------------
-module(act_bet_data).

-include("gain.hrl").

-export([
	get_reward/3
	, get_reward2/5
	, get_ratio/4
	, get_num/2
	, get_partake_reward/2
]).





%% 获取奖池
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
	$gain3 = gen_record($v['gain3']);
    echo "get_reward({$v['act_id']}, {$v['ver']}, {$v['id']}) -> [{$v['gold']}, {$v['cost_gold']}, {$v['type']}, [{$v['pool']}], {$gain}, {$v['ratio']}, {$gain3}];\n";
}
echo "get_reward(_, _, _) -> false.\n";
?>


%% 获取奖池
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_reward2({$v['act_id']}, {$v['ver']}, {$v['day']}, {$v['num']}, {$v['gold']}) -> [{$gain}, {$v['ratio']}];\n";
}
echo "get_reward2(_, _, _, _, _) -> false.\n";
?>


%% 获取概率
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_ratio({$v['act_id']}, {$v['ver']}, {$v['num']}, {$v['gold']}) -> [{$v['ratio']}];\n";
}
echo "get_ratio(_, _, _, _) -> false.\n";
?>

%% 获取造假人数范围
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_num({$v['num']}, {$v['gold']}) -> {$v['type2']};\n";
}
echo "get_num(_, _) -> false.\n";
?>

%% 获取参与奖
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain2 = gen_record($v['gain2']);
    echo "get_partake_reward({$v['num']}, {$v['gold']}) -> {$gain2};\n";
}
echo "get_partake_reward( _, _) -> false.\n";
?>



