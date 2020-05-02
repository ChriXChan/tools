%% -----------------------------------------------------------------------------
%% YY大厅
%% @author sy
%% -----------------------------------------------------------------------------
-module(yy_hall_data).

-export([
        get_reward/2
    ]).

-include("gain.hrl").

<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain = gen_record($v['gain']);
    echo "get_reward({$v['id']}, {$v['type']}) -> {{$v['id']}, {$v['type']}, {$v['value']}, {$gain}};\n";
}
echo "get_reward(_, _) -> false.\n";
?>