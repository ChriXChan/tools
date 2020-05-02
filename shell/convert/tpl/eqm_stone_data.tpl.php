%% -----------------------------------------------------------------------------
%% 宝石数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(eqm_stone_data).

-export([
        suit/1
        ,attr/1
        ,loss/1
        ,stone_open_lev/1
        ,pos2type/2
        ,next_id/1
        ,stone_lev/1
        ,lev2id/2
]).

-include("eqm.hrl").
-include("gain.hrl").

%% 套装
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i=sizeof($data)-1;$i>=0;$i--){
    $row = $data[$i];
    if($row['total'] != "") {
        $attr = attr_to_int($row['attr']);
?>
suit(Lev) when Lev >= <?php echo $row['total'];?> -> [<?php echo $attr;?>];
<?php }}?>
suit(_) -> [].

%% 宝石等级属性
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if($row['base_id'] != "" && ($row['attr'] != "")) {
        $attr = attr_to_int($row['attr']);
?>
attr(<?php echo $row['base_id'];?>) -> [<?php echo $attr;?>];
<?php }}?>
attr(_) -> [].

%% 宝石升级消耗
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if($row['base_id'] != "" && ($row['loss'] != "")) {
        $loss = gen_record($row['loss']);
?>
loss(<?php echo $row['base_id'];?>) -> <?php echo $loss;?>;
<?php }}?>
loss(_) -> false.

%% 宝石升级消耗
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if($row['base_id'] != "" && ($row['next_id'] != "")) {
        echo "next_id(".$row['base_id'].") ->".$row['next_id'].";\n";
}}
?>
next_id(_) -> false.

%% 宝石孔的装备强化等级开启条件
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if(($row['pos'] != "") && ($row['lev'] != "")) {
        echo "stone_open_lev(".$row['pos'].") ->".$row['lev'].";\n";
?>
<?php }}?>
stone_open_lev(_) -> 0.

%% 指定部位的宝石类型
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if(($row['eqm_pos'] != "") && ($row['pos'] != "")) {
        echo "pos2type(".$row['eqm_pos'].", ".$row['pos'].") -> ".$row['item_type'].";\n";
?>
<?php }}?>
pos2type(_, _) -> 0.

%% 宝石等级
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if(($row['base_id'] != "") && ($row['lev'] != "")) {
        echo "stone_lev(".$row['base_id'].") ->".$row['lev'].";\n";
?>
<?php }}?>
stone_lev(_) -> 0.

%% 宝石等级
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if(($row['base_id'] != "") && ($row['lev'] != "") && ($row['type'] != "")) {
        echo "lev2id(".$row['type'].", ".$row['lev'].") ->".$row['base_id'].";\n";
?>
<?php }}?>
lev2id(_,_) -> 0.