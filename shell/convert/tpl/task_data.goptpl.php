
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
    echo "\t" . $v['id'] . " => array( 'id' => " .  $v['id']  . ", 'name' => '" .  $v['name'] . "', 'type' => " .  $v['type'] . ", 'type_name' => '".gop_type2name($v['type']) . "', 'lev' => ". $v['level'] .")," ."\n";
}

function gop_type2name($type){
    switch($type){
        case 1:
            return "主线";
        case 2:
            return "支线";
        case 3:
            return "日常";
        case 4:
            return "帮派";
        default:
            return "未知";
    }
}
?>
);
