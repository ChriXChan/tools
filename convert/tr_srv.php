<?php
/**----------------------------------------------------+
 * 海外版词典生成器
 * 将指定目录文件中的目标词汇导出，用于海外版翻译
+-----------------------------------------------------*/
//执行方法：php tr_srv.php 数据类型
//例如：php tr_srv.php (ch or en or kr ...)
error_reporting(E_ALL ^E_NOTICE);
define('ROOT',          str_replace('\\', '/', realpath(dirname(__FILE__))));

define('SERVER_ROOT',   ROOT . "/../../server/");
define('LANG_DIR',     "./lang/");
define('DIR_INC',       'include/');
define('DIR_SRC',       'src/');
define('PREG_MATCH',    '/<<".*?">>/');    // 词条正则

// 目标文件后缀
$tar_file_ext = array("erl", "hrl");

// 需要排除的文件
$ignore_files = array(
    "user_default.erl",
    "role_adm_rpc.erl",
    "adm_stat_cfg.erl",
    "rpc_conf.hrl",
);

// 需要排除的目录
$ignore_dirs = array(
//    "include/",
//    "src/",
//    "src/sys/",
//    "src/mod/",
//    "src/data/",
    "src/lib/",
    "src/test/",
    "src/proto/",
    "src/merge/",
);


// <<".*?">> -> .*?
function mysubstr($words){
    return substr($words, 3, -3);
}

// 替换 <<".*?">> -> ?LANG(<<".*?">>)
function mysearch($words){
    return "lang:tr(" . $words . ")";
}

// 转换
function convert(){
//    do_convert(SERVER_ROOT, 'tr_test/');
    do_convert(SERVER_ROOT, DIR_INC);
    do_convert(SERVER_ROOT, DIR_SRC);
}

// 替换 <<".*?">> -> lang:tr(<<".*?">>)
function do_trans($file_path){
    $contents = file_get_contents($file_path);
    if (preg_match_all(PREG_MATCH, $contents, $matches)) {
        foreach ($matches[0] as $words) {
            if (preg_match(REG_EX_CN, $words)) {
                $search = mysearch($words);
                $contents = str_replace($search, $words, $contents, $i);
                $contents = str_replace($words, $search, $contents, $i);
            }
        }
        file_put_contents($file_path, $contents);
    }
}

// 译文语言包
function tr_page() {
    global $input;
    $data = include LANG_SRV;
    $dic = include LANG_PHP;

    $file_path = SERVER_ROOT . DIR_SRC . "lib/tr_" . $input . "_data.erl";
//    $file_path = LANG_DIR_TR . "/tr_" . $input . "_data.erl";
    $fp = fopen($file_path, 'w+');
    $h = "%% -*- coding: latin-1 -*-
%%----------------------------------------------------
%% 海外版译文数据
%% @author tanwer
%%----------------------------------------------------
-module(tr_" . $input . "_data).
-export([ get/1 ]).\n";
    fwrite($fp, $h);
    foreach($data as $words => $v){
        if ($dic[$words]){
            $line = "get(<<\"" . $words. "\">>) -> <<\"" .$dic[$words] . "\">>;\n";
            fwrite($fp, $line);
        }
    }
    $l = "get(Bin) -> Bin.";
    fwrite($fp, $l);
    fclose($fp);
}

if(isset($argv[1])) {
    $input = trim($argv[1]);
    define('LANG_DIR_TR',   LANG_DIR . $input);
    define('LANG_DIC',      LANG_DIR_TR . "/lang_srv.php");
    require_once 'tr.php';
}else{
    echo "stax error. sh ctl.sh tr (cli or srv) kr";
}

?>