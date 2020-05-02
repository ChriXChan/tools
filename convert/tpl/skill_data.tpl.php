%%----------------------------------------------------
%% 战斗行为配置
%% @author abu
%%----------------------------------------------------

-module(skill_data).
-export([
        get/1
        ,get_ids/0
        ,get_lev/1
        ,get_gcd/1
        ,get_cond_loss/2
        ,get_fc/2
        ,passive_rate/2
        ,passive_cond/1
        ,passive_type/1
        ,type/1
        ,group/1
        ,target/1
        ,to_rule/2
        ,type_rule/1
        ,all_rule/0
        ,rule/1
        ,get_base/0
        ,get_combine/0
        ,open/2
    ]
).
-include("skill.hrl").
-include("condition.hrl").
-include("gain.hrl").

<?php 
$table = $xml_data[0];
$ids = '';
$psvtype = array();
$type = array();
$group = array();
$group2 = array();
$base = array();
$combine = array();
$no_target = array();
for($i=2;$i<sizeof($table);$i++){
    $row = $table[$i];
    $ids .= $row['id'].", ";
    if($row['passive_type'] != 0)
        $psvtype[$row['id']] = $row['passive_type'];
    if($row['carrer'] != 0)
        $type[$row['id']] = $row['carrer'];
    if($row['genre'] != 0)
        $group[$row['id']] = $row['genre'];
    if($row['group'] != 0)
        $group2[$row['id']] = $row['group'];
    if($row['type'] == 1)
        $base[] = $row['id'];
    if($row['type'] == 2)
        $combine[] = $row['id'];
    if($row['no_target'] == 1)
        $no_target[] = $row['id'];
?>
get(<?php echo $row['id'];?>) -> 
    #skill_base{
        id = <?php echo $row['id'] . "\n";?>
        ,name = <<"<?php echo $row['name'] . '">>' . "\n";?>
        ,group = <?php echo $row['genre'] . "\n";?>
        ,type = <?php echo $row['carrer'] . "\n";?>
        ,max_lev = <?php echo $row['max_lv'] . "\n";?>
        ,attack_range = <?php echo $row['dis'] . "\n";?>
        ,attack_num = <?php echo $row['num'] . "\n";?>
		,ig_cd = <?php echo $row['ig_cd'] . "\n";?>
        ,cd = <?php echo $row['cd'] . "\n";?>
        ,atk_cd = <?php echo $row['pose_time'] . "\n";?>
        ,gcd = <?php echo $row['gcd'] . "\n";?>
        ,short = <?php echo $row['sc'] . "\n";?>
        ,shape = <?php echo $row['range'] . "\n";?>
        ,radius = <?php echo $row['radius'] * 40 . "\n";?>
        ,center = <?php echo $row['center'] . "\n";?>
        ,anger = <?php echo $row['anger'] . "\n";?>
        ,spectype = <?php echo $row['spectype'] . "\n";?>
        ,spectime = <?php echo $row['spectime'] . "\n";?>
        ,specdis = <?php echo $row['specdis'] . "\n";?>
        ,learn_type = <?php echo $row['skill_type'] . "\n";?>
        ,efftype = <?php echo $row['efftype'] . "\n";?>
    };
<?php }?>
get(_) -> false.

%% 获取全部技能id列表
get_ids() ->
    [<?php echo substr($ids, 0, strlen($ids) - 2);?>].

%% 获取基础技能id列表
get_base() ->
    [<?php echo implode(',', $base);?>].

%% 获取组合技能id列表
get_combine() ->
    [<?php echo implode(',', $combine);?>].

<?php 
$table = $xml_data[1];
for($i=2;$i<sizeof($table);$i++){
	if ($table[$i]["id"] != ''){
        $row = $table[$i];
?>
get_lev(<?php echo $row['id'];?>) -> #skill_lev{id = <?php echo $row['id'];?>, script = [<?php echo $row['script'];?>]};
<?php }}?>
get_lev(_) -> false.

<?php 
$table = $xml_data[2];
for($i=2;$i<sizeof($table);$i++){
        $row = $table[$i];
?>
get_gcd(<?php echo $row['gcd'];?>) -> <?php echo $row['cd'];?>;
<?php }?>
get_gcd(_) -> 0.

%% 获取技能升级条件及消耗
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_cond_loss(<?php echo $data[$i]['id']. ', '.$data[$i]['lev']?>) -> {<?php echo gen_record($data[$i]['conds']).', '. gen_record($data[$i]['loss']);?>};
<?php 
}
?>
get_cond_loss(_, _) -> false.

%% 获取技能升级条件及消耗
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_fc(<?php echo $data[$i]['id']. ', '.$data[$i]['lev']?>) -> <?php echo $data[$i]['fc'];?>;
<?php 
}
?>
get_fc(_, _) -> 0.

<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    if($row['lev'] == 0){
?>
passive_rate(<?php echo $row['id']. ', _'?>) -> <?php echo $row['ratio']?>;
<?php } else {
?>
passive_rate(<?php echo $row['id']. ', '.$row['lev']?>) -> <?php echo $row['ratio']?>;
<?php }}?>
passive_rate(_, _) -> 0.

<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    if($row['condition'] != ''){
?>
passive_cond(<?php echo $row['id']?>) -> <?php echo gen_record($row['condition'])?>;
<?php }}?>
passive_cond(_) -> [].

<?php
foreach ($psvtype as $k => $v){
?>
passive_type(<?php echo $k?>) -> <?php echo $v?>;
<?php }?>
passive_type(_) -> 0.

<?php
foreach ($type as $k => $v){
?>
type(<?php echo $k?>) -> <?php echo $v?>;
<?php }?>
type(_) -> 0.

<?php
foreach ($group as $k => $v){
?>
group(<?php echo $k?>) -> <?php echo $v?>;
<?php }?>
group(_) -> 0.

<?php
foreach ($no_target as $v){
    ?>
target(<?php echo $v?>) -> 1;
<?php }?>
target(_) -> 0.

%% 获取技能组合配置
<?php
$data = $xml_data[8];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
?>
rule(<?php echo $row['id']?>) ->
    #skill_combine_data{id = <?php echo $row['id']?>, main_id = <?php echo $row['main_id']?>, secondary_id = <?php echo $row['secondary_id']?>, target_id = <?php echo $row['target_id']?>, type = <?php echo $row['type']?>, desc = <<"<?php echo $row['desc']?>">>};
<?php
}
?>
rule(_) -> false.

%% 全部技能组合配置
all_rule() ->
    [
<?php for ($i = 0; $i < count($data) - 1; $i++) {
$row = $data[$i];
?>
    #skill_combine_data{id = <?php echo $row['id']?>, main_id = <?php echo $row['main_id']?>, secondary_id = <?php echo $row['secondary_id']?>, target_id = <?php echo $row['target_id']?>, type = <?php echo $row['type']?>, desc = <<"<?php echo $row['desc']?>">>},
<?php }?>
    #skill_combine_data{id = <?php echo $data[$i]['id']?>, main_id = <?php echo $data[$i]['main_id']?>, secondary_id = <?php echo $data[$i]['secondary_id']?>, target_id = <?php echo $data[$i]['target_id']?>, type = <?php echo $data[$i]['type']?>, desc = <<"<?php echo $data[$i]['desc']?>">>}
].

%% 获取某类型的技能组合配置
type_rule(Type) ->
    All = all_rule(),
    [E || E <- All, E#skill_combine_data.type =:= Type].

%% 根据主副技能获取配方id
<?php
for ($i = 0; $i < count($data); $i++) {
$row = $data[$i];
?>
to_rule(<?php echo $row['main_id']?>, <?php echo $row['secondary_id']?>) -> <?php echo $row['id']?>;
<?php
}
?>
to_rule(_, _) -> false.

%% 技能开启
<?php
$data = $xml_data[10];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    ?>
open(<?php echo $row['type']?>, <?php echo $row['val']?>) -> [<?php echo $row['open']?>];
<?php
}
?>
open(_, _) -> false.