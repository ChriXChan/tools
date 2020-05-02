%%----------------------------------------------------
%% 日志配置
%% @author luoxueqing
%%----------------------------------------------------

-module(log_cfg_data).
-export([
    get/2
]).


-include("log.hrl").
-include("common.hrl").
<?php

$data = $xml_data[0];
array_shift($data);
array_shift($data);

foreach($data as $v){
?>
get(<?php echo $v['type'];?>, <?php echo $v['ver'];?>) ->
    #log_cfg{type = <?php echo $v['type'];?>, ver = <?php echo $v['ver'];?>, fields = [<?php echo $v['fields'];?>]};
<?php
}
?>
get(_, _) ->
    false.