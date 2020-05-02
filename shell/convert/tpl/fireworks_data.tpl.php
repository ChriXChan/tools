%% -----------------------------------------------------------------------------
%% 天降宝箱数据
%% @author lijingfeng
%% -----------------------------------------------------------------------------
-module(fireworks_data).

-export([
label/1
,fireworks_award/0
,exp/1
]
).

-include("gain.hrl").

%% 基本配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    if($data[$i]['label'] == 'reward' || $data[$i]['label'] == 'ex_reward'){
        echo 'label('.$data[$i]['label']. ') -> ' .gen_record($data[$i]['value']).';'."\t%%".$data[$i]['desc']."\n";
    }
    elseif ($data[$i]['label'] == 'positions' || $data[$i]['label'] == 'positions2') {
        echo 'label('.$data[$i]['label']. ') -> [' .$data[$i]['value'].'];'."\t%%".$data[$i]['desc']."\n";
    }
    else {
        echo 'label('.$data[$i]['label']. ') -> ' .$data[$i]['value'].';'."\t%%".$data[$i]['desc']."\n";
    }
}
?>
label(_) -> false.


%%转盘表
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
$last = array_pop($data);
?>

fireworks_award() ->[<?php
foreach($data as $v) {
    echo "{".$v['pos']. ",".gen_record($v['item_id']).",".$v['rate']."},";
}
echo "{".$last['pos']. ",".gen_record($last['item_id']).",".$last['rate']."}].";
?>


%%经验
<?php
$data = $xml_data[2];
$scores = array();
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    ?>
exp(<?php echo $row['lev']?>) -> <?php echo $row['end_exp']?>;
<?php }?>
exp(_) -> 0.