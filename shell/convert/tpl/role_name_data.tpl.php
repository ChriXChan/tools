%% -----------------------------------------------------------------------------
%% 玩家名字库
%% @author luoxueqing
%% -----------------------------------------------------------------------------
-module(role_name_data).

-export([
        size/2
        ,get/3
    ]).

<?php

// 男姓
$male_first_name = $xml_data[0];
array_shift($male_first_name);
array_shift($male_first_name);

// 男名
$male_second_name = $xml_data[1];
array_shift($male_second_name);
array_shift($male_second_name);

// 女姓
$famale_first_name = $xml_data[2];
array_shift($famale_first_name);
array_shift($famale_first_name);

// 女名
$famale_second_name = $xml_data[3];
array_shift($famale_second_name);
array_shift($famale_second_name);

// 分隔符
$separator = $xml_data[4];
array_shift($separator);
array_shift($separator);

?>

size(first_name, 1) -><?php echo count($male_first_name);?>;
size(first_name, 0) -><?php echo count($famale_first_name);?>;
size(second_name, 1) -><?php echo count($male_second_name);?>;
size(second_name, 0) -><?php echo count($famale_second_name);?>;
size(separator, _)-><?php echo count($separator);?>;
size(_, _) -> 0.

<?php
    for($i = 1; $i <= count($male_first_name); $i++){
        echo "get(first_name, 1, $i) -> ";
        echo "<<\"{$male_first_name[$i - 1]['first_name']}\">>;\n";
    }

    for($i = 1; $i <= count($male_second_name); $i++){
        echo "get(second_name, 1, $i) -> ";
        echo "<<\"{$male_second_name[$i - 1]['second_name']}\">>;\n";
    }

    for($i = 1; $i <= count($famale_first_name); $i++){
        echo "get(first_name, 0, $i) -> ";
        echo "<<\"{$famale_first_name[$i - 1]['first_name']}\">>;\n";
    }

    for($i = 1; $i <= count($famale_second_name); $i++){
        echo "get(second_name, 0, $i) -> ";
        echo "<<\"{$famale_second_name[$i - 1]['second_name']}\">>;\n";
    }

    for($i = 1; $i <= count($separator); $i++){
        echo "get(separator, _, $i) -> ";
        echo "<<\"{$separator[$i - 1]['separator']}\">>;\n";
    }
?>
get(_, _, _) -> false.