%% -----------------------------------------------------------------------------
%% 熔炼数据
%% @author luoxueqing
%% -----------------------------------------------------------------------------
-module(smelt_data).
-include("eqm.hrl").
-include("gain.hrl").

-export([
    exchange/1
    ,lev2addition/1
    ,levup_cond/1
	,get_raffle_reward/2
	,get_smelt_val/1
	,one_table/1
	,get_vip/1
	,get_raffle_reward1/2
	,get_lev/1
	,get_raffle_cost/1
	,ten_table/1
	,get_frist_pos/1
    ]
).


%% 熔炼兑换配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $row){
    echo "exchange({$row['item']}) ->\n";
    echo "\t#smelt_exchange_data{target = {$row['item']}, cost = {$row['cost']}, limit = {$row['limit']}, role_zhuanshu = {$row['role_zhuanshu']}, is_reset = {$row['is_reset']}};\n";
}
?>
exchange(_) -> false.

%% 熔炉等级提升熔炼值配置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach($data as $row){
    echo "lev2addition({$row['lev']}) -> {$row['addition']};\n";
}
?>
lev2addition(_) -> false.


%% 熔炉升级条件
<?php
foreach($data as $row){
    echo "levup_cond({$row['lev']}) -> [{$row['cond']}];\n";
}
?>
levup_cond(_) -> false.

%% 熔炼抽奖一次
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $pos = $row['pos'];
	$role_lev = $row['role_lev'];
    $item = gen_record($row['item']);
    echo "get_raffle_reward({$pos}, {$role_lev}) -> {$item};\n";
}
?>
get_raffle_reward(_, _) -> false.

<?php
$one_table = array();
foreach($data as $v) {
	$one_table[$v['role_lev']][] = array("pos" => $v['pos'], "weight" => $v['weight']);
}
?>
%% 1次相对概率
<?php
foreach($one_table as $lev => $v) {
    echo "one_table($lev) ->[";
	$last = array_pop($v);
	foreach($v as $vv){
		echo "{".$vv["pos"].",". $vv["weight"]."},";
	}
	echo "{".$last["pos"].",". $last["weight"]."}";
	echo "];\n";
}
?>
one_table(_) -> [].

%% 奖品等级区间
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$array = array();
for($i=0;$i < sizeof($data);$i++){
    $row = $data[$i];
	$role_lev = $row['role_lev'];
	if (!array_key_exists($role_lev, $array)) {
		$array[$role_lev] = $role_lev;
	}
}
foreach($array as $v) {
	?>get_lev(Lev) when Lev =< <?php echo $v;?> -> <?php echo $v;?>;
<?php }?>
get_lev(_) -> false.

%% 第一次必出
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$array = array();
for($i=0;$i < sizeof($data);$i++){
    $row = $data[$i];
	$frist = $row['frist'];
	$pos = $row['pos'];
	if (!array_key_exists($frist, $array)) {
		$array[$frist] = $pos;
	}
}
foreach($array as $k => $v) {
	echo "get_frist_pos(".$k.") ->".$v.";\n";
}?>
get_frist_pos(_) -> false.

%% vip等级次数
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach($data as $row){
    echo "get_vip({$row['vip_lev']}) -> {$row['num']};\n";
}
?>
get_vip(_) -> false.

%% 熔炼抽奖十次
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $pos = $row['pos'];
	$role_lev = $row['role_lev'];
    $item = gen_record($row['item']);
    echo "get_raffle_reward1({$pos}, {$role_lev}) -> {$item};\n";
}
?>
get_raffle_reward1(_, _) -> false.

%% 抽十次消耗
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$array = array();
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $ten_cost = $row['ten_cost'];
	$role_lev = $row['role_lev'];
	if (!array_key_exists($role_lev, $array)) {
		$array[$role_lev] = $ten_cost;
	}
}
foreach($array as $k => $v) {
	echo "get_raffle_cost(".$k.") ->".$v.";\n";
}
?>
get_raffle_cost(_) -> false.

<?php
$ten_table = array();
foreach($data as $v) {
	$ten_table[$v['role_lev']][] = array('pos'=>$v['pos'], 'weight'=>$v['weight']);
}
?>
%% 10次相对概率
<?php
foreach($ten_table as $lev => $v) {
	echo "ten_table($lev) -> [";
	$last = array_pop($v);
	foreach($v as $vv) {
		echo "{".$vv['pos'].",". $vv['weight']. "},";
	}
	echo "{".$last['pos'].",". $last['weight']."}";
	echo "];\n";
}
?>
ten_table(_) -> [].

%% 抽奖所需熔炼值
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
	$lev = $row['lev'];
	$cost = $row['cost'];
    echo "get_smelt_val({$lev}) -> {$cost};\n";
}
?>
get_smelt_val(_) -> false.