%% -----------------------------------------------------------------------------
%% 转生数据
%% @author linkeng
%% -----------------------------------------------------------------------------
-module(rein_data).

-export([
        get/1
    ]).

-include("rein.hrl").
-include("gain.hrl").

<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
?>
%% 称号数据
<?php
foreach($data as $v) {
    if ($v['id'] != '' || $v['id'] == '0') {
    $attr = attr_to_int($v['attr']);
	$reward = gen_record($v['reward']);
    echo <<<EOF
get(_Id = {$v['id']}) -> #rein_data{id = {$v['id']}, level = {$v['level']}, lv_max = {$v['lv_max']}, gongfa = {$v['gongfa']}, dujie = {$v['dujie']}, lingqi = {$v['lingqi']}, attr = [{$attr}], reward = {$reward}, open_id = [{$v['open_id']}], exp_max = {$v['exp_max']}};

EOF;
}}
?>
get(_) -> false.





