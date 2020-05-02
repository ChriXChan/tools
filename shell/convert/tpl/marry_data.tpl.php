%% -----------------------------------------------------------------------------
%% 结婚表
%% @author pb
%% -----------------------------------------------------------------------------
-module(marry_data).

-include("marry.hrl").
-include("gain.hrl").

-export([
	marry_cost/1
	,marry_gain/2
	,marry_title/1
	,marry_fashion/1

	,child_skin/1
	,ring_child_add/2
	,ring_child_grow/3

	,label/1
]).


%% 结婚消耗
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
marry_cost(<?php echo '_Color = ' . $row['color']; ?>)  -> <?php echo gen_record($row['cost']); ?>;
<?php } ?>
marry_cost(__Color) -> false.

%% 结婚奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
marry_gain(_Color = <?php echo $row['color']?>, _Sex = 1)  -> <?php echo gen_record($row['reward_male']);?>;
marry_gain(_Color = <?php echo $row['color']?>, _Sex = 0)  -> <?php echo gen_record($row['reward_female']);?>;
<?php } ?>
marry_gain(_Color, _Sex) -> [].

%% 结婚称号
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
marry_title(_Color = <?php echo $row['color']?>)  -> <?php echo $row['title']; ?>;
<?php } ?>
marry_title(_Color) -> false.

%% 结婚时装
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
marry_fashion(_Color = <?php echo $row['color']?>)  -> <?php echo $row['fashion']; ?>;
<?php } ?>
marry_fashion(_Color) -> false.


%% 标签
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
	if ($row['label'] == 'divorce_force' || $row['label'] == 'active_child_item') {
        echo 'label('.$row['label']. ') -> ' .gen_record($row['value']).';'."\t%%".$row['desc']."\n"; 
    } elseif ($row['label'] == 'candy_born' || $row['label'] == 'parade_path' || $row['label'] == 'mon_list') {
    	echo 'label('.$row['label']. ') -> [' .$row['value'].'];'."\t%%".$row['desc']."\n"; 
    } else {
        echo 'label('.$row['label']. ') -> ' .$row['value'].';'."\t%%".$row['desc']."\n";
    }
}
?>
label(_Label) -> false.


%% 孩子皮肤
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
	if ($row['type'] == '2') {
?>
child_skin(_Step = <?php echo $row['step']?>)  -> <?php echo $row['res_id']; ?>;
<?php } } ?>
child_skin(_Step) -> false.

%% 夫妻戒指孩子属性加成
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
ring_child_add(_Type = <?php echo $row['type']?>, _Step = <?php echo $row['attr_act_need_we_step']?>) -> <?php echo $row['attr_ratio']; ?>;
<?php } ?>
ring_child_add(_Type, _Step) -> false.

%%戒指孩子进阶
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
?>
ring_child_grow(_Type = <?php echo $row['type']?>, _Step = <?php echo $row['step']?>, _Star = <?php echo $row['star']?>) ->
	#marry_data_rc_grow{
		step = <?php echo $row['step']; ?>,
		star = <?php echo $row['star']; ?>,
		is_update = <?php echo $row['is_update']; ?>,
		bless_max = <?php echo $row['max_bless']; ?>,
		bless_succ = [<?php echo $row['succ']; ?>],
		bless_range = <?php echo $row['bless_range']; ?>,
		loss = <?php echo gen_record($row['loss']); ?>,
		attr = [<?php echo attr_to_int($row['attr']); ?>]<?php echo "\n"; ?>
	};
<?php } ?>
ring_child_grow(_Type, _Step, _Star) -> false.
