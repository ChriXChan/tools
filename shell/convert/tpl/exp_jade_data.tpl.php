%% -----------------------------------------------------------------------------
%% 经验玉配置
%% -----------------------------------------------------------------------------
-module(exp_jade_data).
-export([ 
	max_exp/1 
	,mul/1
	,gain_mul/2
	,loss/2
	,condition/2
]).

-include("gain.hrl").
-include("condition.hrl").

%% 存储经验上限
<?php
$data = $xml_data[0];
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
    $id = $row['id'];
    $exp = $row['exp'];
    echo "max_exp({$id}) -> {$exp};\n";
}?>
max_exp(_) -> 0.

%% 杀怪经验倍数
<?php
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
    $id = $row['id'];
    $mul = $row['mul'];
    echo "mul({$id}) -> {$mul};\n";
}?>
mul(_) -> 1.

%% 提取经验倍数
<?php
$data = $xml_data[1];
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
    $id = $row['id'];
    $step = $row['step'];
    $mul = $row['mul'];
    echo "gain_mul({$id}, {$step}) -> {$mul};\n";
}?>
gain_mul(_, _) -> 1.

%% 提取消耗
<?php
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
    $id = $row['id'];
    $step = $row['step'];
    $loss = gen_record($row['loss']);
    echo "loss({$id}, {$step}) -> {$loss};\n";
}?>
loss(_, _) -> [].

%% 提取条件
<?php
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
    $id = $row['id'];
    $step = $row['step'];
    $cond = gen_record($row['cond']);
    echo "condition({$id}, {$step}) -> {$cond};\n";
}?>
condition(_, _) -> false.