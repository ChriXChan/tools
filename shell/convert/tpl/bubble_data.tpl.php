%% -----------------------------------------------------------------------------
%% 好友气泡
%% @author lijingfeng
%% -----------------------------------------------------------------------------
-module(bubble_data).

-export([
get/1
]).

-include("friend.hrl").


%%气泡数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "get(" . $data[$i]['id'] . ") -> #bubble_data{id = " . $data[$i]['id'] .
            ", group = ".$data[$i]['group'] .
            ", vip = ".$data[$i]['vip'] .
            ", date = [" . $data[$i]['date'] . "]};\n";
    }
}
?>
get(_) -> false.