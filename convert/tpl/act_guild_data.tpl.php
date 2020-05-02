%%----------------------------------------------------
%% 宗门争霸和帮会争霸(合服)
%% @author sy
%%----------------------------------------------------
-module(act_guild_data).

-include("gain.hrl").

-export([
	get_manor_war/3
	, get_guild_war/3
]).

%% 宗门争霸
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain1 = gen_record($v['gain1']);
	$gain2 = gen_record($v['gain2']);
	$gain3 = gen_record($v['gain3']);
	echo "get_manor_war({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$v['day']}, {$gain1}, {$gain2}, {$gain3}];\n";
}
echo "get_manor_war(_, _, _) -> false.\n";
?>


%% 帮会争霸
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain1 = gen_record($v['gain1']);
	$gain2 = gen_record($v['gain2']);
	$gain3 = gen_record($v['gain3']);
	echo "get_guild_war({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> [{$v['day']}, {$gain1}, {$gain2}, {$gain3}];\n";
}
echo "get_guild_war(_, _, _) -> false.\n";
?>





