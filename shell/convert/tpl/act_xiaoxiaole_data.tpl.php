%%----------------------------------------------------
%% 消消乐不停活动
%% @author chen
%%----------------------------------------------------
-module(act_xiaoxiaole_data).

-include("gain.hrl").

-export([
	get_reward/3
	,get_rate/3
	,get_loss/4
	,get_limit/2

]).

%% 奖品信息
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
	$xiaoxiao_award = gen_record($v['xiaoxiao_award']);
    echo "get_reward({$v['act_id']},{$v['ver']},{$v['obj_id']}) -> [{$gain},{$xiaoxiao_award},{$v['news']}];\n";
}
echo "get_reward(_,_,_) -> false.\n";
?>

%% 概率
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_rate({$v['act_id']},{$v['ver']}, N) when N >= {$v['times']} -> [{$v['rate_list']}];\n";
}
echo "get_rate(_, _, _) -> false.\n";
?>

%% 消耗配置
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$loss1 = gen_record($v['cost_list']);
	$gain = gen_record($v['extra_gain']);
    echo "get_loss({$v['act_id']},{$v['ver']},{$v['type']}, N) when N >= {$v['limit']} -> [{$loss1},{$gain}];\n";
}
echo "get_loss(_, _, _,_) -> false.\n";
?>


%% 其他参数
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_limit({$v['act_id']},{$v['ver']}) -> [{$v['daily_free_clean_cnt']},{$v['add_cnt_lottery_cnt']}];\n";
}
echo "get_limit(_,_) -> false.\n";
?>







