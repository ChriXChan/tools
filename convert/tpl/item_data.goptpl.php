<?php
echo "<?php" . "\n";
?>
/** --------------------------------------------------------------------------
*   物品web数据表
*   @author 罗雪情
* ----------------------------------------------------------------------------
*/
return array(
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $v){
    echo "\t" . $v['base_id'] . " => array( 'base_id' => " .  $v['base_id']  . ", 'name' => '" .  $v['name'] ."', 'type' => '" .  $v['type'] . "', 'color' => " .  $v['color'] . ", 'lev' => ". $v['lev'] .")," ."\n";
}
?>
);
