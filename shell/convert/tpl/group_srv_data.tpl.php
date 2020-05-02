%% -----------------------------------------------------------------------------
%% 分组跨服人数
%% -----------------------------------------------------------------------------
-module(group_srv_data).
-export([ 
	get/1 
	,specify_group/1
	,srv_num/1
	,openday2fc/1
	,fc2attr/1
	,label/1
]).

-include("cross.hrl").
-include("attr.hrl").

<?php
$data = $xml_data[0];
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
get(<<"<?php echo $row['platform']?>">>) -> <?php echo $row['num']?>;
<?php }?>
%% 默认300
get(_) -> ?cross_group_role_num.

%% 指定分组跨服
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    $srv_id = $row['srv_id'];
    $platform = $row['platform'];
?>
specify_group(<<"<?php echo $row['platform']?>">>) -> [<?php echo $row['srv_id']?>];
<?php }?>
specify_group(_) -> false.

<?php
$data = $xml_data[2];
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
srv_num(<<"<?php echo $row['platform']?>">>) -> <?php echo $row['num']?>;
<?php }?>
%% 默认3
srv_num(_) -> ?cross_group_srv_num.

%% 开服天数预计战力
<?php
$data = $xml_data[3];
$last = array_pop($data);
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
openday2fc(<?php echo $row['open_day']?>) -> <?php echo $row['fc']?>;
<?php }?>
openday2fc(_) -> <?php echo $last['fc']?>.

%% 战力差异补偿属性
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$last = array_pop($data);
$last_attr_type = attr_to_int($last['attr']);
?>
fc2attr(Fc) -> [<?php
foreach($data as $v) {
	$attr_type = attr_to_int($v['attr']);
    echo "{{$attr_type}, util_math:floor(Fc*"."{$v['arg']}/1000".")}, ";
}
echo "{{$last_attr_type}, util_math:floor(Fc*"."{$last['arg']}/1000".")}].";
?>


%% 基本配置
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['null']."\n";
}
?>
label(_) -> false.