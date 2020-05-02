<?php
/*
 * 客户端talk_data数据
 * @author chris
 */
function writeClientFile($target_file, $data, $mode='wb'){
    $oldMask  = umask(0);
    $fileinfo = pathinfo($target_file);
	$nameArr = explode("_", $fileinfo['basename']);
    $target_file = $fileinfo['dirname']."/language/language_".$nameArr[0].".".$fileinfo['extension'];
	//echo $target_file;
    $fp       = @fopen($target_file, $mode);
    $i=0;
    $fileStr = "{"."\n";
	//echo "--------------------";
    for($j=2;$j<count($data[$i]);$j++){
        if ($data[$i][$j]['id'] != "") {
            $fileStr = $fileStr."\"".$data[$i][$j]['id']."\" : ";    //编号
            $fileStr = $fileStr."\"".$data[$i][$j]['content']."\""; //资源
			if($j != count($data[$i]) - 1)
			{
				$fileStr = $fileStr.", \n";
			}
			else
			{
				$fileStr = $fileStr."\n";
			}
        }
    }
    $bin_data = $fileStr."}";
    fwrite($fp,$bin_data);
    fclose($fp);
    umask($oldMask);
}
echo "custom";
?>
