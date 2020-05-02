%% -----------------------------------------------------------------------------
%% 头像数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(icon_data).

-export([icon/2]).

-include("condition.hrl").
-include("gain.hrl").
-include("common.hrl").
-include("icon.hrl").


%%头像数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "icon(" . $data[$i]['face_id'] .",". $data[$i]['sex'] .
            ") -> #icon_data{".
            "cost = [".$data[$i]['cost'] .
            "],time = [". $data[$i]['time'] ."]};". "\n";
    }
}
?>
icon(_,_) -> false.