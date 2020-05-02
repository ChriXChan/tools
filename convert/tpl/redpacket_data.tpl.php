%%----------------------------------------------------
%% 红包数据
%% @author linkeng
%%----------------------------------------------------
-module(redpacket_data).

-export([
    get/1
    , type/1
	, cross_type/1
    , lable/1
]).

-include("redpacket.hrl").

%% 基础数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $k => $row) {
    echo "get(".$row['id'].") -> #redpacket_data{act_id = ".$row['id'].", type = ".$row['type'].", count = ".$row['count'].", gain = ".$row['gain'].", average = ".$row['average'].", limit = ".$row['limit'].", valid = ".$row['valid'].", cross_type = ".$row['cross_type']."};\n";
}
?>
get(_) -> false.

<?php
foreach ($data as $k => $row) {
    echo "type(".$row['id'].") -> ".$row['type'].";\n";
}
?>
type(_) -> false.

<?php
foreach ($data as $k => $row) {
    echo "cross_type(".$row['id'].") -> ".$row['cross_type'].";\n";
}
?>
cross_type(_) -> false.

<?php
foreach ($data as $k => $row) {
    echo "lable(".$row['id'].") -> ".$row['gain'].";\n";
}
?>
lable(_) -> false.







