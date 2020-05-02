%%----------------------------------------------------
%% 活跃度数据
%% @author linkeng
%%----------------------------------------------------
<?php

?>
-module(activity_data).
-export([types/0
    , get/1
    , get_max/0
    , reward/3
    , attr/3
    , next/3
    , max_star/0
    , label/1
    , lev_req/3
    , rein_req/3
    , all_daily_reward/0
    , daily_reward/1
    , open_id/1

    , flag2type/1
    , res_gold/1
    , res_types/0
    , realtime/1
    , weekday/1
    , realtime_gain/1
    , realtime_types/0
]).

-include("gain.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
%% 活跃度类型
types() ->[<?php
foreach ($data as $v) {
    echo "{$v['type']}, ";
}
echo "{$last['type']}].\n";
?>

%% 活跃度
<?php
foreach ($data as $v) {
    echo "get(" . $v['type'] . ") -> {" . $v['per'] . ", " . $v['total'] . ", " . $v['find']. "};\n";
}
echo "get(" . $last['type'] . ") -> {" . $last['per'] . ", " . $last['total'] .  ", " . $v['find'] . "};\n";
?>
get(_) -> false.

%% 每日可获取最大星辰之力
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$sum = 0;
foreach ($data as $v) {
    $sum = $sum + $v['per'] * $v['total'];
}
echo "get_max() -> " . $sum . ".\n"
?>

%% 活动开启ID
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    if (trim($v['open_id']) != "") {
        echo "open_id(" . $v['type'] . ")->" . $v['open_id'] . ";\n";
    }
}
?>
open_id(_) -> false.

%% 每星奖励(Type, Step, Star)
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "reward(" . $v['type'] . ", " . $v['period'] . ", " . $v['star'] . ") -> " . gen_record($v['reward']) . ";\n";
}
?>
reward(_, _, _) -> [].

%% 每星属性(Type, Step, Star)
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "attr(" . $v['type'] . ", " . $v['period'] . ", " . $v['star'] . ") -> [" . attr_to_int($v['attr']) . "];\n";
}
?>
attr(_, _, _) -> [].

%% 激活星级所消耗星辰之力(Type, Step, Star)
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$total = 0;
foreach ($data as $v) {
    if ((trim($v['value'])) != "") {
//        $total+=$v['value'];
//        echo "lev_req(" . $v['type'] . ", " . $v['period'] . ", " . $v['star'] . ") -> " . $total . ";\n";
        echo "lev_req(" . $v['type'] . ", " . $v['period'] . ", " . $v['star'] . ") -> " . $v['value'] . ";\n";
    }
}
?>
lev_req(_, _, _) -> false.

%% 激活星级所需转生等级(Type, Step, Star)
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$total = 0;
foreach ($data as $v) {
    if ((trim($v['rein_req'])) != "") {
        echo "rein_req(" . $v['type'] . ", " . $v['period'] . ", " . $v['star'] . ") -> " . $v['rein_req'] . ";\n";
    }
}
?>
rein_req(_, _, _) -> 999.

%% 下个激活星数(Type, Step, Star)
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < sizeof($data) - 1; $i++) {
    echo "next(" . $data[$i]['type'] . ", " . $data[$i]['period'] . ", " . $data[$i]['star'] . ") -> {" . $data[$i + 1]['type'] . ", " . $data[$i + 1]['period'] . ", " . $data[$i + 1]['star'] . "};\n";
    $row = $data[$i];
}
?>
next(_, _, _) -> false.

%% 最大星级
<?php
$max_star = 0;
for ($i = 0; $i < count($data); $i++) {
    if (trim($data[$i]['star']) != "") {
        if ($data[$i]['star'] > $max_star) {
            $max_star = $data[$i]['star'];
        }
    }
}
echo "max_star()->" . $max_star . ".\n";
?>

%% 基本配置
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    if ($v['label'] == 'day_reward' || $v['label'] == 'cross_arena' || $v['label'] == 'cross_tower' || $v['label'] == 'union_war') {
        echo 'label(' . $v['label'] . ') -> ' . gen_record($v['value']) . ';' . "\t%%" . $v['desc'] . "\n";
    } else {
        echo 'label(' . $v['label'] . ') -> ' . $v['value'] . ';' . "\t%%" . $v['desc'] . "\n";
    }
}
?>
label(_) -> false.

%% 所有奖励
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
all_daily_reward() -> [<?php
foreach ($data as $v) {
    echo "{$v['id']}, ";
}
echo "{$last['id']}].\n";
?>

%% 每日进度奖励
<?php
foreach ($data as $v) {
    echo "daily_reward(" . $v['id'] . ") -> " . gen_record($v['reward']) . ";\n";
}
echo "daily_reward(" . $last['id'] . ") -> " . gen_record($last['reward']) . ".\n";
?>

%% flag转资源找回类型
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
$real = array();
foreach ($data as $v) {
    if ($v['realtime'] != '') {
        $real[] = $v;
    }
}
foreach ($data as $v) {
    if ($v['flag'] != '') {
        echo "flag2type({$v['flag']}) -> {$v['type']};\n";
    }
}
?>
flag2type(_) -> false.

%% 资源找回消耗元宝
<?php
foreach ($data as $v) {
    if ($v['gold'] != '') {
        echo "res_gold({$v['type']}) -> {$v['gold']};\n";
    }
}
?>
res_gold(_) -> 0.

%% 全部资源找回类型
res_types() -> [<?php
$last = array_pop($data);
foreach ($data as $v) {
    echo "{$v['type']}, ";
}
echo "{$last['type']}].\n";
?>

%% 实时找回结算时间
<?php
foreach ($real as $v) {
        echo "realtime({$v['type']}) -> [{$v['realtime']}];\n";
}
?>
realtime(_) -> false.

%% 实时找回活动时间
<?php
foreach ($real as $v) {
    echo "weekday({$v['type']}) -> [{$v['weekday']}];\n";
}
?>
weekday(_) -> [].

%% 实时找回奖励
<?php
foreach ($real as $v) {
    $gain = gen_record($v['realtime_gain']);
    echo "realtime_gain({$v['type']}) -> {$gain};\n";
}
?>
realtime_gain(_) -> [].

%% 实时找回类型
realtime_types() -> [<?php
$last = array_pop($real);
foreach ($real as $v) {
    echo "{$v['type']}, ";
}
echo "{$last['type']}].\n";
?>












