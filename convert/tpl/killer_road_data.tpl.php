%% -----------------------------------------------------------------------------
%% 杀神之路表
%% @author pb
%% -----------------------------------------------------------------------------
-module(killer_road_data).

-include("gain.hrl").

-export([
	task_score/1
	,rate/0
	,label/1
	,pos2score/1
	,score_reward/1
	,scores/0
	,kill_title/1
    ,kill_titles/0
    ,title_cast/1
    ,mul_kill_num/0
    ,skill_energy/1
    ,crash_mon/1
    ,crash_reward/2
    ,hide_mon/1
    ,disaster_timer/0    
]).

%% 任务积分奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
	$row = $data[$i];
	echo "task_score({$row['id']}) -> {$row['score']};"."\n";  
}
?>
task_score(_) -> 0.

%% 任务概率
<?php 
$last = array_pop($data);
?>
rate() -> [<?php
foreach($data as $v) {
	echo "{"."{$v['id']}, {$v['rate']}"."}, ";
}
echo "{"."{$last['id']}, {$last['rate']}"."}";
?>
].

%% 基本配置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
	if($data[$i]['label'] == 'view_reward' || $data[$i]['label'] == 'disaster_reward' || $data[$i]['label'] == 'kill_disaster_reward'){
        echo 'label('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n"; 
    }
    else{
        echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
label(_) -> false.

%% 坐标点加积分
<?php
define('GRIDWIDTH', 40);
define('GRIDHEIGHT', 40);
define('PREG_MATCH',    '/{.*?}/');

class point{
    var $x;
    var $y;
    function __construct($x, $y){
        $this->x = $x;
        $this->y = $y;
    }

    function pixel_to_grid(){
        $this->x = floor($this->x/GRIDWIDTH);
        $this->y = floor($this->y/GRIDHEIGHT);
    }
}

function left_up_point($p1, $p2, $p3, $p4){
    $min_x = min(min($p1->x, $p2->x), min($p3->x, $p4->x));
    $min_y = min(min($p1->y, $p2->y), min($p3->y, $p4->y));
    return new point($min_x, $min_y);
}

function right_down_point($p1, $p2, $p3, $p4){
    $max_x = max(max($p1->x, $p2->x), max($p3->x, $p4->x));
    $max_y = max(max($p1->y, $p2->y), max($p3->y, $p4->y));
    return new point($max_x, $max_y);
}

// 计算叉乘 |P0P1| × |P0P2| 
function multiply($p1, $p2, $p0){
    return (($p1->x - $p0->x) * ($p2->y - $p0->y) - ($p2->x - $p0->x) * ($p1->y - $p0->y));
}

// 判断是否在四边形内部
// $p1, $p2, $p3, $p4 按顺时针排列
function inrect($p1, $p2, $p3, $p4, $p0){
    if (multiply($p0, $p1, $p2) * Multiply($p0, $p4, $p3) <= 0 && Multiply($p0, $p4, $p1) * Multiply($p0, $p3, $p2) <= 0){
        return true;
    }else{
        return false;
    }
}

// {x, y} 转成 class point 对象
function to_point($val){
    $str_tmp = str_replace("{", "",$val);
    $str_tmp = str_replace("}", "",$str_tmp);
    $arr = explode(",",$str_tmp);
    $x = trim($arr[0]);
    $y = trim($arr[1]);  
    $p = new point($x, $y);
    $p->pixel_to_grid();  
    return $p;
}

$data = $xml_data[2];
array_shift($data);
array_shift($data);
$pre_points = array();
for ($i = 0; $i < count($data); $i++) {
	$row = $data[$i];
	$score = $row['score'];
    if(trim($row['pos'])!=""){
        if (preg_match_all(PREG_MATCH, $row['pos'], $arr_pos) ) {
            $p1 = to_point($arr_pos[0][0]);
            $p2 = to_point($arr_pos[0][1]);
            $p3 = to_point($arr_pos[0][2]);
            $p4 = to_point($arr_pos[0][3]);
            $lu_point = left_up_point($p1, $p2, $p3, $p4);
            $rd_point = right_down_point($p1, $p2, $p3, $p4);
                for ($x = $lu_point->x; $x <= $rd_point->x; $x++) {  
                    for ($y = $lu_point->y; $y <= $rd_point->y; $y++) {
                        $p0 = new point($x, $y);
                        if(!in_array($p0, $pre_points)){
                            if(inrect($p1, $p2, $p3, $p4, $p0)){
                                array_push($pre_points, $p0);
                                echo "pos2score({{$x}, {$y}}) -> $score;\n";    
                            }        
                        }
                    }
                }
        }
    }else{
        echo "pos2score(_) -> $score.\n\n"; 
    }
}
?>

%% 积分奖励
<?php
$data = $xml_data[3];
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

%% 连杀称号
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'kill_num', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
kill_title(Num) when Num >= <?php echo $row['kill_num'];?> -> <?php echo $row['title'];?>;
<?php }?>
kill_title(_) -> false.

%% 称号是否广播
<?php
$data = array_sort($data, 'kill_num', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
title_cast(<?php echo $row['title'];?>) -> <?php echo $row['cast'];?>;
<?php }?>
title_cast(_) -> 0.

%% 所有连杀称号
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
mul_kill_num() ->[<?php
foreach($data as $v) {
    echo "{$v['kill_num']}, ";
}
echo "{$last['kill_num']}].";
?>

%% 所有连杀称号
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
kill_titles() ->[<?php
foreach($data as $v) {
    echo "{$v['title']}, ";
}
echo "{$last['title']}].";
?>


%% 真气技能配置
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
skill_energy(<?php echo $row['skill_id'];?>) -> <?php echo $row['energy'];?>;
<?php }?>
skill_energy(_) -> false.

%% 碰撞怪配置
%% hide_mon(MapBaseId) -> [{MonBaseId, MaxNum, PosList},...]
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
$array_map = array();
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    $map = $row['map'];
    if (trim($map) != "" && trim($row['id']) != "") {
    	$array_map[$map][] = $row; 
    }
}

foreach ($array_map as $key => $value) {
	$last = array_pop($value);
	echo "crash_mon({$key}) -> [";
	foreach ($value as $value2) {
		echo "{{$value2['id']}, {$value2['num']}, [{$value2['pos']}]}, ";		
	}
	echo "{{$last['id']}, {$last['num']}, [{$last['pos']}]}];\n";	
}
echo "crash_mon(_) -> [].\n\n";


for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    $id = $row['id'];
    $map = $row['map'];
    if (trim($map) != "" && trim($id) != "" && trim($row['reward']) != "") {
    	echo "crash_reward({$id}, {$map}) -> {$row['reward']};\n";
    }
}
echo "crash_reward(_,_) -> [].\n";
?>

%% 隐藏怪配置
%% hide_mon(MapBaseId) -> [{MonBaseId, MaxNum, PosList},...]
<?php
$data = $xml_data[7];
array_shift($data);
array_shift($data);
$array_map = array();
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    $map = $row['map'];
    if (trim($map) != "" && trim($row['id']) != "") {
    	$array_map[$map][] = $row; 
    }
}

foreach ($array_map as $key => $value) {
	$last = array_pop($value);
	echo "hide_mon({$key}) -> [";
	foreach ($value as $value2) {
		echo "{{$value2['id']}, {$value2['num']}, [{$value2['pos']}]}, ";		
	}
	echo "{{$last['id']}, {$last['num']}, [{$last['pos']}]}];\n";	
}
echo "hide_mon(_) -> [].";
?>


%% 渡劫时间配置
<?php 
$data = $xml_data[8];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
disaster_timer() -> [<?php
foreach($data as $v) {
    echo "{"."{$v['time']}, {{$v['msg']}}"."}, ";
}
echo "{"."{$last['time']}, {{$last['msg']}}"."}";
?>
].