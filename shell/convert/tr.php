<?php
/**----------------------------------------------------+
 * 海外版词典生成器
 * 将指定目录文件中的目标词汇导出，用于海外版翻译
+-----------------------------------------------------*/
define('REG_EX_CN',     "/[\x7f-\xff]+/"); // 汉字正则
define('LANG_IGNORE',   LANG_DIR ."/ch/lang_ignore.php");
define('LANG_ADD',      LANG_DIR_TR ."/lang_add");
define('LANG_TRANS',    LANG_DIR_TR ."/lang_add.php");
define('LANG_PHP',      LANG_DIR_TR ."/lang.php");
define('LANG_SRV',      LANG_DIR_TR ."/lang_srv.php");
define('LANG_CLI',      LANG_DIR_TR ."/lang_cli.php");

$dic_add = array();
$add_tr = array();

$dic = include LANG_PHP;
$ignore = include LANG_IGNORE;

$add_back = file(LANG_TRANS);
if (!strstr($add_back[0], '<?php return array (')) {
    $add_back = file_get_contents(LANG_TRANS);
    file_put_contents(LANG_TRANS, '<?php return array (' . "\n" . $add_back . "\n);");
    $add_tr = include_once LANG_TRANS;
    foreach ($add_tr as $ch => $tr){
        $dic[$ch] = $tr;
    }
    file_put_contents(LANG_PHP, '<?php return ' . var_export($dic, true) . ";");
}

function do_convert($baseDir, $dir){
    global $tar_file_ext;
    global $ignore_dirs;
    global $ignore_files;
    if(!in_array($dir, $ignore_dirs)) {
        if ($handle = opendir($baseDir . $dir)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && $file != ".svn" && $file != ".git") {
                    if (is_dir($baseDir . $dir . $file)) {
                        do_convert($baseDir, $dir . $file . "/");
                    } elseif (!in_array($file, $ignore_files) && in_array(pathinfo($file, PATHINFO_EXTENSION), $tar_file_ext)) {
                        do_trans($baseDir . $dir . $file);
                        do_localize($baseDir . $dir . $file);
                    }
                }
            }
        }
    }
}

// 本地化处理
function do_localize($file_path){
    global $dic;
    global $ignore;
    global $dic_add;
    $contents = file_get_contents($file_path);
    if (preg_match_all(PREG_MATCH, $contents, $matches)) {
        foreach ($matches[0] as $words) {
            $words = mysubstr($words);
            if (preg_match(REG_EX_CN, $words)) {
                if (!array_key_exists($words,$ignore)){
                    if (!array_key_exists($words, $dic) && !in_array($words, $dic)) {
                        echo realpath($file_path) . " 【新增词条】：" . $words . "\n";
                        $dic[$words] = "";
                    }
                    $dic_add[$words] = "";
                }
            }
        }
    }
}


// 存新增词条
function save_add()
{
    global $dic;
    global $dic_add;
    $fp = fopen(LANG_ADD . "_" . date("Y-m-d"). ".txt", 'w+');
    foreach($dic as $words => $v){
        if (!$v){
            $line = $words."\n";
            fwrite($fp, $line);
        }
    }
    fclose($fp);
    file_put_contents(LANG_PHP, '<?php return ' . var_export($dic, true) . ";");
    file_put_contents(LANG_DIC, '<?php return ' . var_export($dic_add, true) . ";");
}

// 长度排序
function my_sort($a,$b)
{
    return (strlen($a) >= strlen($b))?-1:1;
}

// 主函数
function main(){
    echo "1/3 ：导出新增词条 \n";
    convert();
    echo "2/3 ：更新词典 \n";
    save_add();
    echo "3/3 ：译文打包 \n";
    tr_page();
    echo "翻译完成 \n";
}

main();

?>