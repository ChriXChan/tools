
<?php
    function get_npc_item_list($input) {
        $return_array = array();
        for ($i = 2; $i < sizeof($input); $i++) {
            $row = $input[$i];
            $npc_id = $row['id'];
            if($npc_id != ""){
            if ($return_array[$npc_id] == "") {
                $return_array[$npc_id][] = $row;
            } else {
                $return_array[$npc_id][] = $row;
            }}
        }
        return $return_array;
    }

    function get_npc_luck_item_list($input) {
        $return_array = array();
        for ($i = 2; $i < sizeof($input); $i++) {
            $row = $input[$i];
            $npc_id = $row['id'];
            $luck = $row['luck'];
            if($npc_id != "" && $luck == 1 ){
            if ($return_array[$npc_id] == "") {
                $return_array[$npc_id][] = $row;
            } else {
                $return_array[$npc_id][] = $row;
            }}
        }
        return $return_array;
    }

    function flat_normal_list($list) {
        $rtl = "[";
        for ($i = 0; $i < sizeof($list); $i++) {
            $row = $list[$i];
            $npc_id = $row['id'];
            $item_id = $row['item_id'];
            $domain = $row['domain'];
            $bind = $row['bind'];
            $notice = $row['notice'];
            $msg = "#drop_prob_normal{npc_id = ". $npc_id. ", item_id = ". $item_id. ", domain = ". $domain. ", bind = ". $bind. ", notice = ". $notice."}";
            if ($i == 0) {
                $rtl = $rtl.$msg;
            } else {
                $rtl = $rtl."\n, ".$msg;
            }
        }
        $rtl = $rtl."]";
        return $rtl;
    }

    function flat_super_list($list) {
        $rtl = "[";
        for ($i = 0; $i < sizeof($list); $i++) {
            $row = $list[$i];
            $npc_id = $row['id'];
            $item_id = $row['item_id'];
            $domain = $row['domain'];
            $upper_limit = $row['upper_limit'];
            $bind = $row['bind'];
            $notice = $row['notice'];
            $msg = "#drop_prob_super{npc_id = ". $npc_id. ", item_id = ". $item_id. ", domain = ". $domain. ", upper_limit = ". $upper_limit. ", bind = ". $bind. ", notice = ". $notice. "}";
            if ($i == 0) {
                $rtl = $rtl.$msg;
            } else {
                $rtl = $rtl."\n, ".$msg;
            }
        }
        $rtl = $rtl."]";
        return $rtl;
    }

    //
    function get_cumulate_super($input, $npcid){
        $output="";
        if($input != ""){
            $str_tmp = str_replace("{", "",$input);
            $str_tmp = str_replace("}", "",$str_tmp);
            $arr_attr = explode("\n",$str_tmp);    
            
            for($i = 0; $i < count($arr_attr); $i++){
                if((trim($arr_attr[$i]))!=""){
                    $arr_cond = explode(",",$arr_attr[$i]);                
                    $output_tmp = "";
                    $output_tmp = "#drop_prob_super{npc_id = ".$npcid.", item_id = ".trim($arr_cond[0]).", bind = ".trim($arr_cond[1]).", notice = ".trim($arr_cond[2])."}";               
                    if($i != 0){
                        $output_tmp ="                ,".$output_tmp;
                    }                
                    $output_tmp =$output_tmp."\n";
                    $output = $output.$output_tmp;
                }
            }
        }
        return $output;
    }

    $super_match = get_npc_item_list($xml_data[1]);
    $normal_match = get_npc_item_list($xml_data[2]);
    $super_luck_match = get_npc_luck_item_list($xml_data[1]);
?>
%%----------------------------------------------------
%% Author abu
%% Description: 掉落系统数据
%%----------------------------------------------------
-module(drop_activity_data).
-export([
        get_prob/1
        ,get_super_items/1
        ,get_normal_items/1
        ,get_super_items/2
        ,get_normal_items/2
        ,get_npc_luck/1
        ,get_npc_luck_prob/1
        ,get_luck_super_items/2
        ,get_cumulate/1
        ,get_daily_limit/1
    ]
).
-include("drop.hrl").
-include("gain.hrl").

%% @spec get_prob(NpcId) -> #drop_prob{} | false
%% NpcId = integer() 怪物ID
%% 获取掉落触发率基础信息
<?php
    for ($i = 2; $i < sizeof($xml_data[0]); $i++) {
        $row = $xml_data[0][$i];
        if($row['id'] != ""){
?>
get_prob(Id = <?php echo $row['id'] ?>) ->
    #drop_prob{npc_id = Id, super_prob = <?php echo check_num($row['super']) ?>, one_prob = <?php echo check_num($row['one']) ?>, two_prob = <?php echo check_num($row['two']) ?>, three_prob = <?php echo check_num($row['three']) ?>, four_prob = <?php echo check_num($row['four']) ?>, five_prob = <?php echo check_num($row['five']) ?>, six_prob = <?php echo check_num($row['six']) ?>, seven_prob = <?php echo check_num($row['seven']) ?>, eight_prob = <?php echo check_num($row['eight']) ?>, nine_prob = <?php echo check_num($row['nine']) ?>, ten_prob = <?php echo check_num($row['ten']) ?>, eleven_prob = <?php echo check_num($row['eleven']) ?>, twelve_prob = <?php echo check_num($row['twelve']) ?>};
<?php
    }}
?>
get_prob(_ItemId) ->
    false.


%% @spec get_super_items(NpcId) -> ItemList
%% NpcId = integer() 怪物ID
%% ItemList = [#drop_prob_super{} | ..]
%% 获取怪物ID对应的极品物品列表
<?php
    foreach($super_match as $npc_id=>$itemid_list) {
?>
get_super_items(<?php echo $npc_id ?>) ->
    <?php echo flat_super_list($itemid_list) ?>;
<?php
    }
?>
get_super_items(_NpcId) ->
    [].

%% @spec get_normal(NpcId) -> ItemList
%% NpcId = integer() 怪物ID
%% ItemList = [#drop_prob_normal{} | ..]
%% 获取怪物ID对应的普通物品列表
<?php
    foreach($normal_match as $npc_id=>$itemid_list) {
?>
get_normal_items(<?php echo $npc_id ?>) ->
    <?php echo flat_normal_list($itemid_list) ?>;
<?php
    }
?>
get_normal_items(_NpcId) ->
    [].

%% @spec get_super_items(NpcId, Random) -> Item | 0
%% NpcId = integer() 怪物ID
%% Random = integer() 概率
%% ItemList = #drop_prob_super{}
%% 获取怪物ID对应的极品物品列表
<?php
    foreach($super_match as $npc_id=>$list) {
    for ($i = 0, $x = 0; $i < sizeof($list); $i++) {
        $rtl = "";
        $row = $list[$i];
        $npc_id = $row['id'];
        $item_id = $row['item_id'];
        $domain = $row['domain'];
        $upper_limit = $row['upper_limit'];
        $bind = $row['bind'];
        $notice = $row['notice'];
        $msg = "#drop_prob_super{npc_id = ". $npc_id. ", item_id = ". $item_id. ", domain = ". $domain. ", upper_limit = ". $upper_limit. ", bind = ". $bind. ", notice = ". $notice. "}";
        $rtl = $rtl.$msg;
        $x = $x + $row['domain'];
        echo 'get_super_items('. $npc_id .' ,Random) when Random =< '.$x ." ->"."\n\t".$rtl.';'."\n";
    }
}
?>
get_super_items(_NpcId, _Random) ->
    0.

%% @spec get_normal_items(NpcId, Random) -> Item | 0
%% NpcId = integer() 怪物ID
%% Random = integer() 概率
%% ItemList = #drop_prob_normal{}
%% 获取怪物ID对应的普通物品列表
<?php
    foreach($normal_match as $npc_id=>$list) {
    for ($i = 0, $x = 0; $i < sizeof($list); $i++) {
        $rtl = "";
        $row = $list[$i];
        $npc_id = $row['id'];
        $item_id = $row['item_id'];
        $domain = $row['domain'];
        $bind = $row['bind'];
        $notice = $row['notice'];
        $msg = "#drop_prob_normal{npc_id = ". $npc_id. ", item_id = ". $item_id. ", domain = ". $domain. ", bind = ". $bind. ", notice = ". $notice. "}";
        $rtl = $rtl.$msg;
        $x = $x + $row['domain'];
        echo 'get_normal_items('. $npc_id .' ,Random) when Random =< '.$x ." ->"."\n\t".$rtl.';'."\n";
    }
}
?>
get_normal_items(_NpcId, _Random) ->
    0.

%% @spec get_npc_luck(NpcId) -> LuckBase | false
%% NpcId = integer() 怪物ID
%% LuckBase = #drop_npc_luck_base{}
%% 获取怪物幸运值配置
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_npc_luck(_NpcId = <?php echo $data[$i]['id']?>) ->
    #drop_npc_luck_base{id = <?php echo $data[$i]['id'];?>, max_luck = <?php echo $data[$i]['max_luck'];?>, min = <?php echo $data[$i]['min'];?>, max = <?php echo $data[$i]['max'];?>};
<?php 
}
?>
get_npc_luck(_) -> false.

%% @spec get_npc_luck_prob(NpcId) -> integer()
%% NpcId = integer() 怪物ID
%% 获取怪物幸运概率分母
<?php
    foreach($super_luck_match as $npc_id=>$list) {
        $x = 0;
        for ($i = 0; $i < sizeof($list); $i++) {
            $row = $list[$i];
            $x = $x + $row['domain'];
        }
        echo 'get_npc_luck_prob(_NpcId = '. $npc_id .") -> ".$x.';'."\n";
    }
?>
get_npc_luck_prob(_NpcId) -> 0.

%% @spec get_luck_super_items(NpcId, Random) -> Item | 0
%% NpcId = integer() 怪物ID
%% Random = integer() 概率
%% Item = #drop_prob_super{}
%% 获取怪物ID对应的极品幸运物品列表
<?php
    foreach($super_luck_match as $npc_id=>$list) {
    for ($i = 0, $x = 0; $i < sizeof($list); $i++) {
        $rtl = "";
        $row = $list[$i];
        $npc_id = $row['id'];
        $item_id = $row['item_id'];
        $domain = $row['domain'];
        $upper_limit = $row['upper_limit'];
        $bind = $row['bind'];
        $notice = $row['notice'];
        $msg = "#drop_prob_super{npc_id = ". $npc_id. ", item_id = ". $item_id. ", domain = ". $domain. ", upper_limit = ". $upper_limit. ", bind = ". $bind. ", notice = ". $notice. "}";
        $rtl = $rtl.$msg;
        $x = $x + $row['domain'];
        echo 'get_luck_super_items('. $npc_id .' ,Random) when Random =< '.$x ." ->"."\n\t".$rtl.';'."\n";
    }
}
?>
get_luck_super_items(_NpcId, _Random) ->
    0.

%%累积次数必掉配置
<?php
$data = $xml_data[4];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_cumulate(<?php echo '_MonId = '.$data[$i]['id'] ?>) -> 
    #drop_cumulate_base{id = <?php echo $data[$i]['id'];?>, count = <?php echo $data[$i]['count'];?>, 
        goods = [<?php echo get_cumulate_super($data[$i]['goods'], $data[$i]['id']);?>]};
<?php 
}
?>
get_cumulate(_) -> false.


%%玩家掉落每日上限配置
<?php
$data = $xml_data[5];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
?>
get_daily_limit(<?php echo '_Id = '.$data[$i]['id'] ?>) -> 
    #drop_daily_limit{id = <?php echo $data[$i]['id'];?>, count = <?php echo $data[$i]['count'];?>};
<?php 
}
?>
get_daily_limit(_) -> false.