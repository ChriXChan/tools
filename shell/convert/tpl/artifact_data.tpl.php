%%----------------------------------------------------
%% 神器
%% @author pb
%%----------------------------------------------------
-module(artifact_data).

-export([
	ratio/2
	,type/1
	,all_type/1
	,drop/1
	,name/1
	,notice/1
	,label/1
	,act_grant/1
	,base_attr/1
]).

%% 加成比例
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$id = $v['id'];
	$job = $v['job'];
	$ratio = $v['ratio'];
    echo "ratio({$id}, {$job}) -> {$ratio};\n";
}
echo "ratio(_, _) -> false.\n";
?>

%% 类型
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$id = $v['id'];
	$type = $v['type'];
    echo "type({$id}) -> {$type};\n";
}
echo "type(_) -> false.\n";
?>

%% 同类型神器
<?php
$type_array = array();
foreach ($data as $v) {
	$id = $v['id'];
	$type = $v['type'];
	$type_array[$type][] = $id;
}
foreach ($type_array as $key => $ids) {
	$last = array_pop($ids);
	echo "all_type({$key}) -> [";
	foreach ($ids as $id) {
		echo "{$id}, ";
	}
	echo "{$last}];\n";
}
echo "all_type(_) -> [].\n";
?>

%% 掉落相对概率
<?php
foreach ($data as $v) {
	$id = $v['id'];
	$drop = $v['drop'];
    echo "drop({$id}) -> {$drop};\n";
}
echo "drop(_) -> 0.\n";
?>

%% 神器名字
<?php
foreach ($data as $v) {
	$id = $v['id'];
	$name = $v['name'];
    echo "name({$id}) -> <<\"{$name}\">>;\n";
}
echo "name(_) -> <<>>.\n";
?>

%% 传闻
<?php
foreach ($data as $v) {
	$id = $v['id'];
	$notice_id = $v['notice_id'];
    echo "notice({$id}) -> {$notice_id};\n";
}
echo "notice(_) -> false.\n";
?>

%% 基础属性
<?php
foreach ($data as $v) {
	$id = $v['id'];
	$attr = attr_to_int($v['attr']);
    echo "base_attr({$id}) -> [{$attr}];\n";
}
echo "base_attr(_) -> [].\n";
?>

%% 基本配置
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
}
echo "label(_) -> false.\n";
?>

%% 活动产出神器
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$act = $v['act'];
	$reward = $v['reward'];
	echo "act_grant({$act}) -> [{$reward}];\n";
}
echo "act_grant(_) -> [].\n";
?>