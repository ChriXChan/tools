%% -----------------------------------------------------------------------------
%% 副本数据
%% @author lsb
%% -----------------------------------------------------------------------------
-module(dungeon_data).

-export([
        get/1
        ,get_event/2
        ,get_drop/2
        ,get_hookp/2
        ,get_coin_score/1
        ,get_score_rate/1
        ,label/1
        ,coin_mon_drop/1
        ,get_dun_cell/2
        ,get_dun_tower_title/1
        ,get_dun_tower_buff/1
        ,get_coin_mulmon/1
        ,get_cmul_dun_cell/2
        ,cmul_dun_cells/1
        ,cmul_duns/0
        ,cmul_time2star/3
        ,cmul_star_reward/2

        
        ,duns/0
        ,duns/1
        ,type/0
        ,type/1
        ,grow/1
        ,coin_scores/0
        ,pressure_dun_cond/1
        ,pressure_dun_award/1
        ,pressure_chap_ids/1
        ,pressure_chap_star_reward/2
        ,pressure_tili_vip_buy_times/1
        ,pressure_tili_buy_times_gold/1
    ]).

-include("gain.hrl").
-include("condition.hrl").
-include("dungeon.hrl").

%% 副本基础数据
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
$type = array();
$all_ids = array();
$type_ids = array();
$dun_type = array();
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $type[$row['type']][] = $row['id'];
    $dun_type[$row['id']] = $row['type'];
    $all_ids[] = $row['id'];
    $type_ids[] = "{".$row['id'].",".$row['type']."}";

    if ($row['type'] == '1')
    {
        $grows[ $row['type_sub'] ][ $row['grade'] ] = $row['id'];
    }
?>
get(<?php echo $row['id']?>) ->
    #dungeon_base{
        id = <?php echo $row['id'];?><?php echo "\n";?>
        ,type = <?php echo $row['type'];?><?php echo "\n";?>
        ,type_sub = <?php echo $row['type_sub'];?><?php echo "\n";?>
        ,grade = <?php echo $row['grade'];?><?php echo "\n";?>
        ,name = <<"<?php echo $row['name'];?>">><?php echo "\n";?>
        ,total_time = <?php echo $row['total_time'];?><?php echo "\n";?>
<?php if ($row['conds'] != '') {;?>        ,conds = <?php echo gen_record($row['conds']);?><?php echo "\n";?><?php }?>
<?php if ($row['maps'] != '') {;?>        ,maps = [<?php echo $row['maps'];?>]<?php echo "\n";?><?php }?>
<?php if ($row['enter_point'] != '') {;?>        ,enter_point = <?php echo $row['enter_point'];?><?php echo "\n";?><?php }?>
<?php if ($row['first'] != '') {;?>        ,first = <?php echo gen_record($row['first']);?><?php echo "\n";?><?php }?>
<?php if ($row['pass'] != '') {;?>        ,pass = <?php echo gen_record($row['pass']);?><?php echo "\n";?><?php }?>
<?php if ($row['mop_gold_loss'] != '') {;?>        ,mop_gold_loss = <?php echo gen_record($row['mop_gold_loss']);?><?php echo "\n";?><?php }?>
<?php if ($row['boss'] != '') {;?>        ,boss = [<?php echo $row['boss'];?>]<?php echo "\n";?><?php }?>
<?php if ($row['mon'] != '') {;?>        ,mon = [<?php echo $row['mon'];?>]<?php echo "\n";?><?php }?>
<?php if ($row['mon'] == '') {;?>        ,mon = [<?php echo $row['boss'];?>]<?php echo "\n";?><?php }?>
<?php if ($row['drop'] != '') {;?>        ,drop = <?php echo gen_record($row['drop']);?><?php echo "\n";?><?php }?>
<?php if ($row['box'] != '') {;?>        ,drop_box = <?php echo gen_record($row['box']);?><?php echo "\n";?><?php }?>
    };
<?php } ?>
get(_) -> 
    false.

%% 副本事件行为
<?php
$event = array();
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach ($data as $row){
    $event[$row['id']][$row['cell']] .= ",#dungeon_event{event = ".$row['event'].", act = ".$row['act']. ", dealy_time = " . $row['dealy_time'] . ", args = ".$row['args']."}\n\t";
}
    foreach($event as $k => $v){
        foreach($v as $k1 => $v1){
            ?>
get_event(<?php echo $k;?>, <?php echo $k1;?>) ->
    [
    <?php echo substr($v1, 1);?>
    ];
<?php }} ?>
get_event(_, _) ->
    [].


%% 副本掉落
<?php
$data = $xml_data[2];
array_shift($data);
array_shift($data);
$drop = array();
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
    $dun_ids = explode(",", str_replace(" ", "", $row['dun_id']));
    foreach($dun_ids as $dun_id){
        $drop[$dun_id][$row['type']][$row['group']][] = $row;
    }
}
foreach($drop as $k => $v){
    foreach($v as $k1 => $v1){
        $strf = '';
        foreach($v1 as $k3 => $v2){
            $str = '';
            foreach($v2 as $v3){
                $str .= ", "."{".$v3['base_id'].", ".$v3['bind'].", ".$v3['num'].", ".$v3['ratio'] . ", ".$v3['vip_ratio'] . "}";
            }
            $str = "{".$k3.", [".substr($str, 2)."]}";
            $strf .= ", ".$str;
        }
?>
get_drop(<?php echo $k?>, <?php echo $k1?>) -> [<?php echo substr($strf, 2)?>];
<?php }}?>
get_drop(_, _) -> [].

%% 副本挂机点
<?php
$data = $xml_data[3];
array_shift($data);
array_shift($data);
for ($i = 0; $i < count($data); $i++) {
    $row = $data[$i];
?>
get_hookp(<?php echo $row['id']?>, <?php echo $row['cell']?>) -> [<?php echo $row['point']?>];
<?php }?>
get_hookp(_, _) -> [].

%% 铜钱副本评分
<?php
$data = $xml_data[4];
$scores = array();
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    $scores[] = $row['score'];
?>
get_coin_score(<?php echo $row['score']?>) -> {<?php echo $row['min']?>,<?php echo $row['max']?>,<?php echo $row['rate']?>};
<?php }?>
get_coin_score(_Score) -> false.

<?php
for ($i = 2; $i < count($data); $i++) {
    echo "get_score_rate({$data[$i]['score']}) -> {$data[$i]['rate']};\n";
}
?>
get_score_rate(_) -> 0.

%% 副本标签
<?php
$data = $xml_data[5];
for ($i = 2; $i < count($data); $i++)
{
    $row = $data[$i];
    if ($row['label'] == 'coin_priv_item' or $row['label'] == 'pet_collect' or $row['label'] == 'pet_priv_item' or $row['label'] == 'coin_dun_pass_cond' or $row['label'] == 'genie_buffs' or $row['label'] == 'marry_collect' )
    {
        $result = '[' . $row['value'] . ']';
    }
    else if ($row['label'] == 'tower_back_reward' or $row['label'] == 'pet_dun_fail_award' or $row['label'] == 'marry_fail_reward' or $row['label'] == 'marry_buy_loss')
    {
        $result = gen_record($row['value']);
    }
    else
    {
        $result = $row['value'];
    }
?>
label(<?php echo $row['label']?>) -> <?php echo $result; ?>;
<?php } ?>
label(_Label) -> false.

%% 铜钱副本怪掉落
<?php
$data = $xml_data[6];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
?>
coin_mon_drop(<?php echo $row['id']?>) -> {<?php echo $row['min']?>,<?php echo $row['max']?>};
<?php }?>
coin_mon_drop(_MonId) -> false.

%% 爬塔副本
<?php
$data = $xml_data[7];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
?>
get_dun_cell(?dun_type_tower, <?php echo $row['cell'];?>) ->
    #dun_cell{
        cell = <?php echo $row['cell'];?><?php echo "\n";?>
        ,maps = [<?php echo $row['maps'];?>]<?php echo "\n";?>
        ,enter_point = <?php echo $row['enter_point'];?><?php echo "\n";?>
        ,first = <?php echo gen_record($row['first']);?><?php echo "\n";?>
        ,pass = <?php echo gen_record($row['pass']);?><?php echo "\n";?>
        ,mon = [<?php echo $row['mon'];?>]<?php echo "\n";?>
    };
<?php } ?>

%% 修罗洞副本
<?php
$data = $xml_data[16];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
?>
get_dun_cell(?dun_type_genie, <?php echo $row['cell'];?>) ->
    #dun_cell{
        cell = <?php echo $row['cell'];?><?php echo "\n";?>
        ,maps = [<?php echo $row['maps'];?>]<?php echo "\n";?>
        ,enter_point = <?php echo $row['enter_point'];?><?php echo "\n";?>
        ,pass = [<?php echo gen_record($row['pass']);?>, <?php echo gen_record($row['reward2']);?>, <?php echo gen_record($row['reward3']);?>]<?php echo "\n";?>
        ,mon = [<?php echo $row['mon'];?>]<?php echo "\n";?>
        ,time = <?php echo $row['time'];?><?php echo "\n";?>
        ,hp = <?php echo $row['hp'];?><?php echo "\n";?>
        ,boxbonus = <?php echo gen_record($row['boxbonus']);?><?php echo "\n";?>
        ,mon_buff = [<?php echo $row['buff'];?>]<?php echo "\n";?>
    };
<?php } ?>

get_dun_cell(_DunType, _Cell) ->
    false.
	

%% 爬塔副本称号
<?php
$data = $xml_data[7];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    if ((trim($row['title'])) != "" && $row['title'] != 0) {
        echo "get_dun_tower_title(" . $row['cell'] . ")-> " . $row['title'] . ";\n";
    }
}
?>
get_dun_tower_title(_) -> 0.

%% 爬塔副本buff
<?php
$data = $xml_data[7];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    if ((trim($row['buff'])) != "" && $row['buff'] != 0) {
        echo "get_dun_tower_buff(" . $row['cell'] . ")-> " . $row['buff'] . ";\n";
    }
}
?>
get_dun_tower_buff(_) -> 0.

%% 铜钱副本多倍怪
<?php
$data = $xml_data[8];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
?>
get_coin_mulmon(_MonBaseId = <?php echo $row['id']?>) -> [<?php echo $row['mul'];?>];
<?php }?>
get_coin_mulmon(_MonBaseId) -> false.

%% 跨服多人副本关数
<?php
$cmul_dun_cells = array();
$cmul_duns = array();

$data = $xml_data[9];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];

    $cmul_dun_cells[ $row['id'] ][] = $row['cell'];
    $cmul_duns[ $row['id'] ] = $row['id'];
?>
get_cmul_dun_cell(<?php echo $row['id'];?>, <?php echo $row['cell'];?>) -> 
    #dun_cell{
        cell = <?php echo $row['cell'];?><?php echo "\n";?>
        ,mon = [<?php echo $row['mon'];?>]<?php echo "\n";?>
        ,enter_point = <?php echo $row['enter_point'];?><?php echo "\n";?>
        ,first = <?php echo gen_record($row['first']);?><?php echo "\n";?>
        ,maps = [<?php echo $row['maps'];?>]<?php echo "\n";?>
    };
<?php }?>
get_cmul_dun_cell(_, _) ->
    false.

<?php foreach ($cmul_dun_cells as $dun_id => $cells) { ?>
cmul_dun_cells(_DunId = <?php echo $dun_id ?>) -> [<?php echo implode(',', $cells) ?>];
<?php } ?>
cmul_dun_cells(_DunId) -> false.

cmul_duns() -> [<?php echo implode(',', $cmul_duns) ?>].


%% 跨服多人副本评星
<?php
$data = $xml_data[10];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    $time1 = $row['one_time'];
    $time2 = $row['two_time'];
    $time3 = $row['three_time'];
    $cell = $row['cell'];
    $dunid = $row['id'];
    echo "cmul_time2star(".$dunid.", ".$cell.", Time) when Time =< ".$time3."-> 3".";\n";
    echo "cmul_time2star(".$dunid.", ".$cell.", Time) when Time =< ".$time2."-> 2".";\n";
    echo "cmul_time2star(".$dunid.", ".$cell.", Time) when Time =< ".$time1."-> 1".";\n";
?>
<?php }?>
cmul_time2star(_DunId, _Cell, _Time) -> 1.

%% 跨服多人副本星级奖励
<?php
$data = $xml_data[11];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
?>
cmul_star_reward(_DunId = <?php echo $row['id']?>, _Star = <?php echo $row['star']?>) -> <?php echo gen_record($row['gain'])?>;
<?php }?>
cmul_star_reward(_DunId, _Star) -> false.


duns() -> [<?php echo implode(",", $all_ids);?>].
<?php
foreach($type as $k => $v){
?>
duns(<?php echo $k;?>) -> [<?php echo implode(",", $v);?>];
<?php }?>
duns(_) -> [].

type() -> [<?php echo implode(",", $type_ids);?>].
<?php
foreach($dun_type as $k => $v){
?>
type(<?php echo $k;?>) -> <?php echo $v?>;
<?php }?>
type(_) -> 0.

<?php
foreach ($grows as $key => $value) {
    ksort($value);
?>
grow(_GrowType = <?php echo $key; ?>) -> [<?php echo implode(",", $value);?>];
<?php } ?>
grow(_GrowType) -> [].

coin_scores() -> [<?php echo implode(",", $scores);?>].

%% 压力副本星星条件
<?php
$data = $xml_data[12];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    ?>
pressure_dun_cond(<?php echo $row['id']?>) -> {<?php echo $row['time']?>,<?php echo $row['hp']?>};
<?php }?>
pressure_dun_cond(_) -> [].


%% 压力副本奖励
<?php
$pressure_chap_ids = array();

$data = $xml_data[12];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
    $pressure_chap_ids[ $row['chapter'] ][] = $row['id'];
?>
pressure_dun_award(<?php echo $row['id']?>) -> [<?php echo gen_record($row['gain1'])?>,<?php echo gen_record($row['gain2'])?>,<?php echo gen_record($row['gain3'])?>];
<?php } ?>
pressure_dun_award(_) -> [].

<?php foreach ($pressure_chap_ids as $chapId => $dunIds) { ?>
pressure_chap_ids(_ChapId = <?php echo $chapId ?>) -> [<?php echo implode(',', $dunIds); ?>];
<?php } ?>
pressure_chap_ids(_ChapId) -> [].


%% 压力副本章节星级奖励
<?php
$data = $xml_data[13];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
?>
pressure_chap_star_reward(<?php echo $row['chapter']?>, <?php echo $row['star']?>) -> <?php echo gen_record($row['gain'])?>;
<?php } ?>
pressure_chap_star_reward(_Chapter, _Star) -> false.


%% 压力副本vip体力购买次数
<?php
$data = $xml_data[14];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
?>
pressure_tili_vip_buy_times(_VipLv = <?php echo $row['level']?>) -> <?php echo $row['times'] ?>;
<?php } ?>
pressure_tili_vip_buy_times(_VipLv) -> 0.


%% 压力副本次数消耗元宝
<?php
$data = $xml_data[15];
for ($i = 2; $i < count($data); $i++) {
    $row = $data[$i];
?>
pressure_tili_buy_times_gold(_Times = <?php echo $row['times'] ?>) -> <?php echo gen_record($row['gold']) ?>;
<?php } ?>
pressure_tili_buy_times_gold(_Times) -> false.
