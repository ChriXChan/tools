%% -----------------------------------------------------------------------------
%% 打坐数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(sit_exp_data).

-export([get/1
    ]).

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    echo "get(" . $row['lev'] . ") -> " . $row['exp'] . ";\n";
};
?>
get(_) -> 0.
