%% -----------------------------------------------------------------------------
%% 灵宝数据
%% @author sy
%% -----------------------------------------------------------------------------
-module(lingbao_data).

-export([
		get_lingbao_level/2
        ,get_lingbao_skill/1
		,get_lingbao_star/2
    ]).

-include("lingbao.hrl").
-include("gain.hrl").
-include("item.hrl").



%%灵宝升级
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
    	echo "get_lingbao_level(" . $data[$i]['id'] .",".$data[$i]['lev'].") -> #lingbao_level_data{id = " . $data[$i]['id'] .",lev = " .$data[$i]['lev'] 
		.",loss = ".gen_record($data[$i]['loss']).",attr = [". attr_to_int($data[$i]['attr'])."]};". "\n";
    }
}
?>
get_lingbao_level(_,_) -> false.

%%灵宝升级激活
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
    	echo "get_lingbao_skill(" .$data[$i]['id'] . 
    	") -> #lingbao_skill_data{id = ". $data[$i]['id'] . ",skill_id = ". $data[$i]['skill_id'] ."};". "\n";
    }
}
?>
get_lingbao_skill(_) -> false.


%%灵宝修炼
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
    	echo "get_lingbao_star(" . $data[$i]['id'] .",".$data[$i]['lev'].") -> #lingbao_star_data{id = " . $data[$i]['id']
    	.",lingbao_star = ".$data[$i]['lev'].
		", loss = ".gen_record($data[$i]['loss']).",attr = [". attr_to_int($data[$i]['attr'])."]};". "\n";
    }
}
?>
get_lingbao_star(_,_) -> false.








