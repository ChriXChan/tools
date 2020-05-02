%% -----------------------------------------------------------------------------
%% 温泉数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(spring_data).

-export([label/1
    , exp/1
    , jew_exp/1
]).

-include("gain.hrl").

%% 基本配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $row){
    if($row['label'] == 'collect_reward' || $row['label'] == 'rank_reward1' || $row['label'] == 'rank_reward2'
        || $row['label'] == 'rank_reward3' || $row['label'] == 'rank_reward4' || $row['label'] == 'rank_reward5'){
        $temp = gen_record($row['val']);
        echo "label({$row['label']}) -> {$temp};    %% {$row['desc']}\n";
    }
    elseif ($row['label'] == 'positions' || $row['label'] == 'area' || $row['label'] == 'fly_pos') {
        echo "label({$row['label']}) -> [{$row['val']}];    %% {$row['desc']}\n";
    }
    else {
        echo "label({$row['label']}) -> {$row['val']};    %% {$row['desc']}\n";
    }
}
?>
label(_) -> false.

%% 经验
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$data=array_reverse($data);
foreach ($data as $row){
    if ($row['lev'] != '' && $row['exp'] != '') {
        echo "exp(Level) when Level >= {$row['lev']} -> {$row['exp']};\n";
    }
}
?>
exp(_) -> 0.

%% 珍珠经验
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$data=array_reverse($data);
foreach ($data as $row){
    if ($row['lev'] != '' && $row['jew_exp'] != '') {
        echo "jew_exp(Level) when Level >= {$row['lev']} -> {$row['jew_exp']};\n";
    }
}
?>
jew_exp(_) -> 0.
