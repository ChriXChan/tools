%% -----------------------------------------------------------------------------
%% 鲜花数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(flower_data).

-include("gain.hrl").

-export([all/0
    , name/1
    , self_charm/1
    , charm/1
    , sweetness/1
    , spouse_sweetness/1
    , gain/1
    , effect_id/1
    , cast/1
    , get_exp/1
]).

%% 全部道具
all() -> [<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$last = array_pop($data);
foreach ($data as $row) {
    if ($row['id'] != "") {
        echo "{$row['id']}, ";
    }
}
echo "{$last['id']}].\n";
?>

%% 名字
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['id'] != "" && $row['name'] != "") {
        echo "name({$row['id']}) -> <<\"{$row['name']}\">>;\n";
    }
}
?>
name(_) -> <<>>.

%% 魅力值
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['id'] != "" && $row['self_charm'] != "") {
        echo "self_charm({$row['id']}) -> {$row['self_charm']};\n";
    }
}
?>
self_charm(_) -> 0.

%% 对方魅力值
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['id'] != "" && $row['charm'] != "") {
        echo "charm({$row['id']}) -> {$row['charm']};\n";
    }
}
?>
charm(_) -> 0.

%% 甜蜜度
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['id'] != "" && $row['sweetness'] != "") {
        echo "sweetness({$row['id']}) -> {$row['sweetness']};\n";
    }
}
?>
sweetness(_) -> 0.

%% 对方甜蜜度
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['id'] != "" && $row['spouse_sweetness'] != "") {
        echo "spouse_sweetness({$row['id']}) -> {$row['spouse_sweetness']};\n";
    }
}
?>
spouse_sweetness(_) -> 0.

%% 奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['id'] != "" && $row['gain'] != "") {
        $gain = gen_record($row['gain']);
        echo "gain({$row['id']}) -> {$gain};\n";
    }
}
?>
gain(_) -> [].

%% 特效类型
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['id'] != "" && $row['effect_id'] != "") {
        echo "effect_id({$row['id']}) -> {$row['effect_id']};\n";
    }
}
?>
effect_id(_) -> false.

%% 广播类型
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['id'] != "" && $row['cast'] != "") {
        echo "cast({$row['id']}) -> {$row['cast']};\n";
    }
}
?>
cast(_) -> 0.

%% 是否获得经验
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['id'] != "" && $row['get_exp'] != "") {
        echo "get_exp({$row['id']}) -> {$row['get_exp']};\n";
    }
}
?>
get_exp(_) -> 0.


