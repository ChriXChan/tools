
<?php
echo "<?php" . "\n";
?>
/** --------------------------------------------------------------------------
*   副本web数据表
*   @author 罗雪情
* ----------------------------------------------------------------------------
*/
return array(
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $v){
    echo "\t" . $v['id'] . " => array( 'id' => " .  $v['id']  . ", 'name' => '" .  $v['name'] ."')," ."\n";
}
?>
);
