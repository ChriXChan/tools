%% -----------------------------------------------------------------------------
%% 活动配置表
%% @author tanwer
%% -----------------------------------------------------------------------------
-module(activity_service_data).

-include("gain.hrl").
-include("act_srv.hrl").

% -compile(export_all).
-export([
	get_cfg_pos/2
	,get_lib_pos/2
	
	,get_cfg/1	
	,get_lib/1

	,all_cfg/0
	,get_act_libs/1
	,get_type_acts/1
]).


%% 取活动指定字段
get_cfg_pos(Id, Pos) ->
	case get_cfg(Id) of
		#act_srv_cfg{} = Cfg ->
			erlang:element(Pos, Cfg);
		_ -> false
	end.

%% 取活动库指定字段
get_lib_pos(Id, Pos) ->
	case get_lib(Id) of
		#act_srv_lib{} = Lib ->
			erlang:element(Pos, Lib);
		_ -> false
	end.


%% 活动配置表
<?php
$data = $xml_data[0];
$type_idxs = array();
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
	$ids[] = $row['id'];
	$type_idxs[ $row['type'] ][] = $row['id'];
?>
get_cfg(<?php echo $row['id']?>) -> #act_srv_cfg{id = <?php echo $row['id'] ?>
,type = <?php echo $row['type'] ?>
,name = <<"<?php echo $row['name'] . '">>' ?>
,switch = <?php echo $row['switch'] ?>
,date = <?php echo $row['date'] ?>
,open_day = <?php echo $row['open_day'] ?>
,limit_date = <?php echo $row['limit_date'] ?>
,is_roll = <?php echo $row['is_roll'] ?>
,is_mail = <?php echo $row['is_mail'] ?>
,is_close = <?php echo $row['is_close'] ?>
,lv = <?php echo $row['lv'] ?>
,push_lv = <?php echo $row['push_lv'] ?>
,res_id = <?php echo $row['res_id'] != "" ? $row['res_id']:0 ?>
,res_id2 = <?php echo $row['res_id2'] != "" ? $row['res_id2']:0 ?>};
<?php } ?>
get_cfg(_) -> {}.

%% 活动配置库
<?php
$act_libs = array();
for ($i = 1; $i < count($xml_data); $i++){
	$libs = $xml_data[$i];
	for ($j = 2; $j < count($libs); $j++) {
		$row = $libs[$j];
		$act_libs[ $row['base'] ][] = $row['id'];
?>
get_lib(<?php echo $row['id']?>) -> #act_srv_lib{id = <?php echo $row['id']?>
,base = <?php echo $row['base']?>
,name = <?php echo '<<"' . $row['name'] . '">>'?>
,day = <?php echo $row['day']?>
,type = <?php echo $row['type']?>
,value = <?php echo $row['value']?>
,loss = <?php echo gen_record($row['loss'])?>
,gain = <?php echo gen_record($row['gain'])?>};
<?php } };?>
get_lib(_) -> {}.


%% 所有活动ID
all_cfg() -> [<?php echo implode(",", array_unique($ids))?>].

%% 活动类型所有活动id
<?php
foreach ($type_idxs as $type => $idxs) {
?>
get_type_acts(_Type = <?php echo $type; ?>) -> [<?php echo implode(',', $idxs); ?>];
<?php } ?>
get_type_acts(_Type) -> [].

%% 活动配置库明细
<?php
foreach ($act_libs as $act_id => $libs) {
?>
get_act_libs(_ActId = <?php echo $act_id; ?>) -> [<?php echo implode(',', $libs); ?>];
<?php } ?>
get_act_libs(_ActId) -> [].
