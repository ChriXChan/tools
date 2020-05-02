%%----------------------------------------------------
%% rpclog
%% @author luoxueqing
%%----------------------------------------------------
-module(rpc_conf_data).
-export([
    get/1
    ,get_desc/1
]).


%%rpc,apply定义
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get(<?php echo strtolower($data[$i]['label']); ?>) -> <?php echo $i;?>;<?php echo "\n";?>
<?php
}
?>
get(_) -> 0.

%%rpc,apply定义描述
<?php
for ($i = 0; $i < count($data); $i++) {
?>
get_desc(<?php echo strtolower($data[$i]['label']); ?>) -> <<"<?php echo $data[$i]['desc'];?>">>;<?php echo "\n";?>
<?php
}
?>
get_desc(_) -> <<>>.