%%----------------------------------------------------
%% 福利数据
%% @author pb
%%----------------------------------------------------
<?php

?>
-module(welfare_data).
-export([
reward_lev/1
,offline_data/0
,reward_sign/2
,reward_sign_charge/2
,reward_total_sign/1
,get_online_award/1
,welfare_update/1
]
).

-include("gain.hrl").
-include("condition.hrl").

%% 等级福利奖励
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
reward_lev(<?php echo '_Lev = '.$data[$i]['lev']?>) -> <?php echo gen_record($data[$i]['gain']);?>;
<?php
}
?>
reward_lev(_) -> false.


%%离线经验奖励倍数
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$data1 = array_reverse($data);
$last = array_pop($data1);
?>

offline_data() ->[<?php
foreach($data1 as $v) {
    echo "{".$v['type']. ",".gen_record($v['cond']).",".$v['adjust']."},";
}
echo "{".$last['type']. ",".gen_record($last['cond']).",".$last['adjust']."}].";
?>

%% 签到奖励
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
reward_sign(<?php echo '_Month = '.$data[$i]['month'].', _Day = '.$data[$i]['day']?>) -> <?php echo gen_record($data[$i]['reward']);?>;
<?php
}
?>
reward_sign(_, _) -> [].

%% 二次签到奖励
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
reward_sign_charge(<?php echo '_Month = '.$data[$i]['month'].', _Day = '.$data[$i]['day']?>) -> <?php echo gen_record($data[$i]['ex_reward']);?>;
<?php
}
?>
reward_sign_charge(_, _) -> [].

%% 签到累计奖励
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>reward_total_sign(<?php echo '_Day = '.$data[$i]['day']?>) -> {<?php echo gen_record($data[$i]['reward']);?>,<?php echo $data[$i]['vip_lev'];?>};
<?php
}
?>
reward_total_sign(_) -> false.


%% 在线奖励
<?php
$data = $xml_data[6];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
%% <?php echo $data[$i]['desc'] . "\n" ?>
get_online_award(<?php echo $data[$i]['type'] ?>) -> <?php echo '[', $data[$i]['value'] ,']' ; ?>;
<?php
}
?>
get_online_award(_) -> false.



%% 更新公告
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'award'){
        echo 'welfare_update('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n";
    }elseif ($data[$i]['label'] == 'title' || $data[$i]['label'] == 'content') {
        echo 'welfare_update('.$data[$i]['label']. ') -> <<>>;'."\t%%".$data[$i]['desc']."\n";
    }
    else{
        echo 'welfare_update('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
welfare_update(_) -> false.
