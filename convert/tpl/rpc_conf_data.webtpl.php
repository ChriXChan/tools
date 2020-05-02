<?php
echo "<?php" . "\n";
?>
/** --------------------------------------------------------------------------
*   协议rpc类型定义gop数据表
*   @author 罗雪情
* ----------------------------------------------------------------------------
*/
return array(
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    echo "\t" . $i . " => array( 'key' => " .  $i  . ", 'val' => '" .  $data[$i]['desc']  ."')," ."\n";
}
?>
);
