%% -----------------------------------------------------------------------------
%% 精炼数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(eqm_refine_data).

-export([max_qx/2
    , max_fy/2
    , max_gj/2
    , attr/1
    , item/1
    , type2pos/1
]).

-include("gain.hrl").

%% 气血石上限
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['color'] != "") {
        echo "max_qx(" . $row['color'] . ", " . $row['zhuanshu'] . ") -> " . $row['max_qx'] . ";" . "\n";
    }
}
?>
max_qx(_, _) -> 0.

%% 防御石上限
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['color'] != "") {
        echo "max_fy(" . $row['color'] . ", " . $row['zhuanshu'] . ") -> " . $row['max_fy'] . ";\n";
    }
}
?>
max_fy(_, _) -> 0.

%% 攻击石上限
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['color'] != "") {
        echo "max_gj(" . $row['color'] . ", " . $row['zhuanshu'] . ") -> " . $row['max_gj'] . ";\n";
    }
}
?>
max_gj(_, _) -> 0.

%% 位置=>属性
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['pos'] != "" && $row['attr'] != "") {
        $attr = attr_to_int($row['attr']);
        echo "attr(" . $row['pos'] . ") -> [" . $attr . "];\n";
    }
}
?>
attr(_) -> [].

%%
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['base_id'] != "" && $row['type'] != "") {
        echo "item(" . $row['type'] . ") -> " . $row['base_id'] . ";\n";
    }
}
?>
item(_) -> 0.

%%
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $row) {
    if ($row['type'] != "" && $row['pos'] != "") {
        echo "type2pos(" . $row['type'] . ") -> " . $row['pos'] . ";\n";
    }
}
?>
type2pos(_) -> false.
