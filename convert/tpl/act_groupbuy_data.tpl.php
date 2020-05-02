%%----------------------------------------------------
%% 一元夺宝
%% @author sy
%%----------------------------------------------------
-module(act_groupbuy_data).

-include("act_srv.hrl").
-include("gain.hrl").

-export([
	get/1
	, change_point/1
	, change_gain/1
	, get_lib/1
	, all_lib/1
]).


<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get({$v['type']}) -> {$v['value']};\n";
}
echo "get(_) -> false.\n";
?>


<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "change_point({$v['id']}) -> {$v['loss']};\n";
}
echo "change_point(_) -> false.\n";
?>

<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "change_gain({$v['id']}) -> {$gain};\n";
}
echo "change_gain(_) -> false.\n";
?>

<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "get_lib(" . $data[$i]['id'] . ") -> #act_grpbuy_cfg{id = " . $data[$i]['id'] .",rate = ".$data[$i]['rate'].", loss = ". gen_record($data[$i]['loss']).", gain = ". gen_record($data[$i]['gain']). ",sub = ".$data[$i]['sub'].",single = ".$data[$i]['single'].", point = ".$data[$i]['point']. "};\n";
    }
}
?>
get_lib(_) -> false.

<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "all_lib({$v['type']}) -> [{$v['rate']}];\n";
}
echo "all_lib(_) -> false.\n";
?>



