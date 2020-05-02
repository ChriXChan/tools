%% -----------------------------------------------------------------------------
%% 酒宴表
%% @author pb
%% -----------------------------------------------------------------------------
-module(feast_data).

-include("gain.hrl").

-export([
	table_num/1
	,dig_num/1
	,cost/1
	,map/1
	,pos/1
	,mon/1
	,all_mon/0
	,mon2color/1
	,order_reward/1
	,host_reward/1
	,guest_reward/1
	,index/1
	,name/1
	,name_color/1
	,crontab_cfg/0
	,refresh_time/0
]).

%% 酒桌数量
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
table_num(<?php echo '_Color = '.$data[$i]['color']?>)  -> <?php echo $data[$i]['table_num'];?>;
<?php 
}
?>
table_num(_) -> 0.

%% 酒桌采集数量上限
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
dig_num(<?php echo '_Color = '.$data[$i]['color']?>)  -> <?php echo $data[$i]['dig_num'];?>;
<?php 
}
?>
dig_num(_) -> 0.

%% 预定消耗
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
cost(<?php echo '_Color = '.$data[$i]['color']?>)  -> <?php echo gen_record($data[$i]['cost']);?>;
<?php 
}
?>
cost(_) -> false.

%% 酒桌地图
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
	$str_tmp = str_replace("{", "",$data[$i]['pos']);
    $str_tmp = str_replace("}", "",$str_tmp);
    $arr_attr = explode(",",$str_tmp);
?>
map(<?php echo '_Color = '.$data[$i]['color']?>)  -> {<?php echo trim($arr_attr[0]).", ".trim($arr_attr[1]).", ".trim($arr_attr[2]);?>};
<?php 
}
?>
map(_) -> false.

%% 酒桌坐标
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
pos(<?php echo '_Color = '.$data[$i]['color']?>)  -> [<?php echo $data[$i]['table_pos'];?>];
<?php 
}
?>
pos(_) -> false.

%% 酒桌怪物
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
mon(<?php echo '_Color = '.$data[$i]['color']?>)  -> [<?php echo $data[$i]['mon'];?>];
<?php 
}
?>
mon(_) -> 0.

%% 所有酒桌怪物
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
all_mon() ->[<?php
foreach($data as $v) {
    echo "{$v['mon']}, ";
}
echo "{$last['mon']}].";
?>


%% 怪物对应的酒席品质
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
	$row = $data[$i];
        if((trim($row['mon']))!=""){
            $arr_mon = explode(",",$row['mon']);
            for ($j = 0; $j < count($arr_mon); $j++) {
            	echo "mon2color(".trim($arr_mon[$j]).")-> ".$row['color'].";\n";
            } 
        }
}
?>
mon2color(_) -> false.


%% 主人奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
host_reward(<?php echo '_Color = '.$data[$i]['color']?>)  -> <?php echo gen_record($data[$i]['host_reward']);?>;
<?php 
}
?>
host_reward(_) -> [].

%% 客人奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
guest_reward(<?php echo '_Color = '.$data[$i]['color']?>)  -> <?php echo gen_record($data[$i]['guest_reward']);?>;
<?php 
}
?>
guest_reward(_) -> [].

%% 预定奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
order_reward(<?php echo '_Color = '.$data[$i]['color']?>)  -> <?php echo gen_record($data[$i]['order']);?>;
<?php 
}
?>
order_reward(_) -> [].

%% 酒宴名字
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
name(<?php echo '_Color = '.$data[$i]['color']?>)  -> <<"<?php echo $data[$i]['name'];?>">>;
<?php 
}
?>
name(_) -> <<>>.

%% 酒宴名字颜色
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
name_color(<?php echo '_Color = '.$data[$i]['color']?>)  -> <?php echo $data[$i]['name_color'];?>;
<?php 
}
?>
name_color(_) -> "#7dff4f".

%% 时间索引
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
index(<?php echo '_Index = '.$data[$i]['index']?>)  -> <?php echo $data[$i]['time'];?>;
<?php 
}
?>
index(_) -> false.

%% 时间配置
<?php
$gap = 15;
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
crontab_cfg() ->[
<?php
foreach($data as $v) {
	$str_tmp = str_replace("{", "",$v['time']);
    $str_tmp = str_replace("}", "",$str_tmp);
    $arr_attr = explode(",",$str_tmp);

    $str_tmp2 = str_replace("{", "",$v['time_end']);
    $str_tmp2 = str_replace("}", "",$str_tmp2);
    $arr_attr2 = explode(",",$str_tmp2);

    echo "\t{".$arr_attr[1].", ".$arr_attr[0].", all, all, all, all, all, all, {feast_mgr, start, [".$v['index']."]}},"."\n";
    echo "\t{".$arr_attr2[1].", ".$arr_attr2[0].", all, all, all, all, all, all, {feast_mgr, stop, [".$v['index']."]}},"."\n";
}
$str_tmp = str_replace("{", "",$last['time'] );
$str_tmp = str_replace("}", "",$str_tmp);
$arr_attr = explode(",",$str_tmp);

$str_tmp2 = str_replace("{", "",$last['time_end'] );
$str_tmp2 = str_replace("}", "",$str_tmp2);
$arr_attr2 = explode(",",$str_tmp2);

echo "\t{".$arr_attr[1].", ".$arr_attr[0].", all, all, all, all, all, all, {feast_mgr, start, [".$last['index']."]}},"."\n";
echo "\t{".$arr_attr2[1].", ".$arr_attr2[0].", all, all, all, all, all, all, {feast_mgr, stop, [".$last['index']."]}}"."\n";
echo "].";
?>


%% 预定刷新时间
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
	$arr_attr = explode(",",trim($data[$i]['refresh_time']));
?>
refresh_time()  -> {<?php echo $arr_attr[0];?>,<?php echo $arr_attr[1];?>,00}.
<?php 
}
?>