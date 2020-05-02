%% -----------------------------------------------------------------------------
%% 4366大厅
%% @author sy
%% -----------------------------------------------------------------------------
-module(p4366_hall_data).

-export([
        get_reward/3
    ]).

-include("gain.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    $gain = gen_record($v['gain']);
    echo "get_reward({$v['id']}, {$v['act_id']}, {$v['act_ver']}) -> {{$v['type']}, {$v['limit']}, {$gain}};\n";
}
echo "get_reward(_, _, _) -> false.\n";
?>