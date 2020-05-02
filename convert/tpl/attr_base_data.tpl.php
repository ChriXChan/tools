%%----------------------------------------------------
%% 角色基础属性
%% @author lsb
%%----------------------------------------------------
-module(attr_base_data).
-export([
        get/1
    ]
).

%%角色基础属性
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
	if((trim($data[$i]['lev']))!=""){
		echo "get(_Lev = ".(trim($data[$i]['lev'])).") -> [".attr_to_int($data[$i]['attr'])."];"."\n";
	}
}
?>
get(_) -> [].

