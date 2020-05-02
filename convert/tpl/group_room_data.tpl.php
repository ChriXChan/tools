%% -----------------------------------------------------------------------------
%% 分组跨服房间人数
%% -----------------------------------------------------------------------------
-module(group_room_data).
-export([ 
	get/1
	,open_day/1
	,all_act/0
	,specify_room/2
]).

-include("cross.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    echo "get({$row['id']}) -> {$row['num']};"."\n";
}?>
%% 默认300
get(_) -> ?cross_group_room_role_num.

<?php
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    echo "open_day({$row['id']}) -> {$row['open']};"."\n";
}?>
%% 默认300
open_day(_) -> 0.

%% 所有活动
<?php
$last = array_pop($data);
?>
all_act() ->[<?php
foreach($data as $v) {
    echo "{$v['id']}, ";
}
echo "{$last['id']}].";
?>


%% 指定分房间
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
for($i=0;$i<sizeof($data);$i++){
    $row = $data[$i];
    $act_id = $row['id'];
    $srv_id = $row['srv_id'];
    $platform = $row['platform'];
    echo "specify_room({$act_id}, \"{$platform}\") -> [{$srv_id}];"."\n";
}?>
specify_room(_, _) -> false.