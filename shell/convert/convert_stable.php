<?php
/**----------------------------------------------------+
 * 解析XML文件生成器
 * 读取XML文件，根据指定的模板文档，将XML中的数据结合模板转换为ERL文件
 * @author zhongkj@jieyou.cn
 +-----------------------------------------------------*/
//执行方法：php convert.php 数据类型
//例如：php convert.php map
error_reporting(E_ALL ^E_NOTICE);
define('ROOT',          str_replace('\\', '/', realpath(dirname(__FILE__))));
define('DATA_DIR',      ROOT.'/../../doc/data_stable/');
define('SRV_DATA_DIR',      ROOT.'/../../server/src/data/');
define('WEB_DATA_DIR',      ROOT.'/../../web/data/');
define('LOGIN_DATA_DIR',      ROOT.'/../../zk_login/data/');
define('TPL_DIR',       ROOT.'/tpl/');
define('TARGET_DIR',    ROOT.'/target/');
define('CLI_DATA_DIR',  ROOT.'/../../resources/assets/config/');
define('ATTR_TARGET',   DATA_DIR.'attr_desc_data.xml');
require_once 'convert.php';
