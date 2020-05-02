%% -----------------------------------------------------------------------------
%% VIP数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(vip_data).

-export([
        lev/1
        ,lev_item/1
        ,week_item/1
        ,vip_privilege/2
        ,buff/1
        ,noble_level/1
        ,label/1
        ,daily_reward/1
		,lev_title/1
    ]).

-include("gain.hrl").
-include("vip.hrl").

%% VIP等级
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i = sizeof($data) - 1; $i >= 0; $i--){
    $row = $data[$i];
    if($row['lev'] != '') {
?>
lev(Charge) when Charge >= <?php echo $row['gold'];?> -> <?php echo $row['lev'];?>;
<?php }} ?>
lev(_) -> 0.

%% 等级礼包
<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
    if($row['lev'] != '') {
?>
lev_item(<?php echo $row['lev'];?>) -> <?php echo '[' . $row['lev_item'] . ']';?>;
<?php }} ?>
lev_item(_) -> false.

%% 等级称号奖励
<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
    if($row['lev'] != '' && $row['lev_title'] != '') {
?>
lev_title(<?php echo $row['lev'];?>) -> <?php echo $row['lev_title'] ;?>;
<?php }} ?>
lev_title(_) -> 0.

%% 周礼包
<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
    if($row['lev'] != '') {
?>
week_item(<?php echo $row['lev'];?>) -> <?php echo ($row['week_item']);?>;
<?php }} ?>
week_item(_) -> false.

%% buff
<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
    if($row['lev'] != '') {
?>
buff(<?php echo $row['lev'];?>) -> <?php echo $row['buff_id'];?>;
<?php }} ?>
buff(_) -> 0.

%% VIP特权
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
    if($row['type'] != '') {
?>
vip_privilege(1, <?php echo $row['type'];?>) -> <?php echo $row['V1'];?>;
vip_privilege(2, <?php echo $row['type'];?>) -> <?php echo $row['V2'];?>;
vip_privilege(3, <?php echo $row['type'];?>) -> <?php echo $row['V3'];?>;
vip_privilege(4, <?php echo $row['type'];?>) -> <?php echo $row['V4'];?>;
vip_privilege(5, <?php echo $row['type'];?>) -> <?php echo $row['V5'];?>;
vip_privilege(6, <?php echo $row['type'];?>) -> <?php echo $row['V6'];?>;
vip_privilege(7, <?php echo $row['type'];?>) -> <?php echo $row['V7'];?>;
vip_privilege(8, <?php echo $row['type'];?>) -> <?php echo $row['V8'];?>;
vip_privilege(9, <?php echo $row['type'];?>) -> <?php echo $row['V9'];?>;
vip_privilege(10, <?php echo $row['type'];?>) -> <?php echo $row['V10'];?>;
vip_privilege(11, <?php echo $row['type'];?>) -> <?php echo $row['V11'];?>;
vip_privilege(12, <?php echo $row['type'];?>) -> <?php echo $row['V12'];?>;
vip_privilege(13, <?php echo $row['type'];?>) -> <?php echo $row['V13'];?>;
vip_privilege(14, <?php echo $row['type'];?>) -> <?php echo $row['V14'];?>;
vip_privilege(15, <?php echo $row['type'];?>) -> <?php echo $row['V15'];?>;
<?php }} ?>
vip_privilege(_, _) -> 0.



%%贵族等级
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['type']))!=""){
        echo "noble_level(" . $data[$i]['type'] .") -> #privilege_data{type = " . $data[$i]['type'] .
            ", cost_gold = ".gen_record($data[$i]['cost_gold']) .
            ", cost_gold_valid = ".$data[$i]['cost_gold_valid'] .
            ", cost_item = ".gen_record($data[$i]['cost_item']).
            ", valid = ".$data[$i]['valid'] .
            ", gain = ".gen_record($data[$i]['gain']).
            ", buff_id1 = ".$data[$i]['buff_id1'] .
            ", buff_id2 = ".$data[$i]['buff_id2'] .
            "};". "\n";
    }
}
?>
noble_level(_) -> false.


%% 特权配置
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'exp_add_rate' or $data[$i]['label'] == 'task_add_rate' or $data[$i]['label'] == 'add_bind_yuan' or $data[$i]['label'] == 'bag_cell' or $data[$i]['label'] == 'tianzhun'){
        echo 'label('.$data[$i]['label']. ') -> [' .$data[$i]['value'].'];'."\t%%".$data[$i]['desc']."\n";
    }else
        {
            echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
        }

}
?>
label(_) -> false.

%% VIP特权
<?php
$data = $xml_data[6];
for($i = 2; $i < sizeof($data); $i++) {
    $row = $data[$i];
?>
daily_reward(_PrivType = <?php echo $row['id'];?>) -> <?php echo gen_record($row['reward']); ?>;
<?php } ?>
daily_reward(_PrivType) -> fale.
