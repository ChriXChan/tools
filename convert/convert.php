<?php
/**----------------------------------------------------+
 * 解析XML文件生成器
 * 读取XML文件，根据指定的模板文档，将XML中的数据结合模板转换为ERL文件
 * @author zhongkj@jieyou.cn
 +-----------------------------------------------------*/
//执行方法：php convert.php 数据类型
//例如：php convert.php map
//error_reporting(E_ALL ^E_NOTICE);
//define('ROOT',          str_replace('\\', '/', realpath(dirname(__FILE__))));
//define('DATA_DIR',      ROOT.'/../../doc/data/');
//define('SRV_DATA_DIR',      ROOT.'/../../server/src/data/');
//define('WEB_DATA_DIR',      ROOT.'/../../web/data/');
//define('GOP_DATA_DIR',      ROOT.'/../../gop/data/');
//define('TPL_DIR',       ROOT.'/tpl/');
//define('TARGET_DIR',    ROOT.'/target/');
//define('CLI_DATA_DIR',  ROOT.'/../../resources/assets/config/');
//define('ATTR_TARGET',   DATA_DIR.'attr_desc_data.xml');
$CLI_LAYOUT_DATA_ARR = array(CLI_DATA_DIR.'layout/CommPropertyItem.json', CLI_DATA_DIR.'layout/CommValueAddItem.json');

include "include/color_tools.php";
$attr_lable = require 'include/property.php';


if($argv[2] == 'run_tpl') {
	$input_file = trim($argv[1]);
	$tpl_file = trim($argv[3]);
    runtpl($input_file, $tpl_file);
}else if(isset($argv[2])) {
	$input_file = trim($argv[1]);
	$tpl_file = trim($argv[2]);
    c4tpl($input_file, $tpl_file);
}else if($argv[1] == 'language') {
    $input_file = trim($argv[1]);
    handleLanguage($input_file);
	handleRes();
}else if(isset($argv[1])) {
	$files = explode(',', trim($argv[1]));
    foreach($files as $input_file){
		if ($input_file != 'language')
			main($input_file);
	}
	handleLanguage("language");
	handleRes();
}else {
    handleLanguage("language");
    $files= getDir(DATA_DIR);
    foreach($files as $input_file){
        main($input_file);
    }
	handleRes();
}

// 指定模板生成文件
function c4tpl($input_file, $tpl) {
    $data_file = DATA_DIR.$input_file.".xml";    
    $tpl_file = TPL_DIR.$tpl.".tpl.php";    
    $target_file = SRV_DATA_DIR.$tpl.".erl";    
       
	if($data_file ==""){
        exit("Error：Data files is empty!\n");
    }
    if (!file_exists(realpath($data_file))){
        exit("Error：Data file does not exist!\n".$data_file."\n");
    }
    
    //获取Excel生成的XML文件的数据
    $arrData = rdExcel_XML(realpath($data_file));
    //转换服务端数据
    if (file_exists(realpath($tpl_file))){
        echo ">> Please wait,server data {$tpl_file_name} is converted...\n";
        //解析服务端模板
	    $potoServer = parseTemplate($tpl_file,$arrData);
        $potoServer = "%% -*- coding: latin-1 -*-\n" . $potoServer;
	    //写入文件保存服务端数据
	    writeFile($target_file, $potoServer);
	    echo ">> Convert server data {$tpl_file_name} is completed.\n";
    }	
}

// 执行tpl内容
function runtpl($input_file, $tpl){
    $data_file = DATA_DIR.$input_file.".xml";    
    $tpl_file = TPL_DIR.$tpl.".tpl.php";    
    $target_file = SRV_DATA_DIR.$tpl.".erl";    
	if($data_file ==""){
        exit("Error：Data files is empty!\n");
    }
    if (!file_exists(realpath($data_file))){
        exit("Error：Data file does not exist!\n".$data_file."\n");
    }
    //获取Excel生成的XML文件的数据
    $arrData = rdExcel_XML(realpath($data_file));
    //转换服务端数据
    if (file_exists(realpath($tpl_file))){
        echo ">> Please wait,server data {$tpl_file_name} is converted...\n";
	    parseTemplate($tpl_file,$arrData);	    
	    echo ">> Convert server data {$tpl_file_name} is completed.\n";
    }	
}

// 特殊处理语言包文件夹 by hkw
function handleLanguage($input_file) {
    $data_file = DATA_DIR.$input_file;
    $cli_tpl_file = TPL_DIR."language.clitpl.php";

    if (!file_exists(realpath($data_file))){
        exit(color_red("Error：Data file does not exist!\n\t".$data_file."\n"));
    }
    echo ">> Start convert ".color_green($input_file)." files\n";
    $filesnames = scandir($data_file);
    //导入语言包模板
    include $cli_tpl_file;
    //
    foreach ($filesnames as $name) {
        if(pathinfo($name, PATHINFO_EXTENSION) == "xml"){
            $trueFile = $data_file."/".$name; 
            $cli_target_file = CLI_DATA_DIR.$input_file."/".basename($trueFile,".xml").".json";

            //获取Excel生成的XML文件的数据
            $arrData = rdExcel_XML(realpath($trueFile));

            //写入文件保存客户端数据-语言包模板
            writeClientFile($cli_target_file, $arrData);

        }
    }

    $lang_str = mk_cli_lang(CLI_DATA_DIR . "language/");
    file_put_contents(CLI_DATA_DIR.'language.json', $lang_str);
    //$layout_str = mk_cli_layout(CLI_DATA_DIR . "layout/");
    //file_put_contents(CLI_DATA_DIR.'layout.json', $layout_str);
}

function main($input_file) {
    $data_file = DATA_DIR.$input_file.".xml";    
    $tpl_file = TPL_DIR.$input_file.".tpl.php";    
    $target_file = SRV_DATA_DIR.$input_file.".erl";    
    $cli_tpl_file = TPL_DIR.$input_file.".clitpl.php";
    $cli_target_file = CLI_DATA_DIR.$input_file.".json";
	$web_tpl_file = TPL_DIR.$input_file.".webtpl.php";  
	$web_target_file = WEB_DATA_DIR . $input_file .".php";
	$gop_tpl_file = TPL_DIR.$input_file.".goptpl.php"; 
	$gop_target_file = GOP_DATA_DIR . $input_file .".php";
       
	if($data_file ==""){
        exit("Error：Data files is empty!\n");
    }
    if (!file_exists(realpath($data_file))){
        exit("Error：Data file does not exist!\n".$data_file."\n");
    }
    
    //获取Excel生成的XML文件的数据
    $arrData = rdExcel_XML(realpath($data_file));
	
	//转换web数据
    if (file_exists(realpath($web_tpl_file)) && file_exists(WEB_DATA_DIR)){
        echo ">> Please wait, web data {$tpl_file_name} is converted...\n";
        //解析web模板
	    $potoClient = parseTemplate($web_tpl_file,$arrData);
	    //写入文件保存web数据
	    writeFile($web_target_file, $potoClient);
	    echo ">> Convert web data {$tpl_file_name} is completed.\n";
    }

	//转换gop数据
    if (file_exists(realpath($gop_tpl_file)) && file_exists(GOP_DATA_DIR)){
        echo ">> Please wait, gop data {$tpl_file_name} is converted...\n";
        //解析gop模板
	    $potoClient = parseTemplate($gop_tpl_file,$arrData);
	    //写入文件保存gop数据
	    writeFile($gop_target_file, $potoClient);
	    echo ">> Convert gop data {$tpl_file_name} is completed.\n";
    }		
	
    //转换服务端数据
    if (file_exists(realpath($tpl_file)) && file_exists(SRV_DATA_DIR)){
        echo ">> Please wait,server data {$tpl_file_name} is converted...\n";
        //解析服务端模板
	    $potoServer = parseTemplate($tpl_file,$arrData);
        $potoServer = "%% -*- coding: latin-1 -*-\n" . $potoServer;
	    //写入文件保存服务端数据
	    writeFile($target_file, $potoServer);
	    echo ">> Convert server data {$tpl_file_name} is completed.\n";
    }	
   	//转换客户端数据
    if (file_exists(realpath($cli_tpl_file)) && file_exists(CLI_DATA_DIR)) {

        // 打包客户端语言包文件 - 自己手动生成language
        //echo ">> Please wait,client make language data ...\n";
        //$lang_str = mk_cli_lang(CLI_DATA_DIR . "language/");
        //file_put_contents(CLI_DATA_DIR.'language.json', $lang_str);
        //$layout_str = mk_cli_layout(CLI_DATA_DIR . "layout/");
        //file_put_contents(CLI_DATA_DIR.'layout.json', $layout_str);

        echo ">> Please wait,client data ".color_green($input_file)." is converted...\n";
        //解析客户端模板
	    $potoClient = parseTemplate($cli_tpl_file,$arrData);	    
	    //写入文件保存客户端数据
        if($potoClient == "custom") {
            writeClientFile($cli_target_file, $arrData);
        }else{
            writeFile($cli_target_file, $potoClient);
        }
    }
    
    //转换web数据
    $tpl_file = TPL_DIR."php_".$tpl_file_name.".tpl.php";    
    if(file_exists(realpath($tpl_file))) {
        $target_file = TARGET_DIR.$target_file_name.".php";    
        echo ">> Please wait,web data {$tpl_file_name} is converted...\n";
        //解析服务端模板
        $potoServer = parseTemplate($tpl_file,$arrData);	    
        //写入文件保存服务端数据
        writeFile($target_file, $potoServer);
        echo ">> Convert web data {$tpl_file_name} is completed.\n";
    }
}

//压缩资源
function handleRes(){
    if(is_dir(CLI_DATA_DIR)){
        $cli_cfg_arr = array();
        $files = scandir(CLI_DATA_DIR);
        foreach($files as $file){
            $pathinfo = pathinfo($file);
            if(@$pathinfo['extension'] == 'json'){
                $contens = file_get_contents(CLI_DATA_DIR . $file);
                if(json_decode($contens)){
                    $file_size = filesize(CLI_DATA_DIR . $file);
                    $file_obj = array('name' => $pathinfo['filename'], 'size' => $file_size, 'data' => $contens);
                    $cli_cfg_arr[] = $file_obj;
                }else{
                    die("配置文件【" . CLI_DATA_DIR . $file. "】出错!");
                }
            }
        }
        
        global $CLI_LAYOUT_DATA_ARR;
        //print_r($CLI_LAYOUT_DATA_ARR);
        foreach($CLI_LAYOUT_DATA_ARR as $file){
            $pathinfo = pathinfo($file);
            $contens = file_get_contents($file);
            if(json_decode($contens)){
                    $file_size = filesize($file);
                    $file_obj = array('name' => $pathinfo['filename'], 'size' => $file_size, 'data' => $contens);
                    $cli_cfg_arr[] = $file_obj;
                }else{
                    die("配置文件【" . $file. "】出错!");
                }        
        }
    
        $cli_cfg_str = json_encode($cli_cfg_arr);
        // level5的压缩在性能和压缩比上都有很不错的表现
        $gz_contents = gzcompress($cli_cfg_str, 5);
        file_put_contents(CLI_DATA_DIR.'res.mpt', $gz_contents);
        echo ">>> Pack client data ".color_green("res.mpt")." is completed.\n";
    }
}

//读取Excel生成的XML文件，返回数组
//Excel生成的XML文件数据的我们需要的结构为：
//Worksheet->Table->Row->Cell->Data
function rdExcel_XML($data_file){	
    $doc = new DOMDocument('1.0', 'gb2312');
    $doc->load( $data_file );

    $worksheets = $doc->getElementsByTagName("Worksheet");
    $isheet = 0;
    foreach( $worksheets as $worksheet ){
        $worksheet_ssname = $worksheet->getAttribute('ss:Name');
        $start_ss_name = substr($worksheet_ssname, 0, 4);
        if($start_ss_name == "DATA"){
            $tables = $worksheet->getElementsByTagName("Table");
            foreach( $tables as $table )
            {
                $rows = $table->getElementsByTagName("Row");
                $irow = 0;
                $array_row = get_row_id($rows);
                $irows = $array_row[0];
                $itypes = $array_row[1];
                foreach($irows as $irows_index => $irows_val){// 处理字段数据类型，放在表数据数组第一个索引
                    $xml_data[$isheet][0][$irows_val.'_data_type'] = $itypes[$irows_index];
                }
                foreach( $rows as $row ){
                    $cells = $row->getElementsByTagName("Cell");
                    if(is_row_valid($cells)){//过滤空行
                        $icell = 0;
                        $icell_index = 0;
                        foreach( $cells as $cell ){
                            $icell = $irows[$icell_index];
                            $cell_ssindex = $cell->getAttribute('ss:Index');
                            if($cell_ssindex== ""){
                                $datas = $cell->getElementsByTagName("Data");
                                $data = $datas->item(0)->nodeValue;
                                $xml_data[$isheet][$irow][$icell]=fix_val($data); //将数据存储到3维数组里
                                //echo ">>$isheet $irow $icell $data<<\n";
                                ++$icell_index;
                            }else{
                                for($icell_index;$icell_index < $cell_ssindex;$icell_index++){
                                    if($icell_index != $cell_ssindex-1 ){
                                        $data = "";
                                    }else{
                                        $datas = $cell->getElementsByTagName( "Data" );
                                        $data = $datas->item(0)->nodeValue;
                                    }
                                    $icell = $irows[$icell_index];
                                    // echo ">>$isheet $irow $icell $data<<\n";
                                    $xml_data[$isheet][$irow][$icell]=fix_val($data);
                                }
                            }
                        }
                    }
                    ++$irow;
                }
            }
            ++$isheet;
        }
    }
    return $xml_data;
}

function is_row_valid($cells) {
    if($cells->length > 0){
        $first_cell = $cells->item(0);
        $first_datas = $first_cell->getElementsByTagName("Data");
        $fd = $first_datas->item(0)->nodeValue;
        return $fd != '' && $fd != '-';
    }else{
        return false;
    }
}
// 取整数值
function fix_val($val) {
    if(is_numeric($val))
        return (int)trim($val);
    else
        return trim($val);
}

/**
 * 打印指定变量的内容(用于调试)
 * @param mixd $var 变量名
 * @param string $label 标签名
 */
function dump($var, $label = null){
    $content .= print_r($var, true);
    echo $content;
}

// 解析标识行，获得标识
function get_row_id($rows){
    $cells = $rows->item(1)->getElementsByTagName("Cell");
    $icell = 0;
    $icell_offset=0;
    foreach( $cells as $cell ){
        $cell_ssindex = $cell->getAttribute('ss:Index');
        if($cell_ssindex== ""){
            $datas = $cell->getElementsByTagName("Data");
            $data = explode(":", $datas->item(0)->nodeValue);
            $rowsid[0][$icell]=trim($data[0]);
            $rowsid[1][$icell]=trim($data[1]);
            ++$icell;
        }else{
            for($icell;$icell < $cell_ssindex;$icell++){
                if($icell != $cell_ssindex-1 ){
                    $data = "";
                }else{
                    $datas = $cell->getElementsByTagName( "Data" );
                    $data = $datas->item(0)->nodeValue;
                }
                $data = explode(":", $data);
                $rowsid[0][$icell]=trim($data[0]);
                $rowsid[1][$icell]=trim($data[1]);
            }
        }
        //echo "\n";
    }
    return $rowsid;
}

//根据模板文件生成目标文件的内容
function parseTemplate($tpl_file, $xml_data, $count=0){
    ob_start();
    include $tpl_file;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

//写文件
function writeFile($target_file, $content, $mode='wb'){
    //file_put_contents($target_file, $content);
    if($content != ""){
        $oldMask= umask(0);
        $fp = @fopen($target_file, $mode);
        @fwrite($fp, $content);
        @fclose($fp);
        umask($oldMask);
    }
}

function pack_str($str){
    //如果是gbk,要转成utf8
    // $str = iconv('gbk','utf-8',$str);
    $utflen = strlen($str);
    if ($utflen > 65535) die('too long');
    $in .= pack('C2',$utflen>>8,$utflen>>0);
    return $in.$str;
}

//把类似于 0:固定 的数据取出0
function get_number($input){
    return substr($input, 0, strpos($input,":"));
}

//把类似于 0:固定 的字符取出
function get_string($input){
    return substr($input, strpos($input,":")+1);
}

// 判断是否为空行
// 如果一行的数据都为空行，即视为空行，否则为不空行
function is_line_empty($row_data) {
	for($i = 0; $i < sizeof($row_data); $i++){
        if($row_data[$i] != ""){
            return false;
        }
    }
    return true;
}

//检查列的数值是否为空
function check_num($number) {
	if ($number == "") return 0;
	else return $number;
}

//检查列的字符是否为空
function check_string($string) {
	if ($string == "") return '';
	else return $string;
}

//获取单元格中以换行分隔的元组数据组合为列表
function tupletolist($data){
	$arr_attr = explode("\n",$data);
    $output="";
    for($i = 0; $i < sizeof($arr_attr); $i++){
        if((trim($arr_attr[$i]))!=""){
        	$output .= $arr_attr[$i].',';
        }
    }
    $output = substr($output, 0, strlen($output)-1);
    return $output;
}

function attr_to_int($string){
    global $attr_lable;
    $lable = array();
    $int = array();
    foreach ($attr_lable as $k => $v)
    {
        $lable[] = $k;
        $int[] = $v;
    }

	if (!isset($lable) || !isset($int)){
		echo '策划-服务端-客户端 属性对应关系配置文件数据不存在，请检查后重试！';
		exit();
	}
	if (count($lable) != count($int)){
		echo '策划-服务端-客户端 属性对应关系配置文件数据不匹配，请检查后重试！';
		exit();
	}
    return str_replace($lable, $int, $string);
    //return preg_replace("/([a-z_]+)/", "?attr_\$1", $string);
}

function get_count($rows, $index){
    $count = 0;
    for($i = 2; $i< sizeof($rows); $i++){
        if($rows[$i][$index] != "")
            $count = $count + 1;
    }
    return $count;
}

//数据转换 hp_max->hpMax
function attrName_conver($str){
	$idx = strpos($str,"_");
	//echo '<'.$str;
	if($idx !== "")
	{
		do
		{
			$w = substr($str, $idx+1, 1);
			//echo 'w==='.$w.'|';
			$bw = strtoupper($w);
			//echo 'bw==='.$bw.'|';
			$str = str_replace('_'.$w,$bw,$str);
			//echo 'str==='.$str.'|';
			$idx = strpos($str,"_");
			//echo 'idx==='.$idx.'|';
		}
		while($idx === "");
	}
	$str = str_replace('anti_poison','antiPoison',$str);
	$str = str_replace('anti_silent','antiSilent',$str);
	$str = str_replace('anti_speed,','antiSpeed,',$str);
	$str = str_replace('anti_stone','antiStone',$str);
	$str = str_replace('anti_stun','antiStun',$str);
	//echo '>}}}}'.substr('{anti_silent,20}', 6, 1).'????????';
	//echo $str;
	return $str;
}

//{record_type, label, p1, p2, ...}
function gen_record($str){
    $list = explode("\n", $str);
    $record = "";
    foreach($list as $item){
        $item1 = substr(trim($item), 1, -1);
        preg_match_all("/\w+|\[+.*\]+|\{+.*\}+/i", $item1, $match);
        $match = $match[0];
        switch($match[0]){
        case "cond":
            if(isset($match[3]))
                $record .= "#condition{label = ". trim($match[1]). ", target = ". trim($match[2]). ", target_value = ". trim($match[3]). "}, ";
            else
                $record .= "#condition{label = ". trim($match[1]). ", target_value = ". trim($match[2]). "}, ";
            break;
        case "gain":
            $record .= "?GAIN(". trim($match[1]). ", ". trim($match[2]). "), ";
            break;
        case "loss":
            $record .= "?LOSS(". trim($match[1]). ", ". trim($match[2]). "), ";
            break;
        default:
            break;
        }
    }
    return "[". substr($record, 0, strlen($record) - 2). "]";
}

// 解析前端用记录
//{record_type, label, p1, p2, ...}
function gen_client_record($str){
    $list = explode("\n", $str);
    $record = array();
    foreach($list as $item){
        $item1 = substr(trim($item), 1, -1);
        preg_match_all("/\w+|\[+.*\]+|\{+.*\}+/i", $item1, $match);
        $match = $match[0];
        switch($match[0]){
        case "cond":
            if(isset($match[3]))
                $record[] = array("type" => "cond", "label" => trim($match[1]), "target" => trim($match[2]), "target_value" => trim($match[3]));
            else
                $record[] = array("type" => "cond", "label" => trim($match[1]), "target_value" => trim($match[2]));
            break;
        case "gain":
            if($match[1] == "item" || $match[1] == "item_notice_flag"){										
                $item = explode(",", trim(trim($match[2]), "{}"));
				$expire = 0;
				if(strstr($item[3], 'expire')){
					$expire = (int)trim($item[4]);
				};
                $record[] = array("type" => "gain", "label" => trim($match[1]), "base_id" => (int)$item[0], "bind" => (int)trim($item[1]), "num" => (int)trim($item[2]), "expire" => $expire);
            }else
                $record[] = array("type" => "gain", "label" => trim($match[1]), "num" => (int)trim($match[2]));
            break;
        case "loss":
            if($match[1] == "item" || $match[1] == "item_expire_first"){
                $item = explode(",", trim(trim($match[2]), "{}"));
                $record[] = array("type" => "loss", "label" => trim($match[1]), "base_id" => (int)$item[0], "bind" => (int)trim($item[1]), "num" => (int)trim($item[2]));
            }else
                $record[] = array("type" => "loss", "label" => trim($match[1]), "num" => (int)trim($match[2]));
            break;
        default:
            break;
        }
    }
    return $record;
}


// 对二维数组进行排序，根据第二维数据的key对应的值进行排序
function array_sort($arr, $key, $sort_type = SORT_ASC) {
    foreach ($arr as $k=>$v){
        $sort_fun[$k] = $v[$key];
    }
    array_multisort($sort_fun,$sort_type,$arr);
    return $arr;
}

// 生成Json数据
function buildJson($target_list, $xml) {
    $array = array();
    foreach($target_list as $arr){
        $array += buidJsonPer($xml, $arr);
    }
    echo pretty_json($array);
}

function buidJsonPer($xml, $arr){
    if(sizeof($arr) < 3){
        exit("脚本生成参数错误!!!!!!!!!!!!!!!\n");
    }

    if(sizeof($arr[2]) < 1){
        exit("脚本生成字段不能为空!!!!!!!!!!!\n");
    }
    $sub_xml_index = $arr[0];
    $sub_xml_index_key = $arr[1];
    $fields = $arr[2];
    $data = $xml[$sub_xml_index - 1];
    $array = get_array_by_index_key_field($data, $sub_xml_index_key, $fields);
    foreach($fields as $field_key => $field){
        if(is_array($field) && $field_key != 'CLI_FIELDS'){
            $array_field = buidJsonPer($xml, $field, true);
            foreach($array_field as $afk => $afv){
                foreach($array[$sub_xml_index_key] as $ark => $arv){
                    if(is_array(reset($arv))){
                        foreach($arv as $arvk => $arvv){
                            $index = $arvv[$field_key];
                            unset($array[$sub_xml_index_key][$ark][$arvk][$field_key]);
                            if(!empty($afv[$index]))
                                $array[$sub_xml_index_key][$ark][$arvk][$afk] = $afv[$index];
                            else
                                $array[$sub_xml_index_key][$ark][$arvk][$afk] = array();
                        }
                    }else {
                        $index = $arv[$field_key];
                        unset($array[$sub_xml_index_key][$ark][$field_key]);
                        if(!empty($afv[$index]))
                            $array[$sub_xml_index_key][$ark][$afk] = $afv[$index];
                        else
                            $array[$sub_xml_index_key][$ark][$afk] = array();
                    }
                }
            }
        }
    }
    return $array;
}

// 根据子表索引 字段 key字段取数据
function get_array_by_index_key_field($data, $sub_xml_index_key, $fields){
    $array = array();
    $array_tmp = array();
    $key_field = $fields[0];
    $key_field_data_type = data_type($data, $key_field);
    $key_sub_field = $fields[1];
    $fields = array_del($fields, $key_field);
	//CLI_FIELDS客户端指定字段
	$cli_fields = $fields['CLI_FIELDS'];
	if ($cli_fields) $fields = array_del($fields, $cli_fields);
	
    for($i = 2; $i < sizeof($data); $i ++) {
        $key_val = $data[$i][$key_field];
        if($key_val !== '' && ($cli_fields == null || array_in($cli_fields, $key_val))){
            $data1 = array();
            foreach ( $fields as $k => $field ) {
                if(is_array($field)) {
                    $data1[$k] = $data[$i][$k];
                }else if(is_record($data[$i][$field])) {
                    $data1[$field] = gen_client_record($data[$i][$field]);
                }else{
                    if(is_numeric($data[$i][$field])){
                        $data1[$field] = $data[$i][$field];
                    }else{
                        if(is_attr(trim($data[$i][$field]))){
                            $data1[$field] = gen_client_attr($data[$i][$field]);
                        } else {
                            if(trim($data[$i][$field]) != '')
                                $data1[$field] = $data[$i][$field];
                            else if(data_type($data, $field) == 'obj')
								$data1[$field] = array();
                            else if(data_type($data, $field) == 'int')
                                $data1[$field] = 0;
                            else
                                $data1[$field] = '';
                        }
                    }
                }
            }
            if(is_int($data1[$key_sub_field]) || is_string($data1[$key_sub_field]))
                $array_tmp[$key_val][$data1[$key_sub_field]] = $data1;
            else
                $array_tmp[$key_val][] = $data1;
        }
    }
    if($key_field_data_type == 'obj'){
        foreach($array_tmp as $k => $v)
            $array[$sub_xml_index_key][$k] = $v;
    }else {
        foreach($array_tmp as $k => $v)
            $array[$sub_xml_index_key][$k] = reset($v);
    }
    return $array;
}

function data_type($data, $field)
{
    return $data[0][$field.'_data_type'];
}

// 根据数组值删除数组元素，不保留索引
function array_del($array, $val) 
{
    $key = array_search($val, $array);
    if($key !== false && $key !== ""){
        //array_splice($array, $key, 1);
		unset($array[$key]);
    }
    return $array;
}

// 返回数组值是否在数组里面，或者匹配子串
function array_in($array, $val) 
{
    if(in_array($val, $array)){
		return true;
    }
	else
	{
		foreach($array as $k => $v){
			if(strstr($val, $v))
				return true;
		}
	}
    return false;
}

// 获取配置表xml文件
function getDir($dir) {
	$dirArray[]=NULL;
	if (false != ($handle = opendir ( $dir ))) {
		$i=0;
		while ( false !== ($file = readdir ( $handle )) ) {
			if (strpos($file,"_data.xml")) {
				$dirArray[$i]= $file; 
				$i++;
			}
		}
		closedir ( $handle );
	}
	return $dirArray;
}

function getIndexVal($v){
    $arr = explode("=", $v);
    return trim($arr[1]);
}

function encode_json($str){  
    $code = json_encode($str);	
	return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $code);	
	//return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2LE', 'UTF-8', pack('H4','\\1'))", $code);
}  

function pretty_json($arr, $cell = 1){  
    $str = "{\n";
    foreach($arr as $k => $v){
        $str .= json_space($cell)."\"".$k."\" : {\n";
        $str = pretty_json_sub($v, $str, $cell + 1);
        $str .= "\n".json_space($cell)."},\n";
    }
    if(endWith($str, ",\n")) {
        $str = lastReplace($str, ",\n", "");
    }
    return $str."\n}";
}

// 格式化子表
function pretty_json_sub($arr, $str, $cell = 1){
    foreach($arr as $k => $v){
        $str .= json_space($cell)."\"".$k."\" : {\n".json_space($cell+1);
        $str = pretty_json_row($v, $str, $cell + 1);
        $str .= "\n".json_space($cell)."},\n";
    }
    if(endWith($str, ",\n")) {
        $str = lastReplace($str, ",\n", "");
    }
    return $str;
}

// 格式化每一行
function pretty_json_row($arr, $str, $cell){
    foreach($arr as $k => $v){
        if(is_array($v)){
            $str .= "\"".$k."\" : {\n".json_space($cell+1);
            $str = pretty_json_columns($v, $str, $cell + 1);
            if(endWith($str, ",\n")) {
                $str = lastReplace($str, ",\n", "\n");
            }
            $str .= json_space($cell)."}, ";
        }else {
            $str = pretty_json_columns2($k, $v, $str, $cell + 1);
        }
    }
    if(endWith($str, ", ")) {
        $str = lastReplace($str, ", ", "");
    }
    return $str;
}

// 格式化每一列
function pretty_json_columns($arr, $str, $cell){
    foreach($arr as $k => $v){
        if(is_array($v)){
            $str .= "\"".$k."\" : {\n".json_space($cell+1);
            $str = pretty_json_columns($v, $str, $cell+1);
            if(endWith($str, ",\n")) {
                $str = lastReplace($str, ",\n", "\n");
            }
            $str .= json_space($cell)."}, ";
        }else{
            $str = pretty_json_columns2($k, $v, $str, $cell + 1);
        }
    }
    if(endWith($str, ", ")) {
        $str = lastReplace($str, ", ", ",\n");
    }
    return $str;
}
function pretty_json_columns2($k, $v, $str, $cell){
    if(is_numeric($v)){
        $str .= "\"".$k."\" : ".$v.", ";
    }else if($v == "-"){
        $str .= "\"".$k."\" : null, ";
    }else if($v[0] == "["){
        $str .= "\"".$k."\" : ".$v.", ";
    }else if(strpos($v, "\n") !== false){
        $str .= "\"".$k."\" : \"".str_replace("\n","<br>",$v)."\", ";
    }else{
        $str .= "\"".$k."\" : "."\"".$v."\", ";
    }
    return $str;
}

function json_space($cell = 1) {
    return str_repeat("\t", $cell);
}

function endWith($buf,$val)
{
	return substr($buf,strlen($buf)-strlen($val)) == $val;
}

function lastReplace($buf,$val,$rep)
{
	return substr($buf,0,strrpos($buf,$val)).$rep;
}

function is_attr($str){
    return preg_match("/^\{\s*([a-z_]+)/", $str) > 0;
}

function is_list($str){
    return 
        preg_match_all('/\{\d+\s*,\s*\d+\}/', $str, $fuckyou) > 1
        &&  
        preg_match("/^\{\s*([a-z_]+)/", $str) < 1;
}

function is_record($str) {
	//preg_match_all("/\w+|\[+.*\]+|\{+.*\}+/i", $str, $match);
    //$match = $match[0];
    //return $match[0] == "gain" || $match[0] == "loss" || $match[0] == "cond";
	return strstr($str, "gain") || strstr($str, "loss") || strstr($str, "cond");
}

function gen_client_attr($str){
    global $attr_lable;
    $arr = array();
    $arr_split = preg_split("/(\{)|(\s*\}\s*,\s*\{)|(\})/", $str, -1, PREG_SPLIT_NO_EMPTY);
    foreach($arr_split as $v) {
        $arr_explode = explode(",", $v);
        $label = trim($arr_explode[0]);
        $val = trim($arr_explode[1]);
        if(isset($attr_lable[$label])){
            $label_int = $attr_lable[$label];
        } else {
            $label_int = $label;
        }
        $arr[$label_int] = $val;
    }
    return $arr;
}

function mk_cli_lang($path){
    $lang = array();
    $files = scandir($path);
    foreach($files as $file){
        $pathinfo = pathinfo($file);
        if(@$pathinfo['extension'] == 'json'){
            //echo "pack language file:" . $file . "\n";
            $contens = file_get_contents($path . $file);
            $array = json_decode($contens, true);
            // $key =  substr(basename($file,".json"), 9);
            $key =  basename($file,".json");
            foreach($array as $k => $v){
                $lang[$key. '_' . $k] = $v;
            }
        }
    }
    $str = encode_json($lang);
    $str = "{\n" . substr($str,1);
    $str = substr($str,0,-1) . "\n}";
    $str = str_replace('",',"\",\n",$str);
    return $str;
}

function mk_cli_layout($path){
    $lang = array();
    $files = scandir($path);
    foreach($files as $file){
        $pathinfo = pathinfo($file);
        if(@$pathinfo['extension'] == 'json'){
            //echo "pack language file:" . $file . "\n";
            $contens = file_get_contents($path . $file);
            $array = json_decode($contens, true);
            // $key =  substr(basename($file,".json"), 7);
            $key =  basename($file,".json");
            $lang[$key] = $array;
        }
    }
    $str = encode_json($lang);
    $str = "{\n" . substr($str,1);
    $str = substr($str,0,-1) . "\n}";
    $str = str_replace('",',"\",\n",$str);
    return $str;
}

function trimall($str) {
    return str_replace(" ", "", $str);
}
