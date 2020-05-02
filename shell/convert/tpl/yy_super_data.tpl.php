%% -----------------------------------------------------------------------------
%% YY超玩
%% @author sy
%% -----------------------------------------------------------------------------
-module(yy_super_data).

-export([
        get_buff/1
    ]).

-include("gain.hrl").

%% BUFF
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $v) {
    echo "get_buff({$v['vip_lev']}) -> {$v['buff_id']};\n";
}
echo "get_buff(_) -> false.\n";
?>