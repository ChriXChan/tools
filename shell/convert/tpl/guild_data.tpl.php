%% -----------------------------------------------------------------------------
%% 帮派数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(guild_data).

-export([guild_config/1,guild_flag/1,lev_to_stage/1,lev/1,max_exp/0,guild_welfare/2,guild_skill/2,guild_reputation/1,guild_guard/1]).

-include("condition.hrl").
-include("gain.hrl").
-include("common.hrl").
-include("guild.hrl").


%% 基本配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'feed_loss' || $data[$i]['label'] == 'create_loss' || $data[$i]['label'] == 'create_conds'
        || $data[$i]['label'] == 'create_gain'|| $data[$i]['label'] == 'donate_gold'|| $data[$i]['label'] == 'donate_item'){
        echo 'guild_config('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n";
    }elseif ($data[$i]['label'] == 'desc' || $data[$i]['label'] == 'quit_desc') {
        echo 'guild_config('.$data[$i]['label']. ') -> <<"' .$data[$i]['value'].'">>;'."\t%%".$data[$i]['desc']."\n";
    }
    else{
        echo 'guild_config('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
guild_config(_) -> false.

%%帮会圣物
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['flag_lev']))!=""){
        echo "guild_flag(" . $data[$i]['flag_lev'] .
            ") -> #guild_flag{flag_lev = " . $data[$i]['flag_lev'] .
            ",flag_exp = " . $data[$i]['flag_exp'] .
            ", attr = [".attr_to_int($data[$i]['attr']) .
            "], master_attr = [".attr_to_int($data[$i]['master_attr']) .
            "],max_member = ".$data[$i]['max_member'].
            ",max_skill_level = ". $data[$i]['max_skill_level'] ."};". "\n";
    }
}
?>
guild_flag(_) -> false.

%%帮会圣物等级阶数转换
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['flag_lev']))!=""){
        echo "lev_to_stage(" . $data[$i]['flag_lev'] .
            ") -> ". $data[$i]['step'] .";". "\n";
    }
}
?>
lev_to_stage(_) -> 1.



%%帮会圣物经验
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$maxExp = sizeof($data) - 2;
$max = $data[$maxExp];
for($i=sizeof($data) - 2;$i>=0;$i--){
    $row = $data[$i];
    ?>lev(Exp) when Exp >= <?php echo $row['flag_exp'];?> -> <?php echo $row['flag_lev'] + 1;?>;
<?php }?>
lev(_) -> 1.

%%帮会圣物最大经验
max_exp() -> <?php echo $max['flag_exp'];?>.


%%帮会福利
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['level']))!=""){
        echo "guild_welfare(" . $data[$i]['level'] . "," . $data[$i]['job'].
            ") -> #guild_welfare{level = " . $data[$i]['level'] .",job = " . $data[$i]['job'] .
            ",reward = " . gen_record($data[$i]['reward']) ."};". "\n";
    }
}
?>
guild_welfare(_,_) -> false.

%%帮会技能
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['skill_id']))!=""){
        echo "guild_skill(" . $data[$i]['skill_id'] .",". $data[$i]['skill_level'].
            ") -> #guild_skill{skill_id = " . $data[$i]['skill_id'] .
            ",skill_level = " . $data[$i]['skill_level'] .
            ", attr = [".attr_to_int($data[$i]['attr']) .
            "],loss = ". gen_record($data[$i]['loss']) ."};". "\n";
    }
}
?>
guild_skill(_,_) -> false.


%%帮会声望
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if((trim($data[$i]['id']))!=""){
        echo "guild_reputation(" . $data[$i]['id'].
            ") -> #guild_reputation{id = " . $data[$i]['id'] .
            ",reputation = " . $data[$i]['reputation'] .
            ",total_count = " . $data[$i]['total_count'] ."};". "\n";
    }
}
?>
guild_reputation(_) -> false.

%% 帮会塔防
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $name = substr($data[$i]['label'],1,11);
    $name2 = substr($data[$i]['label'],1,8);
    if($name == 'custom_show'){
        echo 'guild_guard('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n";
    }
    else if ($name2 == 'box_show')
        echo 'guild_guard('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n";
    else{
        echo 'guild_guard('.$data[$i]['label']. ') -> [' .$data[$i]['value'].'];'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
guild_guard(_) -> false.