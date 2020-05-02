%% -----------------------------------------------------------------------------
%% 公告定义
%% @author luoxueqing
%% -----------------------------------------------------------------------------

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $row){
    echo "-define({$row['notice_define']}, {$row['id']}).\n";
}
?>
