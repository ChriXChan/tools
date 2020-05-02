%% -----------------------------------------------------------------------------
%% 城主战数据
%% @author pb
%% -----------------------------------------------------------------------------
-module(guild_city_war_data).

-export([
        id2name/1
        ,pos/1
        ,flag_pos/1
        ,type/1
        ,id2score/1
        ,id2exp/1
        ,label/1
        ,score_reward/1
        ,scores/0
        ,flag_mon/1
        ,mon2id/1
        ,collect_mon/1
        ,collect2id/1
        ,kill_title/1
        ,area_title/1
        ,mul_kill_num/0
        ,skill_energy/1
        ,role_attr_add/2
        ,flag_attr_add/1
        ,exp/1
        ,rank_reward/1
    ]).

-include("condition.hrl").
-include("gain.hrl").
-include("common.hrl").
-include("attr.hrl").
-include("monster.hrl").

%% 领地名字
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
id2name(<?php echo $row['area'];?>) -> <<"<?php echo $row['name'];?>">>;
<?php }?>
id2name(_) -> <<>>.

%% 占领帮会的帮员出生点
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
pos(<?php echo $row['area'];?>) -> util_math:rand_list([<?php echo $row['born_pos1'];?>]);
<?php }?>
pos(_) -> false.

%% 旗帜坐标
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
flag_pos(<?php echo $row['area'];?>) -> <?php echo $row['flag_pos'];?>;
<?php }?>
flag_pos(_) -> false.

%% 帮旗怪物
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if(trim($row['mon_id'])!= "") {
        echo "flag_mon(${row['area']}) -> ${row['mon_id']};"."\n";
    }
?>
<?php }?>
flag_mon(_) -> false.

<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if(trim($row['mon_id'])!= "") {
        echo "mon2id(${row['mon_id']}) -> ${row['area']};"."\n";
    }
?>
<?php }?>
mon2id(_) -> false.

%% 帮旗采集怪
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if(trim($row['mon_id'])!= "") {
        echo "collect_mon(${row['area']}) -> ${row['collect_id']};"."\n";
    }
?>
<?php }?>
collect_mon(_) -> false.

<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if(trim($row['mon_id'])!= "") {
        echo "collect2id(${row['collect_id']}) -> ${row['area']};"."\n";
    }
?>
<?php }?>
collect2id(_) -> false.

%% 占领领地额外加积分
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
id2score(<?php echo $row['area'];?>) -> <?php echo $row['score'];?>;
<?php }?>
id2score(_) -> 0.

%% 占领领地额外加经验
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
id2exp(<?php echo $row['area'];?>) -> <?php echo $row['exp'];?>;
<?php }?>
id2exp(_) -> 0.

<?php
$type_array = array();
for($i=0;$i<sizeof($data);$i++){
    $type = $data[$i]['type'];
    $area = $data[$i]['area'];
    $type_array[$type][] = $area;
}

foreach ($type_array as $key => $value) {
    $last = array_pop($value);
    echo "type({$key}) -> [";
    foreach ($value as $val) {
        echo "{$val}, ";
    }
    echo "{$last}];\n";
}
echo "type(_) -> [].\n";
?>

%% 基本配置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'first_reward' || $data[$i]['label'] == 'view_reward' || $data[$i]['label'] == 'daily_reward'){
        echo 'label('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['null']."\n"; 
    } else{
        echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
label(_) -> false.

%% 个人积分奖励
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
score_reward(<?php echo $row['score'];?>) -> <?php echo gen_record($row['reward']);?>;
<?php }?>
score_reward(_) -> false.

<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
%% 积分奖励段
scores() ->[<?php
foreach($data as $v) {
    echo "{$v['score']}, ";
}
echo "{$last['score']}].";
?>

%% 采集者属性属性加成
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
role_attr_add(Attr, FlagLev) ->
    Attr1 = case flag_mon(FlagLev) of
        false -> Attr#attr{anti_stun = 1000,anti_recover = 1000,anti_jump = 1000,anti_poison = 1000,anti_taunt = 1000};
        MonBid ->
            case mon_data:get(MonBid) of
                false -> Attr#attr{anti_stun = 1000,anti_recover = 1000,anti_jump = 1000,anti_poison = 1000,anti_taunt = 1000};
                #mon_data{attr = MonAttr} ->
                    Attr#attr{
                        anti_stun = MonAttr#attr.anti_stun, 
                        anti_recover = MonAttr#attr.anti_recover, 
                        anti_jump = MonAttr#attr.anti_jump, 
                        anti_poison = MonAttr#attr.anti_poison, 
                        anti_taunt = MonAttr#attr.anti_taunt
                    }
            end
    end,
Attr1#attr{
<?php
echo "\t";
foreach($data as $v) {
    if($v['attr'] == "defence") {
        echo "{$v['attr']} = util_math:floor(Attr1#attr.{$v['attr']}*"."{$v['arg']}/1000),"."\n\t";    
    }else{
        echo "{$v['attr']} = util_math:floor(Attr1#attr.{$v['attr']}*"."{$v['arg']}/1000"."*flag_attr_add(FlagLev)/1000"."), "."\n\t";    
    }
    
}
echo "{$last['attr']} = util_math:floor(Attr1#attr.{$v['attr']}*"."{$last['arg']}/1000"."*flag_attr_add(FlagLev)/1000".")"."\n}.";
?>


%% 帮旗属性加成
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
flag_attr_add(FlagLev) when FlagLev =< <?php echo $row['flag_lev'];?>-> <?php echo $row['arg'];?>;
<?php }?>
flag_attr_add(_) -> 1000.


%% 连杀称号
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'kill_num', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if($row['kill_num'] > 0) {
    	echo 'kill_title(Num) when Num >= '. $row['kill_num']. ' -> '.$row['title'].";\n";
    }
?>
<?php }?>
kill_title(_) -> false.

%% 所有连杀称号
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
$data1 = array();
for($i=0;$i<sizeof($data);$i++){
	if($data[$i]['kill_num'] > 0) {
		array_push($data1, $data[$i]);
	}
}
$last = array_pop($data1);
?>
mul_kill_num() ->[<?php
foreach($data1 as $v) {
    echo "{$v['kill_num']}, ";
}
echo "{$last['kill_num']}].";
?>


%% 领地称号
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if($row['area'] > 0) {
    	echo 'area_title('. $row['area']. ') -> '.$row['title'].";\n";
    }
?>
<?php }?>
area_title(_) -> false.

%% 真气技能配置
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
skill_energy(<?php echo $row['skill_id'];?>) -> <?php echo $row['energy'];?>;
<?php }?>
skill_energy(_) -> false.

%% 经验奖励
<?php
$data = $xml_data[7];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
exp(Lev) when Lev >= <?php echo $row['lev'];?> -> <?php echo $row['exp'];?>;
<?php }?>
exp(_) -> 0.

%% 排名奖励
<?php
$data = $xml_data[8];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
rank_reward(_Rank = <?php echo $row['rank'];?>) -> <?php echo gen_record($row['reward']);?>;
<?php }?>
rank_reward(_) -> [].