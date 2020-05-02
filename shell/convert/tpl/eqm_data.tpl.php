%% -----------------------------------------------------------------------------
%% 装备数据
%% @author luoxueqing
%% -----------------------------------------------------------------------------
-module(eqm_data).
-include("eqm.hrl").
-include("gain.hrl").

-export([
        get/1
        ,get_pool/1
        ,active_suit/2
        ,id2suit/1
        ,item2group/1
        ,orange2red/1
        ,red2cost/1
        ,red2mt/1
        ,score/1
        ,lev/1
        ,skill/1
        ,red_attr/1
    ]
).

%% 装备附加属性率配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get(<?php echo $data[$i]['id']?>) ->
    {<?php echo $data[$i]['num']?>, [<?php echo $data[$i]['prob1']?>, <?php echo $data[$i]['prob2']?>, <?php echo $data[$i]['prob3']?>, <?php echo $data[$i]['prob4']?>, <?php echo $data[$i]['prob5']?>, <?php echo $data[$i]['prob6']?>, <?php echo $data[$i]['prob7']?>], <?php echo $data[$i]['spec_rate']?>, <?php echo $data[$i]['prob10']?> , <?php echo $data[$i]['skill_enhance_rate']?>, <?php echo $data[$i]['prob11']?> };<?php echo "\n"?>
<?php }?>
get(_) -> 
    false.

<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    ?>
%% 随机属性池
get_pool(<?php echo $data[$i]['id']?>) ->
    [<?php echo $data[$i]['pool']?>];<?php echo "\n"?>
<?php }?>
get_pool(_) ->
    false.


%% 套装激活条件(组，收集个数) -> 套装id
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    ?>
active_suit(<?php echo $data[$i]['group']?>, <?php echo $data[$i]['num']?>) -> <?php echo $data[$i]['id']?>;
<?php }?>
active_suit(_,_) -> 0.

%% 获取套装配置
<?php
for ($i = 0; $i < count($data); $i++) {
    ?>
id2suit(<?php echo $data[$i]['id']?>) ->
    #eqm_suit_data{id = <?php echo $data[$i]['id']?>, num = <?php echo $data[$i]['num']?>, attr = [<?php echo attr_to_int($data[$i]['attr'])?>], gain = <?php echo gen_record($data[$i]['gain'])?>, skill = []};<?php echo "\n"?>
<?php }?>
id2suit(_) ->
    #eqm_suit_data{}.

%% 装备对应的组
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    ?>
item2group(<?php echo $data[$i]['item_id']?>) -> <?php echo $data[$i]['group']?>;
<?php }?>
item2group(_) -> false.

	
%% 橙装对应红装配置
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    ?>
orange2red(<?php echo $data[$i]['orange_id']?>) -> {<?php echo $data[$i]['red_id']?>, <?php echo gen_record($data[$i]['cost'])?>};<?php echo "\n"?>
<?php }?>
orange2red(_) -> false.

%% 红装对应消耗
<?php
for ($i = 0; $i < count($data); $i++) {
    ?>
red2cost(<?php echo $data[$i]['red_id']?>) -> <?php echo gen_record($data[$i]['cost'])?>;<?php echo "\n"?>
<?php }?>
red2cost(_) -> false.

%% 红装对应材料抵扣
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    ?>
red2mt(<?php echo $data[$i]['red_id']?>) -> {<?php echo gen_record($data[$i]['mt'])?>, <?php echo gen_record($data[$i]['add'])?>};<?php echo "\n"?>
<?php }?>
red2mt(_) -> false.

%% 红装炼器师等级
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'level', SORT_DESC);
for ($i = 0; $i < count($data); $i++) {
    $score = $data[$i]['score'];
    $lev = $data[$i]['level'];
    echo "lev(Score) when Score >= {$score} -> {$lev};\n";
}?>
lev(_) -> 0.

%% 红装炼器师技能
<?php 
for ($i = 0; $i < count($data); $i++) {
    $skill = $data[$i]['skill'];
    $lev = $data[$i]['level'];
    echo "skill({$lev}) -> {$skill};\n";
}?>
skill(_) -> false.

%% 红装
<?php
for ($i = 0; $i < count($data); $i++) {
    $lev = $data[$i]['level'];
    $attr = attr_to_int($data[$i]['attr']);
    echo "red_attr({$lev}) -> [{$attr}];\n";
}?>
red_attr(_) -> [].

%% 红装评分
<?php
$data = $xml_data[7];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $score = $data[$i]['score'];
    $red_id = $data[$i]['red_id'];
    echo "score({$red_id}) -> {$score};\n";
}?>
score(_) -> 0.