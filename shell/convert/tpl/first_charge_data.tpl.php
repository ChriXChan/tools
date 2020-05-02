%% -----------------------------------------------------------------------------
%% 首冲活动
%% @author pb
%% -----------------------------------------------------------------------------
-module(first_charge_data).

-export([
        target/2
        ,gain/2
        ,label/1
        ,day2id/1
    ]).

-include("gain.hrl").

gain(SrvOpenDay, Step) ->
    {Id, Index} = day2id(SrvOpenDay),
    gain(Id, Index, Step).

target(SrvOpenDay, Step) ->
    {Id, Index} = day2id(SrvOpenDay),
    target(Id, Index, Step).

%% 目标
%% target(Id, Index, Step) -> Target.
%% Id :: int 奖池ID
%% Index :: int 循环第几天
%% Step :: int 档次
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $id = $row['id'];
    $index = $row['index'];
    $target1 = $row['target1'];
    $target2 = $row['target2'];
    $target3 = $row['target3'];
    echo "target({$id}, {$index}, 1) -> {$target1};\n";
    echo "target({$id}, {$index}, 2) -> {$target2};\n"; 
    echo "target({$id}, {$index}, 3) -> {$target3};\n";
}
?>
target(_, _, _) -> false.

%% 奖励
%% target(Id, Index, Step) -> Gain.
%% Id :: int 奖池ID
%% Index :: int 循环第几天
%% Step :: int 档次
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $id = $row['id'];
    $index = $row['index'];
    $gain1 = gen_record($row['gain1']);
    $gain2 = gen_record($row['gain2']);
    $gain3 = gen_record($row['gain3']);
    echo "gain({$id}, {$index}, 1) -> {$gain1};\n";
    echo "gain({$id}, {$index}, 2) -> {$gain2};\n"; 
    echo "gain({$id}, {$index}, 3) -> {$gain3};\n";
}
?>
gain(_, _, _) -> [].

%% 每个奖池循环天数
<?php
$arr = array();
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $id = $row['id'];
    $index = $row['index'];
    if(array_key_exists($id, $arr)){   
        if($arr[$id] < $index){
            $arr[$id] = $index;
        }
    } else{
        $arr[$id] = $index;
    }     
}
?>

%% 基本配置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'first_charge_award'){
        echo 'label('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n"; 
    } else{
        echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
label(_) -> false.

%% 目标
%% day2id(Day) -> {Id, Index}.
%% Day :: int 开服天数
%% Id :: int 奖池ID
%% Index :: int 循环第几天
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $id = $row['id'];
    $open_day = $row['open_day'];
    $str_tmp = str_replace("{", "",$open_day);
    $str_tmp = str_replace("}", "",$str_tmp);
    $arr_cond = explode(",",$str_tmp);
    $open_day1 = $arr_cond[0];
    $open_day2 = $arr_cond[1];
    $max_index = $arr[$id];
    $index = "Index = case (OpenDay - {$open_day1} + 1) rem {$max_index} of 0 -> {$max_index}; Val -> Val end,";
    if ($open_day2 != 0) {
        echo "day2id(OpenDay) when OpenDay >= {$open_day1} andalso OpenDay =< {$open_day2} -> \n";
        echo "\t{$index}" . "\n\t{{$id}, Index};\n";
    } else {
        echo "day2id(OpenDay) when OpenDay >= {$open_day1} -> \n";
        echo "\t{$index}" . "\n\t{{$id}, Index};\n";
    }
    
}
?>
day2id(_) -> {0,0}.