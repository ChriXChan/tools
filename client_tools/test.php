<?php
	/*
	*主程序
	*/	
	function git_info(&$out, $cm1, $cm2, &$status)
	{
		//$res_path = "cd ../../resources/";
		//$ret = exec($res_path, $out, $status);
		//echo 
		$str = "git diff --name-status ".$cm1." ".$cm2." >> filediff.info";
		$ret = exec($str, $out, $status);
	}
	
	function deleteAll($path) 
	{
		$op = dir($path);
		while(false != ($item = $op->read())) 
		{
			if($item == '.' || $item == '..') 
			{
				continue;
			}
			if(is_dir($op->path.'/'.$item)) 
			{
				deleteAll($op->path.'/'.$item);
				rmdir($op->path.'/'.$item);
			} 
			else 
			{
				unlink($op->path.'/'.$item);
			}
		}
		rmdir($path);
	}

	function main($argc, $argv)
	{
		if ($argc < 3)
		{
			echo "error : please enter 2 tags/commits\n";
			return false;
		}
        //echo "接收到{$argc}个参数";
		//echo "-{$argv[1]}-{$argv[2]}-";
		//git_info($out, $argv[1], $argv[2], $status);
		if (!isset($argv[3]))
		{
			$argv[3] = "./diff_output".date("ymd_hia",time());
		}
		$output = $argv[3];
		if (!file_exists($output))
		{
			mkdir($output);
		}
		$dir = pathinfo($argv[3]);
		echo "basename=".$dir['basename'];
		if ($output != "." && file_exists($output))
		{
			//deleteAll($output);
			//echo "delete succ!";
		}
		$file = fopen($dir['basename'].'/test.info', 'w'); //打开文件
		fclose($file);
		print_r($dir);
	}
	
	main($argc, $argv);
?>