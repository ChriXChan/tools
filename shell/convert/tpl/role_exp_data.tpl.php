%%----------------------------------------------------
%% 角色经验数据
%% @author abu
%%----------------------------------------------------
-module(role_exp_data).

-include("common.hrl").

-export([
        get/1
    ]
).

<?php
$table = $xml_data[0];
for($i=2;$i<sizeof($table);$i++){
	if ($table[$i]["lev"] != ''){
?>
get(<?php echo $table[$i]['lev'];?>) -> <?php echo $table[$i]['exp'] ?>;

<?php }} ?>
get(_) ->
    ?UINT32_MAX.

