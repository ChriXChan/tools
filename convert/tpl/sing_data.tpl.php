%% -----------------------------------------------------------------------------
%% 怪物吟唱
%% @author lsb
%% -----------------------------------------------------------------------------
-module(sing_data).

-export([
        get/1
        ,point_intv/1
        ,eff_id/1
        ,time/1
        ,start_pixel/1
        ,base/1
    ]).

-include("monster.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
get(<?php echo $row['skill_id']?>) ->
    #sing{
        skill_id = <?php echo $row['skill_id']?><?php echo "\n"?>
        ,radius = <?php echo $row['radius']?><?php echo "\n"?>
        ,shape = <?php echo $row['shape']?><?php echo "\n"?>
        ,interval = <?php echo $row['bomb']?><?php echo "\n"?>
    };
<?php }?>
get(_) ->
    false.

<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
point_intv(<?php echo $row['skill_id']?>) -> <?php echo $row['interval']?>;
<?php }?>
point_intv(_) -> 0.

<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
eff_id(<?php echo $row['skill_id']?>) -> <?php echo $row['eff_id']?>;
<?php }?>
eff_id(_) -> 0.

<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
time(<?php echo $row['skill_id']?>) -> <?php echo $row['sing']?>;
<?php }?>
time(_) -> 0.

<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
?>
start_pixel(<?php echo $row['skill_id']?>) -> <?php echo $row['start']?>;
<?php }?>
start_pixel(_) -> 0.

<?php
for($i = 0; $i < sizeof($data); $i++){
    $row = $data[$i];
    if($row['base']){
?>
base(<?php echo $row['skill_id']?>) -> <?php echo $row['base']?>;
<?php }}?>
base(_) -> 0.
