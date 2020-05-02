%%----------------------------------------------------
%% 角色基础属性
%% @author lijingfeng
%%----------------------------------------------------
-module(fashion_data).
-include("fashion.hrl").
-include("gain.hrl").

-export([
        get_fashion/1
        ,get_wardrobe/1
		,get_fashion_upgrade/3
		,get_wardrobe_upgrade/3
]
).

%%时装表
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "get_fashion(" . $data[$i]['id'] . ") -> 
        #fashion_data{id = " . $data[$i]['id'] .
            ",res_id = ".$data[$i]['res_id'].
            ', name = <<"'.$data[$i]['name'].'">>' .
            ", main_type = ".$data[$i]['main_type'].
            ", sub_type = ".$data[$i]['sub_type'].
            ", activate_type = ".$data[$i]['activate_type'] .
            ", activate_consume = ". gen_record($data[$i]['activate_consume']).
            ", attr = [" . attr_to_int($data[$i]['attr']) . "]".
            ", valid = [".$data[$i]['valid'] ."]".
			 ",hasStep = ".$data[$i]['hasStep'].
            ", is_sys = ".$data[$i]['is_sys']. "
			};\n";
    }
}
?>
get_fashion(_) -> [].

%%衣柜表
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "get_wardrobe(" . $data[$i]['id'] . ") -> 
        #wardrobe_data{id = " . $data[$i]['id'] .
            ", need_item = ". gen_record($data[$i]['need_item']).
            ", attr = [" . attr_to_int($data[$i]['attr']) . "]".
			",hasStep = ".$data[$i]['hasStep'].
            ", ratio = ".$data[$i]['ratio'] ."};". "\n";
    }
}
?>
get_wardrobe(_) -> [].




%%时装升级
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "get_fashion_upgrade(" . $data[$i]['id'] .",".$data[$i]['step'].",".$data[$i]['star'].") -> #fashion_upgrade_data{id = " . $data[$i]['id'] .
            ", step = ".$data[$i]['step'] .
            ", star = ".$data[$i]['star'] .
            ", max_bless = ".$data[$i]['max_bless'] .
            ", hasStep = ".$data[$i]['hasStep'] .
            ", succ = [".$data[$i]['succ'] . ']'.
            ", bless_range = [".$data[$i]['bless_range'] .']'.
            ", loss = ".gen_record($data[$i]['loss']).
			", skin = ".$data[$i]['skin'] .
            ", attr = [" . attr_to_int($data[$i]['attr']) ."]};"."\n";
    }
}
?>
get_fashion_upgrade(_,_,_) -> false.


%%衣柜升级
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "get_wardrobe_upgrade(" . $data[$i]['id'] .",".$data[$i]['step'].",".$data[$i]['star'].") -> #wardrobe_upgrade_data{id = " . $data[$i]['id'] .
            ", step = ".$data[$i]['step'] .
            ", star = ".$data[$i]['star'] .
            ", max_bless = ".$data[$i]['max_bless'] .
            ", hasStep = ".$data[$i]['hasStep'] .
            ", succ = [".$data[$i]['succ'] . ']'.
            ", bless_range = [".$data[$i]['bless_range'] .']'.
            ", loss = ".gen_record($data[$i]['loss']).
			", skin = ".$data[$i]['skin'] .
			", ratio = ".$data[$i]['ratio'] .
            ", attr = [" . attr_to_int($data[$i]['attr']) ."]};"."\n";
    }
}
?>
get_wardrobe_upgrade(_,_,_) -> false.




