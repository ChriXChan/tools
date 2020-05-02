%% -----------------------------------------------------------------------------
%% 帮会领地战数据
%% @author pb
%% -----------------------------------------------------------------------------
-module(guild_area_war_data).

-export([
        id2map/1
        ,map2id/1
        ,id2color/1
        ,id2name/1
        ,pos1/1
        ,pos2/1
        ,flag_pos/1
        ,all/0
        ,all_area/0
        ,all_area_map/0
        ,reward/1
        ,label/1
        ,score_reward/1
        ,scores/0
        ,flag_mon/1
        ,kill_title/1
        ,area_title/1
        ,mul_kill_num/0
        ,skill_energy/1
        ,role_attr_add/2
        ,flag_attr_add/1
        ,color2score/1
        ,color2donate/1
        ,color2flagexp/1
        ,color2exp/1
        ,exp/1
    ]).

-include("condition.hrl").
-include("gain.hrl").
-include("common.hrl").
-include("attr.hrl").
-include("monster.hrl").

%% 地图入口
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
id2map(<?php echo $row['area'];?>) -> <?php echo $row['scene'];?>;
<?php }?>
id2map(_) -> false.

<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
map2id(<?php echo $row['scene'];?>) -> <?php echo $row['area'];?>;
<?php }?>
map2id(_) -> false.

%% 品质
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
id2color(<?php echo $row['area'];?>) -> <?php echo $row['color'];?>;
<?php }?>
id2color(_) -> false.

%% 领地名字
<?php
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
pos1(<?php echo $row['area'];?>) -> util_math:rand_list([<?php echo $row['born_pos1'];?>]);
<?php }?>
pos1(_) -> false.

%% 其他出生点
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
pos2(<?php echo $row['area'];?>) -> util_math:rand_list([<?php echo $row['born_pos2'];?>]);
<?php }?>
pos2(_) -> false.

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

%% 所有领地
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
all() ->[<?php
foreach($data as $v) {
    echo "{$v['area']}, ";
}
echo "{$last['area']}].";
?>

%% 所有领地
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$data1 = array();
for($i=0;$i<sizeof($data);$i++){
	if($data[$i]['is_area_war'] == 1) {
		array_push($data1, $data[$i]);
	}
}
$last = array_pop($data1);
?>
all_area() ->[<?php
foreach($data1 as $v) {
	if($v['is_area_war'] == 1){
		echo "{$v['area']}, ";
	}
}
if($last['is_area_war'] == 1){
	echo "{$last['area']}].";
}
?>

%% 所有地图
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$data1 = array();
for($i=0;$i<sizeof($data);$i++){
	if($data[$i]['is_area_war'] == 1) {
		array_push($data1, $data[$i]);
	}
}
$last = array_pop($data1);
?>
all_area_map() ->[<?php
foreach($data1 as $v) {
	echo "{$v['scene']}, ";
}
echo "{$last['scene']}].";
?>


%% 领地每日奖励
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
reward(<?php echo $row['area'];?>) -> <?php echo gen_record($row['reward']);?>;
<?php }?>
reward(_) -> [].

%% 基本配置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
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

%% 领地品质积分
<?php
$data = $xml_data[7];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
color2score(<?php echo $row['color'];?>) -> <?php echo $row['score'];?>;
<?php }?>
color2score(_) -> 0.

%% 领地品质帮贡
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
color2donate(<?php echo $row['color'];?>) -> <?php echo $row['donate'];?>;
<?php }?>
color2donate(_) -> 0.

%% 领地品质帮旗经验
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
color2flagexp(<?php echo $row['color'];?>) -> <?php echo $row['flag_exp'];?>;
<?php }?>
color2flagexp(_) -> 0.

%% 领地品质经验
<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
color2exp(<?php echo $row['color'];?>) -> <?php echo $row['exp'];?>;
<?php }?>
color2exp(_) -> 0.

%% 经验奖励
<?php
$data = $xml_data[8];
array_shift($data);
array_shift($data);
$data = array_sort($data, 'lev', SORT_DESC);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
?>
exp(Lev) when Lev >= <?php echo $row['lev'];?> -> <?php echo $row['exp'];?>;
<?php }?>
exp(_) -> 0.