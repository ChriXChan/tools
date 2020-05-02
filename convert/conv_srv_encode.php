<?php

define('SERVER_ROOT', "../../server/");
define('DIR_INC', SERVER_ROOT . 'include/');
define('DIR_SRC', SERVER_ROOT . 'src/');

main();

function main(){
    convert(DIR_INC);
    convert(DIR_SRC);
}

// 转换
function convert($dir){
    if ($handle = opendir($dir)) {
        while (false !== ($fileName = readdir($handle))) {
            if ($fileName != "." && $fileName != "..") {
                if(is_dir($dir . $fileName)){
                    convert($dir . $fileName . "/");
                }else{
                    do_file_head($dir . $fileName);
                }
            }
        }
    }
}

// 添加编码头部
function do_file_head($file_path){
    $contents = file($file_path);
    if(!strstr($contents[0], '%% -*- coding: latin-1 -*-')){
        array_unshift($contents, '%% -*- coding: latin-1 -*-' . "\n");
        file_put_contents($file_path, $contents);
    }
}