%%----------------------------------------------------
%% 腾讯黄钻
%% @author sy
%%----------------------------------------------------
-module(tx_diamond_data).

-include("gain.hrl").

-export([
	get_reward/3
	,label/1
]).


%% 奖励
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
	$gain = gen_record($v['gain']);
    echo "get_reward({$v['id']}, {$v['act_id']}, {$v['ver']}) -> [{$gain}, {$v['type']}, {$v['lev']}];\n";
}
echo "get_reward(_, _, _) -> false.\n";
?>

%% 标签
<?php
$data = $xml_data[2];
for ($i = 2; $i < count($data); $i++)
{
    $row = $data[$i];
    if ($row['label'] == 'blue_renew_reward')
    {
        $result = gen_record($row['value']);
    }
    else
    {
        $result = $row['value'];
    }
?>
label(<?php echo $row['label']?>) -> <?php echo $result; ?>;
<?php } ?>
label(_Label) -> false.
