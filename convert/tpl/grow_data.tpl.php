%% -----------------------------------------------------------------------------
%% 养成数据
%% @author mirahs
%% -----------------------------------------------------------------------------
-module(grow_data).

-export([
        get_grow/2
        ,get_skill/2
        ,get_zzcz/1
        ,get_talent/1
        ,get_skill_rate/2
        ,get_zzcz_rate/1
        ,open/2

        ,act_wish_add_type/1
        ,act_wish_add_data/3
    ]
).

-include("grow.hrl").
-include("gain.hrl").


%% 养成升阶
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_grow(<?php echo '_Type = '.$data[$i]['type'] . ', _Step = '.$data[$i]['step'] ?>) ->
    #grow_data{type = <?php echo $data[$i]['type'];?>, step = <?php echo $data[$i]['step'];?>, loss = <?php echo gen_record($data[$i]['loss']);?>, attr = [<?php echo attr_to_int($data[$i]['attr']);?>], reward = <?php echo gen_record($data[$i]['reward']);?>, zz_num = <?php echo $data[$i]['zz_num'];?>, cz_num = <?php echo $data[$i]['cz_num'];?>, clean = <?php echo $data[$i]['clean'];?>, wish_max = <?php echo $data[$i]['wish_max'];?>, wish_rand = [<?php echo $data[$i]['wish_rand'];?>], wish_range = <?php echo $data[$i]['wish_range'];?>, name = <<"<?php echo $data[$i]['name'];?>">>, skin_id = <?php echo $data[$i]['skin_id'];?>};
<?php 
}
?>
get_grow(_Type, _Step) -> false.

%% 养成技能
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_skill(<?php echo '_Type = '.$data[$i]['type'].', _Lv = '.$data[$i]['lv'];?>) -> [<?php echo attr_to_int($data[$i]['attr']);?>];
<?php 
}
?>
get_skill(_Type, _Lv) -> [].


%% 养成技能加成比例
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_skill_rate(<?php echo '_Type = '.$data[$i]['type'].', _Lv = '.$data[$i]['lv'];?>) -> [<?php echo attr_to_int($data[$i]['grow_attr']);?>];
<?php
}
?>
get_skill_rate(_Type, _Lv) -> [].


%% 资质成长加成比例
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_zzcz_rate(<?php echo '_Type = '.$data[$i]['type'];?>) -> [<?php echo attr_to_int($data[$i]['grow_attr']);?>];
<?php
}
?>
get_zzcz_rate(_Type) -> [].


%% 资质成长
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_zzcz(<?php echo '_Type = '.$data[$i]['type'];?>) ->
    #grow_zzcz_data{type = <?php echo $data[$i]['type'];?>, zz_id = <?php echo $data[$i]['zz_id'];?>, cz_id = <?php echo $data[$i]['cz_id'];?>, zz_attr = [<?php echo attr_to_int($data[$i]['zz_attr']);?>], cz_attr = [<?php echo attr_to_int($data[$i]['cz_attr']);?>], cz_attr_percent = [<?php echo attr_to_int($data[$i]['cz_attr_percent']);?>]};
<?php
}
?>
get_zzcz(_Type) -> false.


%% 天赋技能
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_talent(<?php echo '_Type = '.$data[$i]['type'];?>) ->
	[<?php echo $data[$i]['talent'];?>];
<?php 
}
?>
get_talent(_Type) -> false.

%% 成长开启
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    ?>
open(<?php echo $row['type']?>, <?php echo $row['val']?>) -> <?php echo $row['open']?>;
<?php
}
?>
open(_, _) -> false.

%% 活动进阶祝福值加成类型
<?php
$data = $xml_data[8];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
?>
act_wish_add_type(_SrvOpenDay = <?php echo $v['day']; ?>) -> [<?php echo $v['type']; ?>];
<?php  } ?>
act_wish_add_type(_SrvOpenDay) -> false.

%% 活动进阶祝福值加成数据
<?php
$data = $xml_data[9];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
?>
act_wish_add_data(<?php echo "_Type = {$v['type']}, _Step = {$v['step']}, Day"; ?>) when Day =< <?php echo $v['day']; ?> -> <?php echo $v['add']; ?>;
<?php  } ?>
act_wish_add_data(_Type, _Step, _Day) -> false.
