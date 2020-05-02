%% -----------------------------------------------------------------------------
%% 3v3战场表
%% @author pb
%% -----------------------------------------------------------------------------
-module(pk_3v3_data).

-include("gain.hrl").

-export([
	get_match_grade_diff/1
    ,label/1
    ,score/2
    ,award/2
    ,score_reward/1
    ,scores/0
    ,exp/1
    ,all_flag/0
    ,flag_pos/1
    ,flag_title/1
]).

%% 匹配段位差
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'time', SORT_ASC);
for($i = 0; $i <= sizeof($data)-1; $i++){
    $row = $data[$i];
    echo "get_match_grade_diff(Time) when Time =< {$row['time']} -> {$row['grade_diff']};"."\n";
}?>
get_match_grade_diff(_) -> false.


%% 基本配置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$pos_list = "";
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'view_reward'){
        echo 'label('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n"; 
    } elseif ($data[$i]['label'] == 'pos1' || $data[$i]['label'] == 'pos2' || $data[$i]['label'] == 'double_area') {
        echo 'label('.$data[$i]['label']. ') -> [' .$data[$i]['value'].'];'."\t%%".$data[$i]['desc']."\n"; 
    }
    else{
        echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
label(_) -> false.

%% 基准积分,0-失败，1-成功，2平手
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
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
score(_, _) -> 0.

%% 挑战奖励
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$maxnum = 0;
for($i = sizeof($data) - 1; $i >= 0; $i--){
    $row = $data[$i];
?>
award(<?php echo $row['result']?>, Cnt) when Cnt >= <?php echo $row['count']?> -> {<?php echo $row['fame']?>, <?php echo gen_record($row['reward'])?>};
<?php }?>
award(_, _) -> {0, []}.

%% 积分奖励
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
score_reward(<?php echo $row['score'];?>) -> <?php echo gen_record($row['reward']);?>;
<?php }?>
score_reward(_) -> false.

<?php
$last = array_pop($data);
?>
%% 积分奖励段
scores() ->[<?php
foreach($data as $v) {
    echo "{$v['score']}, ";
}
echo "{$last['score']}].";
?>


%% 经验奖励
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
exp(Lev) when Lev >= <?php echo $row['lev'];?> -> <?php echo $row['exp'];?>;
<?php }?>
exp(_) -> 0.

%% 积分奖励
<?php
$data = $xml_data[7];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
flag_pos(<?php echo $row['id'];?>) -> <?php echo $row['pos'];?>;
<?php }?>
flag_pos(_) -> false.

<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
flag_title(<?php echo $row['id'];?>) -> <?php echo $row['title'];?>;
<?php }?>
flag_title(_) -> false.

<?php
$last = array_pop($data);
?>
%% 积分奖励段
all_flag() ->[<?php
foreach($data as $v) {
    echo "{$v['id']}, ";
}
echo "{$last['id']}].";
?>