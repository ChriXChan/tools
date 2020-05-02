%%----------------------------------------------------
%% 活动数据
%% @author luoxueqing
%%----------------------------------------------------
-module(act_srv_data).

-include("act_srv.hrl").
-include("gain.hrl").

-export([
    get/2
    , all_keys/0
    , sub/1
    , sub_group/1
    , gambling/2
    , gold_loss_lottery/1
    , daily_total_charge/2
    , daily_total_gold_loss/2
    , daily_single_charge/1
    , daily_single_charge_reward/1
    , vip_outlets/2
	, get_grow_info/2
	, get_grow_type/2
	, daily_group_buy/3
    , grow_rank/1
    , grow_rank_libid2day/2
    , guild_reward/1
    , guild_id/1
	, get_daily_login_reward/1
	, get_total_gold_recharge/3
]).

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
?>
%% 获取活动数据
<?php
foreach ($data as $v) {
    echo "get({$v['id']}, {$v['ver']}) -> {{$v['id']}, {$v['ver']}, <<\"{$v['name']}\">>, {$v['open']}, [{$v['time_rule']}], {$v['plat_limit']}, {$v['srv_rule']}, {$v['client_rule']}, {$v['ex_rule']}};\n";
}
echo "get(_, _) -> false.\n";
?>

%% 获取所有活动key
all_keys() -> [<?php
$last = array_pop($data);
foreach ($data as $v) {
    echo "{{$v['id']}, {$v['ver']}},";
}
echo "{{$last['id']}, {$last['ver']}}";
?>
].

<?php
$data1 = $xml_data[1];
array_shift($data1);
array_shift($data1);
?>
%% 获取规则配置
<?php
foreach ($data1 as $v) {
    $loss = gen_record($v['loss']);
    $gain = gen_record($v['gain']);
    $conds = 0;
    $ex_rule = "[]";
    if (trim($v['conds'])!="") {
        $conds = $v['conds'];
    }
    if (trim($v['ex_rule'])!="") {
        $conds = $v['ex_rule'];
    }
    echo "sub({$v['id']}) -> #act_sub{sub_id = {$v['id']}, id = {{$v['act_id']},{$v['ver']}}, day = {$v['day']}, loss = {$loss}, gain = {$gain}, desc = <<\"{$v['desc']}\">>, conds = {$conds}, ex_rule = {$ex_rule}};\n";
}
echo "sub(_) -> false.\n";
?>

%%
<?php
foreach ($data as $v) {
    $tmp = array();
    foreach ($data1 as $v1) {
        if ($v['id'] == $v1['act_id'] && $v['ver'] == $v['ver'])
            $tmp[] = $v1;
    }
    if (count($tmp) > 0) {
        $last = array_pop($tmp);
        echo "sub_group({{$v['id']},{$v['ver']}}) -> [\n";
        foreach ($tmp as $v) {
            $loss = gen_record($v['loss']);
            $gain = gen_record($v['gain']);
            $conds = 0;
            $ex_rule = "[]";
            if (trim($v['conds'])!="") {
                $conds = $v['conds'];
            }
            if (trim($v['ex_rule'])!="") {
                $conds = $v['ex_rule'];
            }
            echo "    #act_sub{sub_id = {$v['id']}, id = {{$v['act_id']},{$v['ver']}}, day = {$v['day']}, loss = {$loss}, gain = {$gain}, desc = <<\"{$v['desc']}\">>, conds = {$conds}, ex_rule = {$ex_rule}},\n";
        }
        $loss = gen_record($last['loss']);
        $gain = gen_record($last['gain']);
        $conds = 0;
        $ex_rule = "[]";
        if (trim($last['conds'])!="") {
            $conds = $last['conds'];
        }
        if (trim($last['ex_rule'])!="") {
            $conds = $last['ex_rule'];
        }
        echo "    #act_sub{sub_id = {$last['id']}, id = {{$last['act_id']},{$last['ver']}}, day = {$last['day']}, loss = {$loss}, gain = {$gain}, desc = <<\"{$last['desc']}\">>, conds = {$conds}, ex_rule = {$ex_rule}}];\n";
    }
}
?>
sub_group(_) -> [].

%% 消费夺宝
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $loss = gen_record($v['loss']);
    $gain2 = gen_record($v['gain2']);
    echo "gambling({$v['id']}, {$v['day']}) -> {{$v['id']}, {$v['day']}, {$loss}, [{$v['gain1']}], {$gain2}, {$v['init_gold']}, {$v['add_gold']}};\n";
}
echo "gambling(_, _) -> false.\n";
?>

%% 主题抽奖
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "gold_loss_lottery({$v['label']}) -> [{$v['value']}];\n";
}
echo "gold_loss_lottery(_) -> false.\n";
?>

%% 每日累充
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain = gen_record($v['gain']);
    echo "daily_total_charge({$v['id']}, {$v['day']}) -> {{$v['id']}, {$v['day']}, {$v['cond']}, {$gain}};\n";
}
echo "daily_total_charge(_, _) -> false.\n";
?>

%% 每日累消
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain = gen_record($v['gain']);
    echo "daily_total_gold_loss({$v['id']}, {$v['day']}) -> {{$v['id']}, {$v['day']}, {$v['cond']}, {$gain}};\n";
}
echo "daily_total_gold_loss(_, _) -> false.\n";
?>

%% 单笔充值
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'cond', SORT_DESC);
foreach ($data as $v) {
    echo "daily_single_charge(Charge) when Charge >= {$v['cond']}-> [{$v['contain']}];\n";
}
echo "daily_single_charge(_) -> [].\n";
foreach ($data as $v) {
    $gain = gen_record($v['gain']);
    echo "daily_single_charge_reward({$v['id']}) -> {$gain};\n";
}
echo "daily_single_charge_reward(_) -> [].\n";
?>

%% VIP折扣商店
<?php
$data = $xml_data[7];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain = gen_record($v['gain']);
    $loss = gen_record($v['loss']);
    echo "vip_outlets({$v['id']}, {$v['day']}) -> {{$v['id']}, {$v['day']}, {$v['cond']}, {$v['limit']}, {$gain}, {$loss}};\n";
}
echo "vip_outlets(_, _) -> false.\n";
?>


%% 首冲团购
<?php
$data = $xml_data[8];
array_shift($data);
array_shift($data);
foreach($data as $v) {
	$gain = gen_record($v['gain']);
	echo "daily_group_buy({$v['id']}, {$v['day']}, {$v['act_id']}) -> {{$v['id']}, {$v['day']}, {$gain}, {$v['limit']}, {$v['gold']}};\n";
}
echo "daily_group_buy(_, _, _) -> false.\n";
?>


%% 进阶返利
<?php
$data = $xml_data[9];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain = gen_record($v['gain']);
	$gain_first = gen_record($v['gain_first']);
    echo "get_grow_info({$v['id']}, {$v['day']}) -> {{$v['id']}, {$v['day']}, {$v['val']}, {$gain}, {$gain_first}};\n";
}
echo "get_grow_info(_, _) -> false.\n";
?>

%% 进阶返利-进阶类型
<?php
$array = array();
foreach ($data as $v) {
	$act_id = $v['act_id'];
    $ver = $v['ver'];
    $day = $v['day'];
	$type = $v['type'];
	$key = $act_id . "_".$ver."_".$day;
	$array[$key] = $type;
}
foreach ($array as $key => $value) {
	$arr = explode("_",$key);  
	$act_id = $arr[0];
    $ver = $arr[1];
    $day = $arr[2];
    echo "get_grow_type({{$act_id}, {$ver}}, {$day}) -> {$value};\n";
}
echo "get_grow_type(_, _) -> false.\n";
?>


%% 进阶排行
<?php
$data = $xml_data[10];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain1 = gen_record($v['gain_1']);
    $gain2 = gen_record($v['gain_2']);
    $gain3 = gen_record($v['gain_3']);
    $gain4 = gen_record($v['gain_4']);
    echo "grow_rank(_Day = {$v['day']}) -> {{$gain1}, {$gain2}, {$gain3}, {$v['rank_step']}, {$gain4}, {$v['step']}, {$v['type']}};\n";
}
echo "grow_rank(_Day) -> false.\n";
?>

<?php
$data = $xml_data[10];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "grow_rank_libid2day(_LibId = {$v['id']}, _Ver = {$v['ver']}) -> {$v['day']};\n";
}
echo "grow_rank_libid2day(_LibId, _Ver) -> false.\n";
?>

<?php
$data = $xml_data[11];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $chief_reward = gen_record($v['chief_reward']);
    $reward = gen_record($v['reward']);
    echo "guild_reward(_LibId = {$v['id']}) -> [{$chief_reward}, {$reward}];\n";
}
echo "guild_reward(_) -> false.\n";
?>

<?php
foreach ($data as $v) {
    echo "guild_id({$v['cond']}) -> {$v['id']};\n";
}
echo "guild_id(_) -> false.\n";
?>

<?php
$data = $xml_data[12];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $reward = gen_record($v['reward']);
    echo "get_daily_login_reward({$v['id']}) -> [{$v['day']}, {$reward}];\n";
}
echo "get_daily_login_reward(_) -> false.\n";
?>

<?php
$data = $xml_data[13];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $reward = gen_record($v['reward']);
    echo "get_total_gold_recharge({$v['id']}, {$v['act_id']}, {$v['ver']}) -> {$reward};\n";
}
echo "get_total_gold_recharge(_, _, _) -> false.\n";
?>




