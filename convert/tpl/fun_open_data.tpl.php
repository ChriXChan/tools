%% -----------------------------------------------------------------------------
%% 功能开启
%% @author pb
%% -----------------------------------------------------------------------------
-module(fun_open_data).

-export([
        get/1
    ]
).

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $row){
	if((trim($row['open_type']))!="" && (trim($row['open_lv'])!="")){
		// echo "-define({$row['macro']}, {$lev}).\n";
		echo "get(".$row['open_id'].") -> {".$row['open_type'].", ".$row['open_lv']."};"."\n";
	}	
}
?>
get(_) -> false.
