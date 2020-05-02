%% -----------------------------------------------------------------------------
%% 卡号映射
%% @author pb
%% -----------------------------------------------------------------------------
-module(card_mapping_data).

-export([
        get/1
    ]
).

%%礼包卡配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $v){
	echo "get(\"".$v['card_new']."\") -> \"".$v['card_origin']."\";\n";
} 
?>
get(_) -> false.