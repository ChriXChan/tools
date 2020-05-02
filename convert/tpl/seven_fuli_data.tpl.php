%% -----------------------------------------------------------------------------
%% 7日登陆活动
%% @author pb
%% -----------------------------------------------------------------------------
-module(seven_fuli_data).

-export([
        login/1
        ,target_cond/1
        ,day_ids/1
        ,target/1
        ,label/1
    ]).

-include("gain.hrl").
-include("condition.hrl").

%% 7日登陆奖励
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $id = $row['id'];
    $gain = gen_record($row['gain']);
    echo "login({$id}) -> {$gain};\n";
}
?>
login(_) -> [].

%% 7日目标条件
<?php
$day_ids = array();

$data = $xml_data[1];
for ($i = 2; $i < sizeof($data); $i++) { 
    $row = $data[$i];

    $id = $row['id'];
    $openDay = $row['open_day'];

    $day_ids[ $openDay ][] = $id;

    echo "target_cond({$id}) -> {$row['cond']};\n";
}
?>
target_cond(_Id) -> false.

<?php
foreach($day_ids as $k => $v) {
?>
day_ids(_Day = <?php echo $k;?>) -> [<?php echo implode(",", $v);?>];
<?php }?>
day_ids(_Day) -> [].


%% 7日目标奖励
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i=0; $i < sizeof($data); $i++) { 
    $row = $data[$i];
    $id = $row['id'];
    $gain = gen_record($row['gain']);
    echo "target({$id}) -> {$gain};\n";
}
?>
target(_Id) -> [].


%% 七日登录标签
<?php
$data = $xml_data[2];
for ($i = 2; $i < count($data); $i++)
{
    $row = $data[$i];
    if ($row['type'] == 'star_reward')
    {
        $result = gen_record($row['value']);
    }
    else if ($row['type'] == 'url')
    {
        $result = "<<\"" . $row['value'] . "\">>";
    }
    else
    {
        $result = $row['value'];
    }
?>
label(<?php echo $row['type']?>) -> <?php echo $result; ?>;
<?php } ?>
label(_Label) -> false.
