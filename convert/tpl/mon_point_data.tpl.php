%%----------------------------------------------------
%% 地图怪物点配置
%% @author lsb
%%----------------------------------------------------

-module(mon_point_data).
-export([
        get/1
    ]
).

<?php 
function gen_mon($data){
    $array = array();
    for($i = 2; $i < sizeof($data); $i++){
        $index = $data[$i]['monsterpoint'];
        $array[$index][] = $data[$i];
    }
    return $array;
}
$table = $xml_data[0];
$mon = gen_mon($xml_data[1]);
for($i=2;$i<sizeof($table);$i++){
	if ($table[$i]["id"] != ''){
        $row = $table[$i];
        $index = getIndexVal($row['index']);
        $mons = $mon[$index];
        $str = '';
        if(!empty($mons)){
            foreach($mons as $v){
                $str .= "\t\t,{".$v['mon_id'].", ".$v['resid'].", ".$v['posx'].", ".$v['posy'].", ".$v['dir']."}\n";
            }
?>
get(<?php echo $row['id'];?>) -> 
    [
<?php echo "\t\t".substr($str, 3);?>
    ];
<?php } } } ?>
get(_) -> [].

