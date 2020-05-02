<?php
/**----------------------------------------------------+
 * 海外版词典生成器
 * 将指定目录文件中的目标词汇导出，用于海外版翻译
+-----------------------------------------------------*/
//执行方法：php tr_cli.php 数据类型
//例如：php tr_cli.php (ch or en or kr ...)
error_reporting(E_ALL ^E_NOTICE);
define('ROOT',          str_replace('\\', '/', realpath(dirname(__FILE__))));
define('LANG_DIR',      "./lang/");
define('DIR_SRC',       'client/cymmo/src/');
define('DIR_RES',       'resources/assets/config/');
define('PREG_MATCH',     '/".*?"|\'.*?\'/');    // 词条正则

// 目标文件后缀
$tar_file_ext = array("as", "json");

// 需要排除的文件
$ignore_files = array(
    "filter_data.json",
    "sensitive_words.json",
    "tr_ch_data.json",
    "sensitive_words.json",
    "sensitive_words.json",
);

// 需要排除的目录
$ignore_dirs = array(
//    "client/cymmo/src/",
//    "resources/assets/config/",
//    "resources/assets/config/language/",
);

// ".*?" -> .*?
function mysubstr($words){
    return substr($words, 1, -1);
}

// 转换
function convert(){
    do_convert(CLIENT_ROOT, DIR_RES);
    do_convert(CLIENT_ROOT, DIR_SRC);
}

/**
// 词条转换成配置文件
function my_tr($dic) {
    global $input;
    $data = include LANG_CLI;
    $file_path = CLIENT_ROOT . DIR_RES . "tr_" . $input . "_data.json";
//    $file_path = LANG_DIR_TR . "/tr_" . $input . "_data.json";
    $fp = fopen($file_path, 'w+');
    fwrite($fp, "{\n");
    foreach($data as $words => $v){
        if ($dic[$words]){
            $line = "\"" . $words. "\":\"" .$dic[$words] . "\",\n";
            fwrite($fp, $line);
        }
    }
    fwrite($fp, "\"ok\":\"ok\"\n}");
    fclose($fp);
}
 * */

// 词条替换  ".*?" -> ".*?"
function do_trans($file_path){
    global $dic;
    $contents = file_get_contents($file_path);
    if (preg_match_all(PREG_MATCH, $contents, $matches)) {
        usort($matches[0], "my_sort");
        foreach ($matches[0] as $words) {
            $words = mysubstr($words);
            if (preg_match(REG_EX_CN, $words)) {
                if ($dic[$words]){
                    $contents = str_replace($words, $dic[$words], $contents, $i);
                }
            }
        }
        file_put_contents($file_path, $contents);
    }
}

// 译文语言包
function tr_page(){
    $cli_cfg_arr = array();
    $files = scandir(CLI_DATA_DIR);
    foreach($files as $file){
        $pathinfo = pathinfo($file);
        if(@$pathinfo['extension'] == 'json'){
            $contens = file_get_contents(CLI_DATA_DIR . $file);
            if(json_decode($contens)){
                $file_size = filesize(CLI_DATA_DIR . $file);
                $file_obj = array('name' => $pathinfo['basename'], 'size' => $file_size, 'data' => $contens);
                $cli_cfg_arr[] = $file_obj;
            }else{
                die("配置文件【" . CLI_DATA_DIR . $file. "】出错!");
            }
        }
    }

    $cli_cfg_str = json_encode($cli_cfg_arr);

    // level5的压缩在性能和压缩比上都有很不错的表现
    $gz_contents = gzcompress($cli_cfg_str, 9);
    file_put_contents(CLI_DATA_DIR.'res.mpt', $gz_contents);
}


if(isset($argv[1])) {
    $input = trim($argv[1]);
    define('LANG_DIR_TR',   LANG_DIR . $input);
    define('LANG_DIC',      LANG_DIR_TR . "/lang_cli.php");
    define('CLIENT_ROOT',   ROOT . "/../../oversea/". $input . "/");
    define('CLI_DATA_DIR',  CLIENT_ROOT . DIR_RES);
    require_once 'tr.php';
}else{
    echo "stax error. sh ctl.sh tr (cli or srv) kr";
}

?>