%% -----------------------------------------------------------------------------
%% 物品数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(item_data).

-export([
        get/1
        ,get_pos/1
        ,get_rand_item/2
        ,maxprob/1
		,market_mapping/1
		,market_all_type/0
		,type2group/1
    ]
).

-include("item.hrl").
-include("condition.hrl").
-include("gain.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$size = count($data);
for ($i = 0; $i < $size; $i++) {
    if ($data[$i]['sort'] != '')
        $datasort = $data[$i]['sort'];
    else
        $datasort = 0;
    $cond = gen_record($data[$i]['condition']);
    if((trim($data[$i]['base_id']))!=""){
    	echo "get(" . $data[$i]['base_id'] . ") -> #item_data{id = " . $data[$i]['base_id'] .', name = <<"'.$data[$i]['name'].'">>, group ='. $data[$i]['group'] . ", type = ".$data[$i]['type'] . ", color = " . $data[$i]['color'] . ", overlap = ". $data[$i]['overlap']. ", use_type = " . $data[$i]['use_type'] . ", is_drop =" . $data[$i]['drop'] . ", is_smelt = " .$data[$i]['smelt']. ", lev =" . $data[$i]['lev'] . ", zhuanshu =" . $data[$i]['zhuanshu'] . ", sort = " . $datasort . ", attr = [" . attr_to_int($data[$i]['attr']) ."]". " , condition = ". $cond . ", effect = [" . $data[$i]['effect']."]".", extra = [". $data[$i]['extra'] ."]};"."\n";
    }
}
?>
get(_) -> false.

%%装备位置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_pos(<?php echo '_Id = '.$data[$i]['id'] ?>) -> {<?php echo $data[$i]['pos'];?>, <?php echo $data[$i]['step'];?>};
<?php 
}
?>
get_pos(_) -> false.


<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
$base = array();
for ($i = 0; $i < sizeof($data); $i++) {
    $row = $data[$i];
    if($row['id'] != ""){
        $base[$row['id']][] = $row;
    }
}
?>

%% 随机物品
<?php
    foreach ($base as $id => $rulearray) {
        for ($i = 0, $x = 0; $i < sizeof($rulearray); $i++) {
            $row = $rulearray[$i];
            $x = $x + $row['rand'];
            if($row['rand'] != 0) {
                $reward = gen_record($row['gain']);
                echo 'get_rand_item(_Id = '.$id.', Random) when Random =< '.$x ." -> ".$reward.';'."\n";
            }
        }
    }
?>
get_rand_item(_, _) -> false.

%% 随机物品概率和
<?php
    foreach ($base as $id => $rulearray) {
        $x = 0;
        for ($i = 0; $i < sizeof($rulearray); $i++) {
            $row = $rulearray[$i];
            $x = $x + $row['rand'];
        }
        echo 'maxprob(_Id = '.$id.') -> '.$x.";\n";
    }
?>
maxprob(_) -> 1.

<?php
$data = $xml_data[4];
$all_type = "";
array_shift($data);
array_shift($data);
?>
%% 市场类型映射
<?php
$id2group = array();
foreach($data as $v) {
	$tmp = get_number($v['first']);
    $id2group[$tmp] = explode(",", trim($v['mapping']));
	$all_type = $all_type.$v['mapping'].",";
    echo <<<EOF
market_mapping({$tmp}) -> [{$v['mapping']}];

EOF;
}
?>
market_mapping(_) -> [].

%% 所有可寄售类型
<?php
$all_type = substr($all_type, 0, strlen($all_type) - 1);
    echo <<<EOF
market_all_type() -> [{$all_type}].

EOF;
?>

%% secondtype -> firsttype
<?php
foreach($id2group as $group => $arr){
    foreach($arr as $v){
        echo "type2group({$v}) -> " . $group . ";\n";
    }
}
echo 'type2group(_) -> 0.';
