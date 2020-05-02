%% -----------------------------------------------------------------------------
%% 世界BOSS数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(world_boss_data).

-export([
        get/1
        ,all/0
        ,all/1
        ,base_to_id/1
        ,refresh/0
        ,map_to_base/1
        ,base_to_cross_type/1
        ,hp_absorb_skill/1

        ,crontab/0
        ,label/1

        ,force_ts_buy_cost/1
        ,force_ts_vip_times/1
        ,force_ts_lv_num/1
    ]).

-include("world_boss.hrl").
-include("gain.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$ids = array();
$allids = array();
$refresh = array();
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
    $allids[] = $row['id'];
    $ids[$row['cross_type']][] = $row['id'];
    $time = trimall($row['refresh']);
    $refresh[$time][] = $row['id'];
?>
get(<?php echo $row['id']?>) ->
    #wboss_base{
        map_id = <?php echo $row['map_id']?><?php echo "\n"?>
        ,type = <?php echo $row['cross_type']?><?php echo "\n"?>
        ,points = [<?php echo $row['points']?>]<?php echo "\n"?>
        ,refresh = [<?php echo $row['refresh']?>]<?php echo "\n"?>
        ,boss_id = <?php echo $row['boss_id']?><?php echo "\n"?>
        ,boss_born = <?php echo $row['boss_born']?><?php echo "\n"?>
        ,roll_item = <?php echo gen_record($row['roll'])?><?php echo "\n"?>
        ,hurt_item1 = <?php echo gen_record($row['hurt1'])?><?php echo "\n"?>
        ,hurt_item2 = <?php echo gen_record($row['hurt2'])?><?php echo "\n"?>
        ,hurt_item3 = <?php echo gen_record($row['hurt3'])?><?php echo "\n"?>
        ,hurt_item4 = <?php echo gen_record($row['hurt4'])?><?php echo "\n"?>
        ,hurt_item5 = <?php echo gen_record($row['hurt5'])?><?php echo "\n"?>
        ,last_item = <?php echo gen_record($row['last'])?><?php echo "\n"?>
        ,drop = <?php echo gen_record($row['drop2'])?><?php echo "\n"?>
        ,first_hurt_item = <?php echo gen_record($row['first_hurt'])?><?php echo "\n"?>
        ,loss = <?php echo gen_record($row['loss'])?><?php echo "\n"?>
        ,box_reward = <?php echo gen_record($row['box_reward'])?><?php echo "\n"?>
        ,box_loss = <?php echo gen_record($row['box_loss'])?><?php echo "\n"?>
    };
<?php }?>
get(_) ->
    false.

all() -> [<?php echo implode(",", $allids)?>].

<?php foreach($ids as $k=>$v){
?>
all(<?php echo $k?>) -> [<?php echo implode(",", $v)?>];
<?php }?>
all(_) -> [].

<?php
    $str = "";
    foreach($refresh as $k=>$v){
        $str .= ", {[".$k."], [".implode(",", $v)."]}";
    }
?>
refresh() -> 
    [<?php echo substr($str, 2)?>].

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
base_to_id(<?php echo $row['boss_id']?>) -> <?php echo $row['id']?>;
<?php }?>
base_to_id(_) -> 0.

<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
base_to_cross_type(<?php echo $row['boss_id']?>) -> <?php echo $row['cross_type']?>;
<?php }?>
base_to_cross_type(_) -> false.

<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
map_to_base(<?php echo $row['map_id']?>) -> <?php echo $row['boss_id']?>;
<?php }?>
map_to_base(_) -> 0.


%% 世界BOSS血盾技能
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$ids = array();
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
hp_absorb_skill(<?php echo $row['mon']?>) -> <?php echo $row['skill']?>;
<?php }?>
hp_absorb_skill(_) -> false.


%% 时空之力发放定时
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$crontabs = array();
foreach ($data as $v) {
    $crontab = "{{$v['min']}, {$v['hour']}, all, all, all, all, all, all, {world_boss_api, gain_force_ts, []}}";
    $crontabs[] = $crontab;
}
?>
crontab() -> [<?php echo implode(',', $crontabs); ?>].

%% 标签
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
?>
label(<?php echo $v['label']?>) -> <?php echo $v['value']?>;
<?php }?>
label(_Label) -> false.


%% 时空之力购买消耗
<?php
$data = $xml_data[4];
$idx_last = count($data) - 1;
for ($i = 2; $i < count($data); $i++) {
    $row = $data[ $i ];
    if ($i != $idx_last) { ?>
force_ts_buy_cost(Times) when Times =< <?php echo $row['times'] ?> -> <?php echo $row['loss'] ?>;
<?php } else { ?>
force_ts_buy_cost(_Times) -> <?php echo $row['loss']?>.
<?php } } ?>

%% 时空之力VIP购买次数
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
force_ts_vip_times(_VipLv = <?php echo $row['vip']?>) -> <?php echo $row['times']?>;
<?php }?>
force_ts_vip_times(_VipLv) -> false.

%% 时空之力定时发放数量
<?php
$data = $xml_data[6];
$idx_last = count($data) - 1;
for ($i = 2; $i < count($data); $i++) {
    $row = $data[ $i ];
    if ($i != $idx_last) { ?>
force_ts_lv_num(Times) when Times =< <?php echo $row['lev'] ?> -> <?php echo $row['num'] ?>;
<?php } else { ?>
force_ts_lv_num(_Times) -> <?php echo $row['num'] ?>.
<?php } } ?>
