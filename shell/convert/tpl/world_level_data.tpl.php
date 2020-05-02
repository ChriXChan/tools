%% -----------------------------------------------------------------------------
%% 世界等级表
%% @author pb
%% -----------------------------------------------------------------------------
-module(world_level_data).

-export([
	rate/1
	,label/1
]).

%% 获取加成比例
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$data1 = array_sort($data, 'lev', SORT_DESC);
for ($i = 0; $i < count($data1); $i++) {
?>
rate(Lev) when Lev >= <?php echo $data1[$i]['lev']?> -> <?php echo $data1[$i]['rate'];?>;
<?php 
}
?>
rate(_) -> 0.


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