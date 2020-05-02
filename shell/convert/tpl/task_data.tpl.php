%%----------------------------------------------------
%% 任务数据
%% @author pb
%%----------------------------------------------------
<?php

//完成任务条件
function get_cond($input){
    $output="";
    if($input != ""){
    	$str_tmp = str_replace("(", "",$input);
        $str_tmp = str_replace(")", "",$str_tmp);
        $arr_attr = explode("\n",$str_tmp);    
        
        for($i = 0; $i < count($arr_attr); $i++){
            if((trim($arr_attr[$i]))!=""){
                $arr_cond = explode(",",$arr_attr[$i]);                
                $output_tmp = "";
                $output_tmp = "#task_progress{label = ".trim($arr_cond[0]).", index = ".trim($arr_cond[1]).", target = ".trim($arr_cond[2]).", target_value = ".trim($arr_cond[3])."}";
                $output = $output.$output_tmp;
            }
        }
    }
    return "[".$output."]";
}

?>
-module(task_data).
-export([
        get/1
        ,next_main/1
        ,all_branch/1
        ,get_task_pos/1
        ,all_daily_num/0
        ,daily_ext_reward/1
        ,all_gdaily_num/0
        ,gdaily_ext_reward/1
        ,daily_progress_count/1
        ,gdaily_progress_count/1
        ,daily_reward/1
        ,daily_max/1
        ,daily_loss/1
        ,daily_reset/1
        ,daily_task_list/1
        ,gdaily_task_list/1
        ,label/1
        ,all_guild_wanted_task/1
        ,all_guild_wanted_task2/1
        ,simple_task_reward/1
        ,simple_task_progress/1
		,pos2gain/1
		,turntable/0
		,num2cnt/1
		,get_key_reward/1
		,key_table/0
        ,city_task_list/1
        ,city_task_box/1
        ,city_task_num/1
    ]
).
-include("task.hrl").
-include("common.hrl").
-include("condition.hrl").
-include("gain.hrl").

%% 获取任务基础数据
<?php
$tasks = $xml_data[0];
for($i=2; $i<sizeof($tasks); $i++){
    $row = $tasks[$i];
    if (trim($row['id']) != "") {
        if (is_numeric($row['trigger'])) {
            $trigger = $row['trigger'];
        } else {
            $trigger = 0;
        }

        if (trim($row['progress']) != "") {
            $progress = get_cond($row['progress']);
        } else {
            $progress = "[]";
        }

        $commit_rewards = gen_record($row['award']);    
        echo "get({$row['id']}) -> #task_base{id = {$row['id']}, name = <<\"{$row['name']}\">>, lev = {$row['level']}, type = {$row['type']}, trigger = {$trigger}, progress = {$progress}, commit_rewards = {$commit_rewards}};"."\n";            
    }
}
?>
get(_) -> false.

%% 后继主线任务
<?php
$all_main = array();
$all_next = array();
for($i=2; $i<sizeof($tasks); $i++){
    $row = $tasks[$i];
    if (trim($row['id']) != "" && $row['type'] == 1) {
        array_push($all_main, $row['id']);
        if (is_numeric($row['next_main'])) {
            array_push($all_next, $row['next_main']);
            echo "next_main({$row['id']}) -> {$row['next_main']};"."\n";
        }
    }
}
$first_main_task = current(array_diff($all_main, $all_next));
echo "next_main(0) -> $first_main_task;"."\n";
?>
next_main(_) -> false.

%% 当前等级所有可接支线任务
<?php
$lev_branch = array();
for($i=2; $i<sizeof($tasks); $i++){
    $row = $tasks[$i];
    if (trim($row['id']) != "" && $row['type'] == 2) {
        $lev = $row['level'];
        $lev_branch[$lev][] = $row['id']; 
    }
}
$list = "";
$lev_task = array();
ksort($lev_branch);
foreach ($lev_branch as $key => $value) {
    $last = array_pop($value);
    foreach ($value as $index => $task_id) {
        $list  = $list . $task_id . ", ";
    }
    $list = $list . $last;
    $lev_task[$key] = $list;
    $list = $list . ", ";
}
krsort($lev_task);
foreach ($lev_task as $key => $value) {
    echo "all_branch(Lev) when Lev >= {$key} -> [{$value}];"."\n";
}

?>
all_branch(_) -> false.

get_task_pos(_) -> false.

%% 日常任务额外奖励
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for($i=0; $i<sizeof($data); $i++){
    $row = $data[$i];
    if (trim($row['num']) != "" && trim($row['reward']) != "") {
        $reward = gen_record($row['reward']);
        echo "daily_ext_reward({$row['num']}) -> {$reward};"."\n";
    }
}
?>
daily_ext_reward(_) -> [].

%% 所有日常任务额外奖励环数
<?php
$last = array_pop($data);
?>
%% 层数
all_daily_num() ->[<?php
foreach($data as $v) {
    echo "{$v['num']}, ";
}
echo "{$last['num']}].";
?>


%% 日常任务额外奖励
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for($i=0; $i<sizeof($data); $i++){
    $row = $data[$i];
    if (trim($row['num']) != "" && trim($row['reward']) != "") {
        $reward = gen_record($row['reward']);
        echo "gdaily_ext_reward({$row['num']}) -> {$reward};"."\n";
    }
}
?>
gdaily_ext_reward(_) -> [].

%% 所有日常任务额外奖励环数
<?php
$last = array_pop($data);
?>
%% 层数
all_gdaily_num() ->[<?php
foreach($data as $v) {
    echo "{$v['num']}, ";
}
echo "{$last['num']}].";
?>


%% 日常任务进度达标数量
<?php
$data = $xml_data[3];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    echo "daily_progress_count({$row['num']}) -> {$row['count']};"."\n";
}
?>
daily_progress_count(_) -> false.

%% 帮会日常任务进度达标数量
<?php
$data = $xml_data[4];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    echo "gdaily_progress_count({$row['num']}) -> {$row['count']};"."\n";
}
?>
gdaily_progress_count(_) -> false.

%% 日常任务完成奖励
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $reward = gen_record($row['reward']);
    echo "daily_reward({$row['label']}) -> {$reward};"."\n"; 
}
?>
daily_reward(_) -> [].

%% 日常任务最大环数
<?php
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    echo "daily_max({$row['label']}) -> {$row['circle']};"."\n"; 
}
?>
daily_max(_) -> 20.

%% 日常快速完成消耗
<?php
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    echo "daily_loss({$row['label']}) -> {$row['cost']};"."\n"; 
}
?>
daily_loss(_) -> 3.

%% 日常任务充值消耗元宝
<?php
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    echo "daily_reset({$row['label']}) -> {$row['reset']};"."\n"; 
}
?>
daily_reset(_) -> 3.

%% 日常任务列表
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    echo "daily_task_list(Lev) when Lev >= {$row['lev']} -> {$row['task_list']};"."\n"; 
}
?>
daily_task_list(_) -> [].

%% 帮会日常任务列表
<?php
$data = $xml_data[7];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    echo "gdaily_task_list(Lev) when Lev >= {$row['lev']} -> {$row['task_list']};"."\n"; 
}
?>
gdaily_task_list(_) -> [].

%% 基本配置
<?php
$data = $xml_data[8];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'guild_wanted_ext_reward' || $data[$i]['label'] == 'guild_wanted_reset' || $data[$i]['label'] == 'hang_drop_show' || $data[$i]['label'] == 'guild_xuanshang_box_reward'){
        echo 'label('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['null']."\n"; 
    } else{
        echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['null']."\n";
    }
}
?>
label(_) -> false.


%% 所有帮会悬赏任务
<?php
$data = $xml_data[10];
array_shift($data);
array_shift($data);
$task = array();
$task2 = array();
$list = "";
$list2 = "";
$data = array_sort($data, 'open', SORT_ASC);
for($i=0; $i<sizeof($data); $i++){
    $row = $data[$i];
    if (trim($row['open']) != "" && trim($row['task']) != "") {
        if (trim($list) != "") {
            $list = $list . ", " . $row['task'];
        } else {
            $list = $row['task'];
        }
        $task[$row['open']] = $list;   
    }

    if (trim($row['open']) != "" && trim($row['task2']) != "") {
        if (trim($list2) != "") {
            $list2 = $list2 . ", " . $row['task2'];
        } else {
            $list2 = $row['task2'];
        }
        $task2[$row['open']] = $list2;   
    }
}
$task = array_reverse($task, true);
foreach ($task as $key => $value) {
    echo "all_guild_wanted_task(Open) when Open >= {$key} -> [{$value}];\n";
}
echo "all_guild_wanted_task(_) -> [].\n\n";
$task2 = array_reverse($task2, true);
foreach ($task2 as $key => $value) {
    echo "all_guild_wanted_task2(Open) when Open >= {$key} -> [{$value}];\n";
}
echo "all_guild_wanted_task2(_) -> [].\n";
?>

%% 获取任务基础数据
<?php
$tasks = $xml_data[9];
for($i=2; $i<sizeof($tasks); $i++){
    $row = $tasks[$i];
    $progress = $row['progress'];
    if (trim($row['id']) != "") {
        if((trim($progress))!=""){
            $arr_cond = explode(",",$progress);                
            $target = trim($arr_cond[2]);
            $target_value = trim($arr_cond[3]);
        }
        echo "simple_task_progress({$row['id']}) -> {{$target}, {$target_value}};"."\n";            
    }
}
?>
simple_task_progress(_) -> false.

<?php
$tasks = $xml_data[9];
for($i=2; $i<sizeof($tasks); $i++){
    $row = $tasks[$i];
    if (trim($row['id']) != "") {
        $commit_rewards = gen_record($row['award']);  
        echo "simple_task_reward({$row['id']}) -> {$commit_rewards};"."\n";            
    }
}
?>
simple_task_reward(_) -> [].


%% 奖励
<?php
$data = $xml_data[11];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $pos = $row['pos'];
    $item_id = gen_record($row['item_id']);
    echo "pos2gain({$pos}) -> {$item_id};\n";
}
?>
pos2gain(_) -> [].


<?php
$last = array_pop($data);
?>
%% 相对概率
turntable() ->[<?php
foreach($data as $v) {
    echo "{{$v['pos']}, {$v['rate']}}, ";
}
echo "{{$last['pos']}, {$last['rate']}}].";
?>

%% 累计完成任务增加抽奖次数
<?php
$data = $xml_data[12];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $task_num = $row['task_num'];
    $cnt = $row['count'];
    echo "num2cnt(Num) when Num >= {$row['task_num']} -> {$cnt};\n";
}
?>
num2cnt(_) -> 0.

%% 宗门悬赏宝箱奖励
<?php
$data = $xml_data[14];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $pos = $row['pos'];
    $reward = gen_record($row['reward']);
    echo "get_key_reward({$pos}) -> {$reward};\n";
}
?>
get_key_reward(_) -> [].


<?php
$last = array_pop($data);
?>
%% 相对概率
key_table() ->[<?php
foreach($data as $v) {
    echo "{{$v['pos']}, {$v['weight']}}, ";
}
echo "{{$last['pos']}, {$last['weight']}}].";
?>


%% 城主战任务列表
<?php
$data = $xml_data[15];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    echo "city_task_list(Lev) when Lev >= {$row['lev']} -> {$row['task_list']};"."\n"; 
}
?>
city_task_list(_) -> [].

%% 城主战任务宝箱
<?php
$data = $xml_data[16];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $loss = gen_record($row['loss']);
    $own_box = gen_record($row['own_box']);
    $box = gen_record($row['box']);
    $redpacket = $row['redpacket'];
    $add_num = $row['add_num'];
    $notice_id = $row['notice_id'];
    echo "city_task_box({$row['id']}) -> {{$loss}, {$own_box}, {$box}, {$redpacket}, {$add_num}, {$notice_id}};"."\n"; 
}
?>
city_task_box(_) -> false.

%% 城主战任务进度
<?php
$data = $xml_data[17];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $num = $row['num'];
    $own_num_reward = gen_record($row['own_num_reward']);
    $num_reward = gen_record($row['num_reward']);
    $notice_id = $row['notice_id'];
    echo "city_task_num({$row['id']}) -> {{$num}, {$own_num_reward}, {$num_reward}, {$notice_id}};"."\n"; 
}
?>
city_task_num(_) -> false.