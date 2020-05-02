%% -----------------------------------------------------------------------------
%% 法宝数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(magic_data).

-export([
        get/1
        ,get_level/2
        ,label/1

        ,get_material/1

        ,fuwen_data/2
        ,fuwen_update_data/2
        ,fuwen_extra_data/1
        ,fuwen_suit_data/2
        ,fuwen_item_exp_data/1

        ,charge_day_data/1
    ]).

-include("magic.hrl").
-include("gain.hrl").


%% 法宝数据
<?php
$data = $xml_data[0];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
get(<?php echo $row['id']?>) ->
    #magic_base{
        id = <?php echo $row['id']?><?php echo "\n"?>
        ,open_type = <?php echo $row['open_type']?><?php echo "\n"?>
        ,open_value = <?php echo $row['open_value']?><?php echo "\n"?>
        ,upgrade_type = <?php echo $row['upgrade_type']?><?php echo "\n"?>
        ,skin_id = <?php echo $row['skin_id']?><?php echo "\n"?>
        ,skill_id = <?php echo $row['skill_id']?><?php echo "\n"?>
        ,skill_get_lv = <?php echo $row['skill_get_lv']?><?php echo "\n"?>
    };
<?php } ?>
get(_) ->
    false.

%% 法宝升级数据
<?php
$data = $xml_data[1];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
get_level(<?php echo $row['id']?>, <?php echo $row['lv']?>) ->
    #magic_level_base{
        id = <?php echo $row['id']?><?php echo "\n"?>
        ,lv = <?php echo $row['lv']?><?php echo "\n"?>
        ,loss = <?php echo gen_record($row['loss']);?><?php echo "\n";?>
        ,exp_add = <?php echo $row['exp_add']?><?php echo "\n"?>
        ,exp_max = <?php echo $row['exp_max']?><?php echo "\n"?>
        ,exp_rate = <?php echo $row['exp_rate']?><?php echo "\n"?>
        ,attr = [<?php echo attr_to_int($row['attr']);?>]<?php echo "\n"?>
        ,role_lv = <?php echo $row['role_lv']?><?php echo "\n"?>
        ,ext_cond = [<?php echo $row['ext_cond']?>]<?php echo "\n"?>
    };
<?php } ?>
get_level(_, _) ->
    false.

%% 法宝标签
<?php
$data = $xml_data[2];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
label(<?php echo $row['label']?>) -> <?php echo $row['value']?><?php echo ";\n"?>
<?php } ?>
label(_Label) -> false.

%% 材料数据
<?php
$data = $xml_data[3];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
get_material(_MaterialId = <?php echo $row['id']?>) -> [<?php echo $row['conds']?>];
<?php } ?>
get_material(_MaterialId) -> false.

%% 符文
<?php
$data = $xml_data[4];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
fuwen_data(_MagicId = <?php echo $row['id']?>, _Hole = <?php echo $row['hole']?>) -> {<?php echo $row['hole_type']?>, <?php echo $row['open_lv']?>};
<?php } ?>
fuwen_data(_MagicId, _Hole) -> false.

%% 符文升级
<?php
$data = $xml_data[5];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
fuwen_update_data(_Id = <?php echo $row['base_id']?>, _Lv = <?php echo $row['lv']?>) -> {<?php echo $row['m_exp']?>, <?php echo $row['lv_exp']?>, [<?php echo attr_to_int($row['b_attr'])?>], <?php echo $row['suit']?>};
<?php } ?>
fuwen_update_data(_Id, _Lv) -> false.

%% 符文附加属性
<?php
$data = $xml_data[6];
$fuwen_extras = array();
for ($i = 2; $i < sizeof($data); $i++) {
    $row = $data[$i];
    $fuwen_extras[ $row['base_id'] ][] = '{[' . attr_to_int($row['attr']). '], ' . $row['open_lv'] . '}';
}
foreach ($fuwen_extras as $fuwen_id => $fuwens) {
?>
fuwen_extra_data(_Id = <?php echo $fuwen_id; ?>) -> [<?php echo implode(',', $fuwens); ?>];
<?php } ?>
fuwen_extra_data(_Id) -> [].

%% 符文套装属性
<?php
$data = $xml_data[7];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
fuwen_suit_data(_SuitId = <?php echo $row['suit_id']?>, _Num = <?php echo $row['num']?>) -> [<?php echo attr_to_int($row['s_attr'])?>];
<?php } ?>
fuwen_suit_data(_SuitId, _Num) -> false.

%% 累充天书奖励
<?php
$data = $xml_data[8];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
charge_day_data(_Day = <?php echo $row['day']?>) -> <?php echo gen_record($row['reward']);?>;
<?php } ?>
charge_day_data(_Day) -> false.

%% 符文经验道具
<?php
$data = $xml_data[9];
for($i = 2; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
fuwen_item_exp_data(_Id = <?php echo $row['id']?>) -> <?php echo $row['exp']; ?>;
<?php } ?>
fuwen_item_exp_data(_Id) -> false.
