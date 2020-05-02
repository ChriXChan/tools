%% -----------------------------------------------------------------------------
%% YY大厅
%% @author sy
%% -----------------------------------------------------------------------------
-module(yy_member_data).

-export([
        get_reward/3
    ]).

-include("gain.hrl").

<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain = gen_record($v['gain']);
	$gain1 = gen_record($v['loss']);
    echo "get_reward({$v['id']}, {$v['type']}, {$v['index']}) -> {{$v['id']}, {$v['type']}, {$v['index']}, {$gain}, {$v['lev']}, {$gain1}};\n";
}
echo "get_reward(_, _, _) -> false.\n";
?>