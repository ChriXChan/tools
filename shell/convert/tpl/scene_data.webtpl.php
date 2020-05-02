
<?php
echo "<?php" . "\n";
?>
/** --------------------------------------------------------------------------
*   场景web数据表
*   @author 罗雪情
* ----------------------------------------------------------------------------
*/
return array(
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $v){
    echo "\t" . $v['id'] . " => array( 'id' => " .  $v['id']  . ", 'name' => '" .  $v['name'] . "', 'map_type' => " .  $v['maptype'] . ", 'type_name' => '".type2name2($v['maptype']) . "', 'lev' => ". $v['lowlevel'] .")," ."\n";
}

function type2name2($type){
    switch($type){
        case 1:
            return "野外地图";
        case 2:
            return "副本地图";
        case 3:
            return "BOSS地图";
        case 4:
            return "主城地图";
        case 7:
            return "个人竞技";
        case 8:
            return "帮派地图";
        case 9:
            return "伏魔塔";
        case 10:
            return "跨服战场";
        default:
            return "未知";
    }
}
?>
);