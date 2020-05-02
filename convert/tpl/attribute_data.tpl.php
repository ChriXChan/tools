%%----------------------------------------------------
%% 金丹数据
%% @author linkeng
%%----------------------------------------------------
<?php

?>
-module(attribute_data).
-export([
    get/1,
	get_attribute/2
]).

-include("attribute.hrl").
-include("gain.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>

%% 金丹升级
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if((trim($data[$i]['then_lv']))!=""){
        echo "get(" . $data[$i]['then_lv'] . ") -> 
        #attribute_tupo_data{then_lv = " . $data[$i]['then_lv'] .
			", then_cos = " . gen_record($data[$i]['then_cos']) .
			", attr = [" . attr_to_int($data[$i]['attr']) . "]".
			", wish_max = ".$data[$i]['wish_max'].
			", wish_rand = [" . attr_to_int($data[$i]['wish_rand']) . "]".
			", wish_range = ".$data[$i]['wish_range'] .
            ", max_use = ".$data[$i]['max_use'].
			", special_max_use = ".$data[$i]['special_max_use'].
			", index_arr = " .$data[$i]['index_arr'] . "};\n";
    }
}
?>

get(_) -> false.

%% 使用金丹
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if((trim($data[$i]['pos']))!=""){
        echo "get_attribute(" . $data[$i]['pos'] . "," . $data[$i]['then_type'] . ") -> 
        #attribute_data{pos = " . $data[$i]['pos'] .
            ", then_type = ".$data[$i]['then_type'].
			", loss = " . gen_record($data[$i]['loss']) .
			", prop_id = ".$data[$i]['prop_id'].
			", then_attr = [" . attr_to_int($data[$i]['then_attr']) . "]};"."\n";
    }
}
?>

get_attribute(_,_) -> false.














