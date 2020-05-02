%% -----------------------------------------------------------------------------
%% 魂池数据
%% @author luoxueqing
%% -----------------------------------------------------------------------------
-module(soul_pool_data).

-export([
        get/1
        ,get2/1
        ,all/0
        ,all2/0
    ]).

-include("gain.hrl").
-include("soul_pool.hrl").

%% 获取单个魂池数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);

foreach($data as $v){
    echo "get({$v['id']}) -> #soul_pool_data{id = {$v['id']} , weight = {$v['weight']}, gain = " . gen_record($v['gain']) . "}; \n";
}
?>
get(_) -> false.

all() ->[
<?php
for($i = 0; $i < count($data) - 1; $i++){
    echo "#soul_pool_data{id = {$data[$i]['id']} , weight = {$data[$i]['weight']}, gain = " . gen_record($data[$i]['gain']) . "},\n";
}
echo "#soul_pool_data{id = {$data[$i]['id']} , weight = {$data[$i]['weight']}, gain = " . gen_record($data[$i]['gain']) . "}\n].";
?>

<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);

foreach($data as $v){
    echo "get2({$v['id']}) -> #soul_pool_data{id = {$v['id']} , weight = {$v['weight']}, gain = " . gen_record($v['gain']) . "}; \n";
}
?>
get2(_) -> false.


all2() ->[
<?php
for($i = 0; $i < count($data) - 1; $i++){
    echo "#soul_pool_data{id = {$data[$i]['id']} , weight = {$data[$i]['weight']}, gain = " . gen_record($data[$i]['gain']) . "},\n";
}
echo "#soul_pool_data{id = {$data[$i]['id']} , weight = {$data[$i]['weight']}, gain = " . gen_record($data[$i]['gain']) . "}\n].";
