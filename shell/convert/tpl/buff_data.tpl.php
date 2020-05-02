%%----------------------------------------------------
%% buff数据
%% @author lsb
%%----------------------------------------------------
<?php
 
?>
-module(buff_data).
-export([
        get/2
    ]
).
-include("buff.hrl").

<?php 
$table = $xml_data[0];
$array = array();
for($i=2;$i<sizeof($table);$i++){
    $row = $table[$i];
?>
get(<?php echo $row['id'];?>, <?php echo $row['lev'];?>) -> #buff_base{id = <?php echo $row['id']?>, mutex = <?php echo $row['mutex']?>, level = <?php echo $row['lev']?>, name = <<"<?php echo $row['name'];?>">>, type = <?php echo $row['time_type']?>, eff_type = <?php echo $row['eff_type']?>, duration = <?php echo $row['duration']?>, dispel = <?php echo $row['disple']?><?php if($row['script_id'] != '') {?>, script_id = <?php echo $row['script_id']?><?php }?><?php if($row['script_skill'] != '') {?>, script_skill = [<?php echo $row['script_skill'];?>]<?php }?><?php if($row['args'] != '') {?>, args = <?php echo $row['args'];?><?php }?><?php if($row['attr'] != '') {?>, attr = [<?php echo attr_to_int($row['attr']);?>]<?php }?>};
<?php }?>
get(_, _) -> 
    false.

