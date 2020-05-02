%% -----------------------------------------------------------------------------
%% 合成数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(combine_data).

-export([get/1
]).

-include("gain.hrl").

%% 消耗
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < sizeof($data); $i++) {
    $row = $data[$i];
    if ($row['id'] != "") {
        $loss = gen_record($row['loss']);
        $gain = gen_record($row['gain']);
        echo "get(" . $row['id'] . ") -> {" . $loss . ", " . "$gain" . "};
";
    }
}
?>
get(_) -> false.
