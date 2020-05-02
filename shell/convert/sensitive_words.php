<?php

header("Content-type:text/html;charset=utf-8");

define("CLIENT_FILE", "sensitive_words.json");
define("SERVER_FILE", "sensitive_words_data.erl");

main();

function main(){
    $contents = file("sensitive_words.txt");
	$str = merge_str($contents);

    $array = explode(',', $str);
	$array = check_words($array);
	print_r($array);
    make_cli_data($array);
    make_server_data($array);
}

function check_words($array){
	$ret = array();
	foreach($array as $v){
		$v = trim($v);
		if($v == "") continue;
		$ret[] = $v;
	}
	return $ret;
}

function merge_str($array){
	$str = "";
	for($i = 0; $i < count($array) - 1; $i++){
		
		$str .= trim($array[$i]) . ",";
	}
	$str .= $array[$i];
	return $str;
}


function make_cli_data($array) {
    $contents =  "{\"list\":\n[\"" . implode("\",\n\"", $array) . "\"" . "\n]}";
    file_put_contents(CLIENT_FILE, $contents);
}


function trim_flag($array) {
    $arr_new = array();
    $flags = array(".", "(", ")", "|", "?", "*");
    $new_flags = array('\\\.', '\\\(', '\\\)', '\\\|', '\\\?', '\\\*');
    foreach($array as $v){
        $arr_new[] = str_replace($flags, $new_flags, $v);
    }
    return $arr_new;
}

function make_server_data($array) {
    $array = trim_flag($array);
    $head = "%% -*- coding: latin-1 -*-
%% -----------------------------------------------------------------------------
%% @author luoxueqing
%% @doc 文化部敏感词库
%% -----------------------------------------------------------------------------
-module(sensitive_words_data).
-export([get/0]).
get() ->
    [
";
    $str = $head . "\t\"" . implode("\",\n\t\"", $array) . "\"" . "\n].";
    file_put_contents(SERVER_FILE, $str);
}

function unicode2utf8($str){
    if(!$str) return $str;
    $decode = json_decode($str);
    if($decode) return $decode;
    $str = '["' . $str . '"]';
    $decode = json_decode($str);
    if(count($decode) == 1){
        return $decode[0];
    }
    return $str;
}