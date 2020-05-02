<?php
/**
 * 基本属性策划，客户端，服务端对照配置
 */
$arr = array();
if (!file_exists(realpath(ATTR_TARGET))){
    return $arr;
}
$attr = rdExcel_XML(realpath(ATTR_TARGET));
$data = $attr[0];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    if($row['label'] != ""){
        $arr[$row['label']] = $row['number'];
    }
}
function ukfun($k1, $k2){
    return strlen($k1) >= strlen($k2) ? -1 : 1;
}
uksort($arr, "ukfun");
return $arr;
?>
