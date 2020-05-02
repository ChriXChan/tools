%% -----------------------------------------------------------------------------
%% 强化数据
%% @author luoxueqing
% -----------------------------------------------------------------------------
-module(eqm_enhance_data).

-export([
        loss/1
        ,prob/1
        ,luck/1
        ,lev_all_attr/1
        ,lev_attr/2
        ,item2lev/1
    ]).

-include("gain.hrl").

%% 强化数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    $loss = gen_record($row['loss']);
?>
loss(<?php echo $row['lev'];?>) -> <?php echo $loss;?>;
<?php }?>
loss(_) -> false.


%% 概率
<?php

foreach($data as $v) {
    echo "prob({$v['lev']}) -> {$v['prob']};"."\n";
}
?>
prob(_) -> 0.

%% 保底
<?php
foreach($data as $v) {
    echo "luck({$v['lev']}) -> {$v['luck']};"."\n";
}
?>
luck(_) -> 0.

%% 全等级属性
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach($data as $v) {
    $lev = $v['lev'];
    $attr = attr_to_int($v['attr']);
    echo "lev_all_attr($lev) -> [$attr];"."\n";
}
?>
lev_all_attr(_) -> [].

%% 强化等级属性
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
        echo "lev_attr(_Pos = ".(trim($data[$i]['pos'])).", _Lev = ".(trim($data[$i]['lev'])).") -> [".attr_to_int($data[$i]['attr'])."];"."\n";
}
?>
lev_attr(_, _) -> [].

%% 强化上限限制
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    echo "item2lev(".trim($data[$i]['item_id']).") -> ".$data[$i]['lev'].";\n";
}
?>
item2lev(_) -> 0.