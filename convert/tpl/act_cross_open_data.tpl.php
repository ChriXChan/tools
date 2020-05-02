%% -----------------------------------------------------------------------------
%% 分组跨服活动 
%% 根据开服天数开启跨服
%% -----------------------------------------------------------------------------
-module(act_cross_open_data).
-export([ get/1 ]).

-include("act.hrl").

<?php
$data = $xml_data[0];
for($i=2;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
get(<?php echo $row['type']?>) -> <?php echo $row['day']?>;
<?php }?>
get(_) -> 0.
