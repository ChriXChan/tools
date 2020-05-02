%% -----------------------------------------------------------------------------
%% 称号数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(title_data).

-export([get/1
    , grant/0
    , plat_title/1
]).

-include("title.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
?>
%% 称号数据
<?php
foreach($data as $v) {
    if ($v['id'] != '') {
    $attr = attr_to_int($v['attr']);
    echo <<<EOF
get(_Id = {$v['id']}) -> #title_data{id = {$v['id']}, name = <<"{$v['name']}">>, type = {$v['type']}, output = {$v['output']}, buff = {$v['buff']}, attr = [$attr], unique = {$v['unique']}, end_time = {$v['time']}};

EOF;
}}
?>
get(_) -> false.

<?php
$i = 0;
$all = array();
foreach($data as $v) {
    if ($v['output'] == 1)
        $all[++$i] = $v['id'];
}
?>
%% 
grant() -> [<?php
$n = count($all);
if ($n > 0)
{
    for($i = 1; $i < $n; $i++)
    {
        echo "$all[$i],";
    }
    echo "$all[$n]";
}
?>].

<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
?>
%% 平台称号
<?php
foreach($data as $v) {
    echo "plat_title({$v['server_id']}) -> {$v['title_id']};\n";
}
?>
plat_title(_) -> false.



