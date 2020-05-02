%% -----------------------------------------------------------------------------
%% 商城数据
%% @author luoxueqing
%% -----------------------------------------------------------------------------
-module(shop_data).

-export([
        type/1      %% 获取商品类型数据
        ,get/2      %% 获取某个商品信息
        ,type/0     %% 获取所有商城类型列表
        ,special_buy/2  %% 特殊道具购买
    ]).

-include("shop.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$arr = array();
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if($row['shop_type'] != ''){
        $arr[$row['shop_type']][] = $row;
    }
}
foreach ($arr as $type => $v){
    $v = array_sort($v, 'sort');
?>
type(<?php echo $type;?>) ->
    [
<?php
    for($i=0;$i<sizeof($v);$i++){
        $v1 = $v[$i];
        if($i==0){
            echo "\t#shop_data{key = {{$v1['shop_type']}, {$v1['base_id']}}, num = {$v1['num']}, name = <<\"{$v1['name']}\">>, sort = {$v1['sort']}, base_id = {$v1['base_id']}, shop_type = {$v1['shop_type']}, label = {$v1['label']}, price = {$v1['price']}, bind = {$v1['bind']}, limit = {$v1['limit']}, limit_p = {$v1['limit_p']}, goods_tips = {$v1['goods_tips']}, show_cond = {$v1['show_cond']}, show_param = {$v1['show_param']}}\n";
        } else {
            echo "\t,#shop_data{key = {{$v1['shop_type']}, {$v1['base_id']}}, num = {$v1['num']}, name = <<\"{$v1['name']}\">>, sort = {$v1['sort']},  base_id = {$v1['base_id']}, shop_type = {$v1['shop_type']}, label = {$v1['label']}, price = {$v1['price']}, bind = {$v1['bind']}, limit = {$v1['limit']}, limit_p = {$v1['limit_p']}, goods_tips = {$v1['goods_tips']}, show_cond = {$v1['show_cond']}, show_param = {$v1['show_param']}}\n";
        }
    }
?>
    ];
<?php }?>
type(_) ->
    [].

<?php
foreach ($arr as $v){
    foreach ($v as $v1){
?>
get(<?php echo $v1['shop_type'];?>, <?php echo $v1['base_id'];?>) ->
    #shop_data{
        key = {<?php echo $v1['shop_type'];?>, <?php echo $v1['base_id'];?>}<?php echo "\n";?>
        ,base_id = <?php echo $v1['base_id'];?><?php echo "\n";?>
        ,shop_type = <?php echo $v1['shop_type'];?><?php echo "\n";?>
        ,num = <?php echo $v1['num'];?><?php echo "\n";?>
        ,label = <?php echo $v1['label'];?><?php echo "\n";?>
        ,price = <?php echo $v1['price'];?><?php echo "\n";?>
        ,bind = <?php echo $v1['bind'];?><?php echo "\n";?>
        ,limit = <?php echo $v1['limit'];?><?php echo "\n";?>
        ,limit_p = <?php echo $v1['limit_p'];?><?php echo "\n";?>
        ,show_cond = <?php echo $v1['show_cond'];?><?php echo "\n";?>
        ,show_param = <?php echo $v1['show_param'];?><?php echo "\n";?>
    };
<?php }}?>
get(_, _) -> 
    false.

%% 获取所有商城类型列表
type() ->[<?php
$types = array();
foreach ($data as $v){
    $types[] = $v['shop_type'];
}
$types = array_unique($types);
echo implode(',', $types);
?>].

%% 特殊道具购买
%% special_buy(ItemBaseId, Count) -> {Gold, ItemNum} | false
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$arr = array();
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if($row['id'] != ''){
        $arr[$row['id']][] = $row;
    }
}
foreach ($arr as $id => $v){
    $v = array_sort($v, 'count', SORT_DESC);
    for($i=0;$i<sizeof($v);$i++){
        $row = $v[$i];
        $count = $row['count'];
        $gold = $row['gold'];
        $num = $row['num'];
        echo "special_buy({$id}, Count) when Count >= {$count}-> {{$gold}, {$num}};\n";
    }
}
echo "special_buy(_, _) -> false.\n";
?>
