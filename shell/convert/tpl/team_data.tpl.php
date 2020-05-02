%% -----------------------------------------------------------------------------
%% 组队数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(team_data).

-export([
        buff/2
        ,label/1
    ]).

<?php
$data = $xml_data[0];
for($i = 2; $i < sizeof($data); $i++) {
    $row = $data[$i];
?>
buff(_Num = <?php echo $row['num'];?>, _MapType = <?php echo $row['scene']; ?>) -> <?php echo $row['buff'];?>;
<?php } ?>
buff(_Num, _MapType) -> false.


%% 基本配置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n"; 
}
?>
label(_) -> false.
