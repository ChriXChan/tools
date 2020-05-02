<?php
echo "<?php" . "\n";
?>
/** --------------------------------------------------------------------------
*   任务web数据表
*   @author 罗雪情
* ----------------------------------------------------------------------------
*/
return array(
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $v){
    echo "\t" . $v['id'] . " => array( 'id' => " .  $v['id']  . ", 'name' => '" .  $v['name'] . "', 'type' => " .  $v['type'] . ", 'type_name' => '".type2name($v['type']) . "', 'lev' => ". $v['lv'] .")," ."\n";
}

function type2name($type){
    switch($type){
        case 1:
            return "采集物";
        case 2:
            return "普通boss";
        case 3:
            return "世界boss";
        case 4:
            return "帮派boss";
        case 0:
            return "普通怪";
        default:
            return "未知";
    }
}
?>
);
