%%----------------------------------------------------
%% 场景配置
%% @author lsb
%%----------------------------------------------------

-module(scene_data).
-export([
        all/0
        ,get/1
    ]
).
-include("map.hrl").

<?php 
function gen_npc($data){
    $array = array();
    for($i = 2; $i < sizeof($data); $i++){
        $str = ",#npc_config{id = ".$data[$i]['id'].", radius = ".$data[$i]['radius'].", xpos = ".$data[$i]['posx'].", ypos = ".$data[$i]['posy']."}";
        $index = $data[$i]['index'];
        $array[$index] .= $str;
    }
    foreach($array as $k => $v){
        $array[$k] = substr($v, 1);
    }
    return $array;
}

function gen_trans($data){
    $array = array();
    for($i = 2; $i < sizeof($data); $i++){
        $str = ",#map_trans{id = ".$data[$i]['id'].", x = ".$data[$i]['posx'].", y = ".$data[$i]['posy'].", t_map_id = ".$data[$i]['sid'].", tx = ".$data[$i]['tx']. ", ty = ".$data[$i]['ty']."}";
        $index = $data[$i]['index'];
        $array[$index] .= $str;
    }
    foreach($array as $k => $v){
        $array[$k] = substr($v, 1);
    }
    return $array;
}
function gen_res($data) {
    if(file_exists(SRV_DATA_DIR)){
        $resource = array();
        for($i=2;$i<sizeof($data);$i++){
            $row = $data[$i];
            $res = "res({$row['id']}) -> map{$row['id']};\n";
            $grp = "group({$row['id']}) -> group{$row['id']};\n";
            $jump = "jump({$row['id']}) -> jump{$row['id']};\n";
            $resource[] = array($res, $grp, $jump);
        }
        $target_file = SRV_DATA_DIR."res.erl";
        ob_start();
        echo "%% -*- coding: latin-1 -*-\n";
        echo "-module(res).\n";
        echo "-export([res/1, group/1, jump/1]).\n\n";
        foreach($resource as $v){
            echo $v[0];
        }
        echo "res(_) -> false.\n";
        foreach($resource as $v){
            echo $v[1];
        }
        echo "group(_) -> false.\n";
        foreach($resource as $v){
            echo $v[2];
        }
        echo "jump(_) -> false.\n";
        $content = ob_get_contents();
        ob_end_clean();
        writeFile($target_file, $content);
    }
}
gen_res($xml_data[0]);
$npc = gen_npc($xml_data[3]);
$trans = gen_trans($xml_data[2]);
$allIds = array();
$table = $xml_data[0];
for($i=2;$i<sizeof($table);$i++){
	if ($table[$i]["id"] != ''){
        $row = $table[$i];
        $allIds[] = $row["id"]; 
?>
get(<?php echo $row['id'];?>) -> 
    #map_data{
        id = <?php echo $row['id']."\n";?>
        ,name = <<"<?php echo $row['name'];?>">><?php echo "\n";?>
        ,type = <?php echo $row['maptype']."\n";?>
        ,resid = <?php echo $row['resid']."\n";?>
        ,min_level = <?php echo $row['lowlevel']."\n";?>
        ,min_zhuanshu = <?php echo $row['low_zhuanshu']."\n";?>
        ,revive = [<?php echo $row['relivepoint'];?>]<?php echo "\n";?>
<?php if($row['limit_num']!='') {?>        ,limit_num = <?php echo $row['limit_num']."\n";?><?php }?>
<?php if($row['relive_hp']!='') {?>        ,relive_hp = <?php echo $row['relive_hp']."\n";?><?php }?>
        ,npc_list = [<?php echo $npc[$row['npc']];?>]
        ,trans_list = [<?php echo $trans[$row['exits']]; ?>]
        ,pk = <?php echo $row['pkflag']; ?><?php echo "\n";?>
        ,pkval = <?php echo $row['pkval']; ?><?php echo "\n";?>
        ,fly = <?php echo $row['is_shoes']; ?><?php echo "\n";?>
    };
<?php }}?>
get(_) -> false.

all() ->
    [<?php echo implode($allIds, ',')?>].
