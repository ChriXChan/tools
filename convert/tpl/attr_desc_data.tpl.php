%%----------------------------------------------------
%% attr数据
%% @author weihua
%%----------------------------------------------------
-module(attr_desc_data).
-export([
        get/1
        ,to_str/1
        ,label_to_integer/1
    ]
).

<?php 
$data = $xml_data[0];
array_shift($data);
array_shift($data);
?>
<?php
foreach($data as $v)
{
    echo "get({$v['number']}) -> {{$v['number']}, {$v['label']}};"."\n";
}
?>
get(_) -> undefined.

<?php
foreach($data as $v)
{
    echo "to_str({$v['number']}) -> <<\""."{$v['name']}"."\">>".";"."\n";
}
?>
to_str(_) -> <<>>.

<?php
foreach($data as $v)
{
    echo "label_to_integer({$v['label']}) -> {$v['number']};"."\n";
}
?>
label_to_integer(_) -> 0.
