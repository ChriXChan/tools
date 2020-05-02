%%----------------------------------------------------
%% 怪物配置
%% @author abu
%%----------------------------------------------------

-module(mon_data).
-export([
        get/1
        ,group_p/1
        ,get_drop/1
        ,get_enter/1
        ,get_ai/2
        ,get_hp_limit/3
        ,robot_skill/1
        ,robot/0
    ]
).
-include("attr.hrl").
-include("monster.hrl").

<?php
function get_ai_data($table){
    $arr = array();
    foreach($table as $row){
        $arr[$row['index']][] = $row;
    }
    return $arr;
}
function get_mon_ai($mid, $ailist, $aidata, $array){
    if($ailist == 0)
        return $array;
    $ailist = explode(",", str_replace(" ", "", $ailist));
    foreach($ailist as $index){
        $ai = $aidata[$index];
        foreach($ai as $ai1){
            $array[$mid][$ai1['type']][] = $ai1;
        }
    }
    return $array;
}
function get_hp_limit($row, $array){
    if(!empty($row['hp_limit'])){
        $hplist = explode(",", str_replace(" ", "", $row['hp_limit']));
        foreach($hplist as $hp){
            $array[$row['id']][] = $hp;
        }
    }
    return $array;
}
function get_ai_str($arrai){
    $str = "";
    foreach($arrai as $ai){
        $str .= get_str($ai);
    }
    return substr($str, 1, strlen($str) - 3);
}
function get_str($row){
    $str = ",#ai_config{id = ".$row['id'].", cond_id = ".$row['cond_id']
        .", cond_arg = ".$row['cond_arg'].", count = ".$row['count'];
    if($row['act_id_1'] != '')
        $str .= ", act1 = ".$row['act_id_1'].", arg1 = ".$row['act_arg_1'];
    if($row['act_id_2'] != '')
        $str .= ", act2 = ".$row['act_id_2'].", arg2 = ".$row['act_arg_2'];
    if($row['act_id_3'] != '')
        $str .= ", act3 = ".$row['act_id_3'].", arg3 = ".$row['act_arg_3'];
    if($row['act_id_4'] != '')
        $str .= ", act4 = ".$row['act_id_4'].", arg4 = ".$row['act_arg_4'];
    if($row['act_id_5'] != '')
        $str .= ", act5 = ".$row['act_id_5'].", arg5 = ".$row['act_arg_5'];
    $str .= "}\n\t\t";
    return $str;
}
function get_attr($row){
    return "#attr{hp_max={$row['hp_max']},dmg={$row['dmg']},defence={$row['defence']},critrate={$row['critrate']},critdmg={$row['critdmg']}".
        ",tenacity={$row['tenacity']},hitrate={$row['hitrate']},evasion={$row['evasion']},dmg_enhance={$row['dmg_enhance']}".
        ",dmg_reduce={$row['dmg_reduce']},anti_stun={$row['anti_stun']},anti_recover={$row['anti_recover']}".
        ",anti_jump={$row['anti_jump']},anti_poison={$row['anti_poison']},anti_taunt={$row['anti_taunt']}}";
}
?>

<?php 
$table = $xml_data[0];
$group = array();
$aidata = get_ai_data($xml_data[1]);
$aimon = array();
$hplimit = array();
for($i=2;$i<sizeof($table);$i++){
    $row = $table[$i];
    $aimon = get_mon_ai($row['id'], $row['ai_list'], $aidata, $aimon);
    $hplimit = get_hp_limit($row, $hplimit);
    if($row['group'] != 0)
        $group[$row['group']] = $row['group_xy'];
?>
get(<?php echo $row['id'];?>) -> #mon_data{id = <?php echo $row['id']?>, name = <<"<?php echo $row['name'];?>">>, type = <?php echo $row['type']?>, type2 = <?php echo $row['type2']?>, atype = <?php echo $row['atype']?>, is_reborn = <?php echo $row['is_reborn']?>, reborn_time = <?php echo $row['reborn_time']?>, remove_time = <?php echo $row['remove_time']?>, attack_interval = <?php echo $row['attack_interval']?>, level = <?php echo $row['lv']?>, exp = <?php echo $row['exp']?>, group = <?php echo $row['group']?>, guard_radius = <?php echo $row['guard_radius'];?>, pursue_radius = <?php echo $row['pursue_radius']?>, speed = <?php echo $row['speed']?>, skill_id = <?php echo $row['skill_ID']?>, collect_id = <?php echo $row['collect_id']?>, volume = <?php echo $row['volume']?>, specval = <?php echo $row['specval']?>, enter = <?php echo (is_numeric($row['enter']) ? $row['enter'] : '0') ?>, anger = <?php echo $row['anger']?>, attr = <?php echo get_attr($row)?>};
<?php }?>
get(_) -> false.

<?php 
    foreach($aimon as $mid => $v){
        foreach($v as $type => $v1){
?>
get_ai(<?php echo $mid ?>, <?php echo $type ?>) -> [
        <?php echo get_ai_str($v1) ?>
    ];
<?php }}?>
get_ai(_, _) -> [].

<?php 
    foreach($hplimit as $mid => $v){
        foreach($v as $hp_per){
?>
get_hp_limit(<?php echo $mid ?>, Hp, HpMax) when (Hp / HpMax * 1000) > <?php echo $hp_per ?> -> <?php echo $hp_per ?>;
<?php }}?>
get_hp_limit(_, _, _) -> 0.

<?php
foreach($group as $k => $v){
?>
group_p(<?php echo $k;?>) -> <?php echo $v;?>;
<?php }?>
group_p(_) -> {0, 0}.


%% 掉落id
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['id'] != "" && $data[$i]['drop'] != ""){
        echo "get_drop(_MonId = ".(trim($data[$i]['id'])).") -> ".trim($data[$i]['drop']).";\n";
    }
}
?>
get_drop(_) -> false.

%% 出场
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
for($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
?>
get_enter(<?php echo $row['id']?>) -> #mon_enter{time = <?php echo $row['time']?>, time2 = <?php echo $row['time2']?>};
<?php }?>
get_enter(_) -> false.

%% 人物机器人技能
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
?>
robot_skill(<?php echo $row['id']?>) -> <?php echo $row['skill']?>;
<?php }?>
robot_skill(_) -> [].

%% 所有人物机器人
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>
robot() ->[<?php
foreach($data as $v) {
    echo "{$v['id']}, ";
}
echo "{$last['id']}].";
?>
