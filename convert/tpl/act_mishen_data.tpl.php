%%----------------------------------------------------
%% 迷神殿
%% @author sy
%%----------------------------------------------------
-module(act_mishen_data).

-include("gain.hrl").

-export([
	base_configure/2
	, online_to_time/1
	, award_pool/1
]).





%% 基础配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$value = gen_record($v['value']);
	$gold = gen_record($v['gold']);
	$awrd = gen_record($v['awrd']);
    echo "base_configure({$v['act_id']}, {$v['key']}) -> [{$value}, {$gold}, {$awrd}];\n";
}
echo "base_configure(_, _) -> false.\n";
?>


%% 在线次数
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "online_to_time(Time) when Time > {$v['time']} -> {$v['count']};\n";
}
echo "online_to_time(_) -> false.\n";
?>


%% 奖池
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "award_pool({$v['act_id']}) -> [{$v['pool']}];\n";
}
echo "award_pool(_) -> false.\n";
?>




