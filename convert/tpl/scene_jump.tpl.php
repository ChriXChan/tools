<?php
//场景跳跃点配置scene_data
//author lsb
function pkey($x, $y){
    return "get(".$x.",".$y.")";
}
function akey($f, $t){
    return $f."|".$t;
}
function arrcb($v, $k){
    global $grp;
    $flag = preg_match("/^(get\(\d+,\d+\))\s*->\s*(\d+);$/", $v, $match);
    if($flag){
        //var_dump($match[1]."   ".$match[2]);
        $grp[$match[1]] = $match[2];

    }
}
function get_data($arr){
    $data = array();
    $t2 = $arr[6];
    for($i=2;$i<sizeof($t2);$i++){
        $row = $t2[$i];
        $x1 = floor($row['x1']/40); $y1 = floor($row['y1']/40);
        $x2 = floor($row['x2']/40); $y2 = floor($row['y2']/40);
        $data[$row['index']][] = array($x1, $y1, $x2, $y2);
        $data[$row['index']][] = array($x2, $y2, $x1, $y1);
    }
    return $data;
}

function get_data2($arr){
    $data = array();
    $t2 = $arr[5];
    for($i=2;$i<sizeof($t2);$i++){
        $row = $t2[$i];
        $x1 = $row['posx']; $y1 = $row['posy'];
        $x2 = $row['tx']; $y2 = $row['ty'];
        $data[$row['index']][akey($x1, $y1)] = array($x2, $y2);
    }
    return $data;
}

function get_task_jump_str($tj, $key, $str = ""){
    $a = $tj[$key];
    $str .= ",{".$a[0].",".$a[1]."}";
    $key1 = akey($a[0], $a[1]);
    if(isset($tj[$key1])){
        return get_task_jump_str($tj, $key1, $str);
    }else{
        return "[".substr($str, 1)."]";
    }
}

function gen_path($areajump, $grp, $i, $j, $rtn = array()){
    $all = array();
    if(!array_key_exists($i, $rtn)){
        if(isset($areajump[$i])){
            $points = $areajump[$i];
            foreach($points as $p){
                if($p[4] == $j){
                    $rtn[$i] = $p;
                    return $rtn;
                }
            }
            foreach($points as $p){
                $rtn[$i] = $p;
                $res = gen_path($areajump, $grp, $p[4], $j, $rtn);
                if($res != false){
                    return $res;
                }
            }
        }
    }
    return false;
}
//所有地图跳跃点
$data = get_data($xml_data);
$taskjump = get_data2($xml_data);
foreach($xml_data[0] as $maprow){
    $map = $maprow['id'];
    if($map <= 1110){
        $file = SRV_DATA_DIR."group".$map.".erl";
        $target_file = SRV_DATA_DIR."jump".$map.".erl";
        $module = "jump".$map;
        $dataget = array(); // 跳跃点到目标点列表
        $areajump = array(); // 区域跳跃点列表
        $points = array();
        if(file_exists($file)){
            if(isset($data[$map]))
                $points = $data[$map];
            $contents = file($file);
            global $grp;
            array_walk($contents, "arrcb");
            $maxgrp = max($grp);
            $mingrp = min($grp);
            foreach($points as $p){
                $area_from = (int)$grp[pkey($p[0], $p[1])];
                $area_to = (int)$grp[pkey($p[2], $p[3])];
                if(!is_numeric($area_from) || $area_from == 0)
                    exit("map($map)jump point($p[0], $p[1]) has not mapping in group data !!!");
                if(!is_numeric($area_to) || $area_from == 0)
                    exit("map($map)jump point($p[2], $p[3]) has not mapping in group data !!!");
                $dataget[akey($p[0], $p[1])][] = "{".$p[2].",".$p[3]."}";
                $areajump[$area_from][] = array($p[0], $p[1], $p[2], $p[3], $area_to);
            }
            ob_start();
            echo "%% -*- coding: latin-1 -*-\n";
            echo "-module($module).\n";
            echo "-export([get/2]).\n";
            echo "-export([task_jump/2]).\n";
            echo "-export([get_path/2]).\n\n";

            echo "%% 获取跳跃目标点\n";
            foreach($dataget as $k => $v){
                $k = explode("|", $k);
                $v = implode(",", $v);
                echo "get($k[0], $k[1]) -> [$v];\n";
            }
            echo "get(_, _) -> false.\n";
            echo "%% 获取场景跳跃点\n";
            $datatj = $taskjump[$map];
            if(isset($datatj)){
                foreach($datatj as $k1 => $v){
                    $k = explode("|", $k1);
                    $v = get_task_jump_str($datatj, $k1);
                    echo "task_jump($k[0], $k[1]) -> $v;\n";
                }
            }
            echo "task_jump(_, _) -> false.\n";
            echo "%% 获取不连通区域路线\n";
            global $test;
            for($i=$mingrp;$i<=$maxgrp;$i++){
                for($j=$mingrp;$j<=$maxgrp;$j++){
                    if($i != $j){
                        $path = gen_path($areajump, $grp, $i, $j);
                        if($path != false){
                            $str = "";
                            foreach($path as $area => $pt){
                                $str .= ",{jump,{".$pt[0].",".$pt[1]."},{".$pt[2].",".$pt[3]."},$area,".$pt[4]."}";
                                $next = $path[$pt[4]];
                                if(isset($next)){
                                    if($pt[2] != $next[0] || $pt[3] != $next[1])
                                        $str .= ",{move,{".$pt[2].",".$pt[3]."},{".$next[0].",".$next[1]."},".$pt[4].",".$pt[4]."}";
                                }
                            }
                            $str = substr($str, 1);
                            echo "get_path($i, $j) -> [$str];\n";
                        }
                    }
                }
            }
            echo "get_path(_, _) -> false.\n";
            $content = ob_get_contents();
            ob_end_clean();
            writeFile($target_file, $content);
        }
    }
}
?>
