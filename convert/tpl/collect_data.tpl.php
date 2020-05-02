%% -----------------------------------------------------------------------------
%% 采集配置 
%% -----------------------------------------------------------------------------
-module(collect_data).
-export([ 
	type/1
	,time/1
	,block/1
]).

<?php
$data = $xml_data[0];
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
type(<?php echo $row['id']?>) -> <?php echo $row['type']?>;
<?php }?>
type(_) -> false.

<?php
$data = $xml_data[0];
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
time(<?php echo $row['id']?>) -> <?php echo $row['time']?>;
<?php }?>
time(_) -> 5000.

<?php
$data = $xml_data[0];
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
block(<?php echo $row['id']?>) -> <?php echo $row['block']?>;
<?php }?>
block(_) -> 0.