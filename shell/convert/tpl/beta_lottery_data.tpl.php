%% -----------------------------------------------------------------------------
%% 封测抽奖活动
%% @author pb
%% -----------------------------------------------------------------------------
-module(beta_lottery_data).

-export([
        id2gain/1
        ,lottery/0
        ,cast/1
        ,online2cnt/1
        ,all_online/0
        ,hour2cnt/1
        ,crontab/0
    ]).

-include("gain.hrl").

%% 奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $id = $row['id'];
    $gain = gen_record($row['gain']);
    echo "id2gain({$id}) -> {$gain};\n";
}
?>
id2gain(_) -> [].

%% 是否广播
<?php
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $id = $row['id'];
    $cast = $row['cast'];
    if(trim($cast)!=""){
        echo "cast({$id}) -> {$cast};\n";
    }
}
?>
cast(_) -> 0.

<?php
$last = array_pop($data);
?>
%% 相对概率
lottery() ->[<?php
foreach($data as $v) {
    echo "{{$v['id']}, {$v['ratio']}}, ";
}
echo "{{$last['id']}, {$last['ratio']}}].";
?>


%% 每日累计在线增加抽奖次数
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $time = $row['time'];
    $cnt = $row['count'];
    echo "online2cnt({$time}) -> {$cnt};\n";
}
?>
online2cnt(_) -> 0.

<?php
$last = array_pop($data);
?>
%% 所有在线时间
all_online() ->[<?php
foreach($data as $v) {
    echo "{$v['time']}, ";
}
echo "{$last['time']}].";
?>


%% 整点在线增加抽奖次数
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $time = $row['time'];
    $cnt = $row['count'];
    echo "hour2cnt({$time}) -> {$cnt};\n";
}
?>
hour2cnt(_) -> 0.

<?php
$last = array_pop($data);
?>
%% 所有整点
crontab() ->[<?php
foreach($data as $v) {
    echo "{00, {$v['time']}, all, all, all, all, all, all, {beta_lottery, hour, [{$v['time']}]}}, ";
}
echo "{00, {$last['time']}, all, all, all, all, all, all, {beta_lottery, hour, [{$last['time']}]}}].";
?>