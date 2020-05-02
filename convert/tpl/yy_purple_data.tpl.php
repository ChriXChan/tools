%% -----------------------------------------------------------------------------
%% YY紫钻 
%% @author sy
%% -----------------------------------------------------------------------------
-module(yy_purple_data).

-export([
        type_item/1
		, get_shop/1
		, type_title/1
		, type_buff/1
    ]).

-include("gain.hrl").


%% 专属礼包
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain = gen_record($v['item']);
    echo "type_item({$v['type']}) -> {{$v['type']}, {$gain}};\n";
}
echo "type_item(_) -> false.\n";
?>

%% 紫钻商店
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain = gen_record($v['gain']);
    $loss = gen_record($v['loss']);
    echo "get_shop({$v['id']}) -> {{$v['id']}, {$v['type']}, {$gain}, {$loss}};\n";
}
echo "get_shop(_) -> false.\n";
?>

%% 专属称号
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "type_title({$v['type']}) -> {$v['title']};\n";
}
echo "type_title(_) -> false.\n";
?>

%% 紫钻Buff
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "type_buff({$v['type']}) -> {$v['id']};\n";
}
echo "type_buff(_) -> false.\n";
?>
