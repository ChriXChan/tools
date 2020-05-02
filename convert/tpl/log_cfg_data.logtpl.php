<?php
/** --------------------------------------------------------------------------
*   etl日志配置
*   @author luoxueqing
* ----------------------------------------------------------------------------
*/

echo "<?php\n  return ";

$data = $xml_data[0];
array_shift($data);
array_shift($data);
$log_cfg = array();
foreach($data as $v){
    $log_cfg[$v['type']]['now_ver'] = max($log_cfg[$v['type']]['now_ver'] ? $log_cfg[$v['type']]['now_ver'] : 0, $v['ver']);
    $log_cfg[$v['type']]['ver_info'][$v['ver']] = array("fields" => "{$v['fields']}", "db_change" => $v['db_change']);
}
var_export($log_cfg);
echo ";\n";
?>
