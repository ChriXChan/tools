%% -----------------------------------------------------------------------------
%% 宠物数据
%% @author lijingfeng
%% -----------------------------------------------------------------------------
-module(wan_shou_data).

-export([
get_suit/2
,get_wan_shou/3
,get_refine/2
,refine_lev/2
,max_refine_lev/1
]).

-include("wan_shou.hrl").
-include("gain.hrl").


%%万兽图套装
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['sub_type']))!=""){
        echo "get_suit(" . $data[$i]['sub_type'] .",". $data[$i]['count'] .
            ") -> [" . attr_to_int($data[$i]['attr']) ."];\n";
    }
}
?>
get_suit(_,_) -> [].


%%万兽图
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['main_type']))!=""){
        echo "get_wan_shou(" . $data[$i]['main_type'] .",".$data[$i]['sub_type'].",".$data[$i]['place'].") -> #wan_shou_data{main_type = " . $data[$i]['main_type'] .
            ", sub_type = ".$data[$i]['sub_type'] .
            ", place = ".$data[$i]['place'] .
            ", attr = [" . attr_to_int($data[$i]['attr']) .
            "], activate_condition = ".gen_record($data[$i]['activate_condition']).
            ", refine_exp = ".$data[$i]['refine_exp'] .
            "};". "\n";
    }
}
?>
get_wan_shou(_,_,_) -> false.



%%炼化表
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['main_type']))!=""){
        echo "get_refine(" . $data[$i]['main_type'] .",".$data[$i]['level'].") ->".
            " [" . attr_to_int($data[$i]['attr']) .
            "];". "\n";
    }
}
?>
get_refine(_,_) -> [].


%%炼化经验
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for($i=sizeof($data) - 1;$i>=0;$i--) {
    $row = $data[$i];
    $level = $row['level'] + 1;
    if ($row['exp'] != 0) {
        echo "refine_lev(" . $row['main_type'] . "," . "Exp) when Exp >=" . $row['exp'] . "-> " . $level.";\n";
    }
}
?>
refine_lev(_,_) -> 0.


%%炼化经验
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);

for($i=sizeof($data) - 2;$i>=0;$i--) {
    $row1 = $data[$i + 1];
    $row2 = $data[$i];
    if ($row1['exp'] == 0) {
        echo "max_refine_lev(" . $row2['main_type'] .")". "-> " . $row2['exp'].";\n";
    }
}
?>
max_refine_lev(_) -> 0.