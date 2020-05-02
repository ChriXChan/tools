%% -----------------------------------------------------------------------------
%% 物品数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(item_gift_data).

-export([
        get/1
    ]
).

-include("item_gift.hrl").
-include("condition.hrl").
-include("gain.hrl").

<?php

$data = $xml_data[1];
array_shift($data);
array_shift($data);
$base = array();
for ($i = 0; $i < sizeof($data); $i++) {
    $row = $data[$i];
    if($row['id'] != ""){
        $base[$row['id']][] = $row;
    }
}

function gen_rule($rule){
    $output="";
    if($rule != ""){
        foreach($rule as $k => $v){
            if($v['id'] != ""){
                $output_tmp = "#item_gift_rule{base_id = {$v['base_id']}, bind = {$v['bind']}, num = {$v['num']}, cast = {$v['cast']}, aft_out = {$v['after_out']}, bef_not_out = {$v['before_not_out']}, rand = {$v['rand']}, extra = [{$v['extra']}]}";
                if($k != 0){
                    $output_tmp ="            ,".$output_tmp;
                }else{
                    $output_tmp ="            ".$output_tmp;
                }
                $output_tmp = $output_tmp."\n";
                $output = $output.$output_tmp;
            }
        }
    }
    return $output;
}

$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < sizeof($data); $i++) {
    $row = $data[$i];
    if($row['id'] != ""){
        $cond = gen_record($row['cond']);
        $loss = gen_record($row['loss']);
?>
get(<?php echo $data[$i]['id']; ?>) -> 
    #item_gift_data{
        id = <?php echo $data[$i]['id']."\n";?>
        ,name = <<"<?php echo $data[$i]['name'];?>">><?php echo "\n";?>
        ,type = <?php echo $data[$i]['type']."\n";?>
        ,conds = <?php echo $cond."\n";?>
        ,loss = <?php echo $loss."\n";?>
        ,num = <?php echo $data[$i]['num']."\n";?>
        ,rule = [
<?php echo gen_rule($base[$row['id']]);?>
        ]
    };
<?php 
}}
?>
get(_) -> false.
