%% -----------------------------------------------------------------------------
%% 跨服竞技场
%% @author lsb
%% -----------------------------------------------------------------------------
-module(cross_arena_data).

-export([
        grade/1
        ,max_grade/0
        ,item/1
        ,daily/1
        ,award/2
        ,value/1
        ,max_num/0
        ,score/2
        ,get_match_grade_diff/1
        ,playoffs_reward/2
        ,exp/1
    ]).

-include("gain.hrl").

%% 段位
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$max_grade = 0;
for($i = sizeof($data) - 1; $i >= 0; $i--){
    $row = $data[$i];
    $max_grade = max($max_grade, $row['grade']);
?>
grade(Score) when Score >= <?php echo $row['score']?> -> <?php echo $row['grade']?>;
<?php }?>
grade(_) -> 0.

max_grade() -> <?php echo $max_grade?>.

%% 物品奖励
<?php
for($i = sizeof($data) - 1; $i >= 0; $i--){
    $row = $data[$i];
?>
item(<?php echo $row['grade']?>) -> <?php echo gen_record($row['item'])?>;
<?php }?>
item(_) -> [].

%% 每日奖励
<?php
for($i = sizeof($data) - 1; $i >= 0; $i--){
    $row = $data[$i];
?>
daily(<?php echo $row['grade']?>) -> <?php echo gen_record($row['daily'])?>;
<?php }?>
daily(_) -> [].

%% 基准积分,0-失败，1-成功，2平手
<?php
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    echo "score({$row['grade']}, 1) -> {$row['win_score']};"."\n";     
} 
?>
score(0, 1) -> score(1, 1);
score(_, 1) -> 0;
<?php
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    echo "score({$row['grade']}, 0) -> {$row['loss_score']};"."\n";     
} 
?>
score(0, 0) -> score(1, 0);
score(_, 0) -> 0;
<?php
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    echo "score({$row['grade']}, 2) -> {$row['tie_score']};"."\n";     
} 
?>
score(0, 2) -> score(1, 2);
score(_, 2) -> 0;
score(_, _) -> 0.


%% 挑战奖励
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$maxnum = 0;
for($i = sizeof($data) - 1; $i >= 0; $i--){
    $row = $data[$i];
    if($row['fame'] == 0){
        if($maxnum == 0){
            $maxnum = $row['count'];
        }else{
            $maxnum = min($maxnum, $row['count']);
        }        
    }
?>
award(<?php echo $row['result']?>, Cnt) when Cnt >= <?php echo $row['count']?> -> {<?php echo $row['fame']?>, <?php echo gen_record($row['reward'])?>};
<?php }?>
award(_, _) -> {0, []}.

%% 可领取威望最大次数
max_num() -> <?php echo $maxnum-1?>.

%% 一些值定义
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for($i = sizeof($data) - 1; $i >= 0; $i--){
    $row = $data[$i];
    if($row['conds'] == 'guess_succ_reward' || $row['conds'] == 'guess_fail_reward'){
        echo 'value('.$row['conds']. ') -> ' .gen_record($row['value']).';'."\t%%".$row['desc']."\n"; 
    }
    else{
        echo 'value('.$row['conds']. ') -> ' .$row['value'].';'."\t%%".$row['desc']."\n";
    }
}?>
value(_) -> 0.

%% 匹配段位差
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'time', SORT_ASC);
for($i = 0; $i <= sizeof($data)-1; $i++){
    $row = $data[$i];
    echo "get_match_grade_diff(Time) when Time =< {$row['time']} -> {$row['grade_diff']};"."\n";
}?>
get_match_grade_diff(_) -> false.

%% 季后赛奖励
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for($i = 0; $i <= sizeof($data)-1; $i++){
    $row = $data[$i];
    $reward = gen_record($row['reward']);
    echo "playoffs_reward({$row['round']}, {$row['result']}) -> {$reward};"."\n";
}?>
playoffs_reward(_, _) -> [].

%% 经验奖励
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
exp(Lev) when Lev >= <?php echo $row['lev'];?> -> <?php echo $row['exp'];?>;
<?php }?>
exp(_) -> 0.