%% -----------------------------------------------------------------------------
%% 物品数据
%% @author luoxueqing
%% -----------------------------------------------------------------------------
-module(notice_data).
-include("notice.hrl").

-export([
    get/1
    ,get_handle/1
    ,get_open/1
    ]
).

<?php
function parse_row($row){
    echo "get({$row['id']}) ->\n";
    echo "\t#notice_data{id = {$row['id']}, target_type = {$row['target']}, contens = <<\"{$row['contens']}\">>, args = {$row['args']}};\n";
}
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $row){
    parse_row($row);
}
?>
get(_) -> false.

<?php
function parse_handle($row){
    echo "get_handle({$row['id']}) ->\n";
    echo "\t{{$row['id']}, <<\"{$row['str']}\">>, {$row['format']} };\n";
}
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$size = count($data);
foreach($data as $row){
    parse_handle($row);
}
?>
get_handle(_) -> false.


<?php
function parse_open($row){
    echo "get_open({$row['id']}) ->\n";
    echo "\t{{$row['id']}, <<\"{$row['str']}\">>};\n";
}
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$size = count($data);
foreach($data as $row){
    parse_open($row);
}
?>
get_open(_) -> false.