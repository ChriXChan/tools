<?php
/*
 * 客户端language文件夹
 * @author hkw
 */
function writeClientFile($target_file, $data, $mode='wb'){
    $oldMask  = umask(0);
    $i=0;
    $fileStr = "{\n";

    for($j=2; $j<count($data[$i]); $j++){
        //替换\n
        $data[$i][$j]['content'] = preg_replace('/\n/', "\\n", $data[$i][$j]['content']);
        //不能存在"号
		if(preg_match('/\"/', $data[$i][$j]['content'])){
			exit("Error：Data line[".$data[$i][$j]['id']."] has \" symbol...\n");
		}
		//写入
		$fileStr = $fileStr."\"".$data[$i][$j]['id']."\" : ";   //语言编号
		$fileStr = $fileStr."[\"".$data[$i][$j]['content']."\", ".intval($data[$i][$j]['show_pos'])."]"; //内容
		//换行 且 加,号
		if($j != count($data[$i]) - 1)
		{
			$fileStr = $fileStr.", \n";
		}
		else
		{
			$fileStr = $fileStr."\n";
		}
    }
    $fp = @fopen($target_file, $mode);
    $bin_data = $fileStr."}";
    fwrite($fp,$bin_data);
    fclose($fp);
    umask($oldMask);
}
//echo "custom";
?>
