%% -----------------------------------------------------------------------------
%% 功能开启等级定义
%% @author pb
%% -----------------------------------------------------------------------------

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $row){
	if((trim($row['macro']))!=""){
		$lev = 0;
		if($row['open_type'] == 1){
			$lev = $row['open_lv'];
		}else{
			$lev = $row['lev'];
		}
		echo "-define({$row['macro']}, {$lev}).\n";
	}	
}
?>
