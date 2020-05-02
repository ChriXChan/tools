%% -----------------------------------------------------------------------------
%% 礼包卡数据
%% @author pb
%% -----------------------------------------------------------------------------
-module(card_data).

-export([
        get/2
    ]
).

-include("gain.hrl").
-include("card.hrl").

%%礼包卡配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get(<?php echo '_Type = '.$data[$i]['type'] ?>, <?php echo '_Batch = '.$data[$i]['batch'] ?>) ->
    #card_data{
        type = <?php echo $data[$i]['type'];?>, 
        batch = <?php echo $data[$i]['batch'];?>, 
        plats = <?php echo $data[$i]['plats'];?>, 
        srvid = <?php echo $data[$i]['srvid'];?>, 
        gains = <?php echo gen_record($data[$i]['gains']);?>, 
        count = <?php echo $data[$i]['count'];?>, 
        create_time = util_time:datetime_to_seconds(<?php echo $data[$i]['create_time'];?>),
        valid_time = util_time:datetime_to_seconds(<?php echo $data[$i]['valid_time'];?>)
    };
<?php 
}
?>
get(_,_) -> false.