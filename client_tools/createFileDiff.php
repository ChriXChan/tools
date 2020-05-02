<?php
	//��Դ�汾fileTime.xx�ļ�ͳ�ư������ļ��л��ļ�(���Ÿ���)
	define("FILE_INC", "assets/model/roletitle");
	//��Դ�汾fileTime.xx�ļ�ͳ���������ļ��л��ļ�(���Ÿ���)
	define("FILE_TIME_SKIP_FILE", ".svn,.git,assets/mapblock,assets/map,assets/config,assets/model,assets/rolelight,assets/sound,assets/ui");
	//��Դ�汾fileTime.xx�ļ�ͳ���������ļ���ʽ(���Ÿ���)
	define("FILE_TIME_SKIP_FILE_FORMAT", "xx,info,mem,json,bat,php,py,air,exe,svn");
	//�����ļ��б�
	$incFileArr;
	//�����ļ��б�
	$skipFileArr;
	//�����ļ���ʽ�б�
	$skipFileFormatArr;
	
	include("FileUtil.php");
	
	/*
	* git��ȡ��Դ��Ϣ�ļ�
	*/
	function git_info(&$out, $cm1, $cm2, $output, &$status)
	{
		$fileinfopath = $output."/filediff.txt";
		$fileinfopath2 = $output."/filediff2.txt";
		//echo $fileinfopath;
		if (file_exists($fileinfopath))
		{
			unlink($fileinfopath);
		}
		
		$str = "git diff --name-status ".$cm1." ".$cm2." >> ".$fileinfopath;
		$ret = exec($str, $out, $status);
		
		//��ȡ�ļ�
		$file = fopen($fileinfopath, 'r'); //���ļ�
		$lines = array();
		$lines[] = "file diff and filter from {".$cm1."} to {".$cm2."}\n";
		while(!feof($file))
		{
			$line = fgets($file,4096); //fgets���ж�ȡ��4096��󳤶ȣ�Ĭ��Ϊ1024
			$parts = explode("	", $line);
			if(count($parts) < 2) continue;
			$mode = $parts[0];
            $filename = $parts[1];
			if ($mode === "D" || isSkipFileName($filename))
			{
				//echo "skip ".$line;
				continue;//ɾ���������ļ��ĺ���
			}
			//echo $line."\n";
			$lines[] = $line;
		}
		fclose($file); //�ر��ļ�
		file_put_contents($fileinfopath2, $lines);
		//unlink("filediff.info");

        echo "Finish git diff-file.\n";
		
		//�����ļ�
		$fu = new FileUtil();
		array_shift($lines);//ɾ����һ��Ԫ��
		$len = count($lines);
		$parentDir = str_replace("\\","/",getcwd());
		//echo "parentDir=".$parentDir;
		if ($len > 0)
		{
			foreach($lines as $oneLine)
			{
				$parts = explode("	", $oneLine);
				if(count($parts) < 2) continue;
				$mode = $parts[0];
				$filepath = $parts[1];
				//$fileNameArr = explode("/", $filepath);
				//$fileName = $fileNameArr[count($fileNameArr) - 1];

				$sourceFile = str_replace(array("\r\n", "\r", "\n"), '', $parentDir."/".$filepath);
				$destFile = str_replace(array("\r\n", "\r", "\n"), '', $output."/".$filepath);
				//echo $sourceFile."--->".$output."/".$filepath;
				//if(file_exists($sourceFile))echo "ext";
				$fu->copyFile($sourceFile, $destFile, true);
			}
		}
		echo "Finish output file.size = ".$len."\n";
		return $fileinfopath2;
	}
	
	/*
	* ɾ��Ŀ¼��Ŀ¼�µ��ļ�
	*/
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
	
	/*
	*��ȡ��Դ�Ա��ļ�
	*/		
	function createFileDiff($cm1, $cm2, $output)
	{		
		$outInfo = pathinfo($output);
		
		if ($output != "." && file_exists($output))
		{
			//deleteAll($output);
		}
		else
		{
			mkdir($output, 0777);
		}
		$ret = git_info($out, $cm1, $cm2, $output, $status);
		if ($status != 0)
		{
			echo "git diff files error!";
			return false;
		}
		
		return true;		
	}
	
	/*
	*��Դ�汾fileTime.xx�ļ�ͳ���������ļ��л��ļ�
	*/	
	function isSkipFileName($fileName)
	{
		$fileName = trim($fileName);
		global $incFileArr;
		global $skipFileArr;
		global $skipFileFormatArr;
		
		if (!isset($incFileArr))
		{
			$incFileArr = explode(",", FILE_INC);
		}
		
		if (!isset($skipFileArr))
		{
			$skipFileArr = explode(",", FILE_TIME_SKIP_FILE);
		}
		
		if (!isset($skipFileFormatArr))
		{
			$skipFileFormatArr = explode(",", FILE_TIME_SKIP_FILE_FORMAT);
		}
		
		foreach ($incFileArr as $value)
		{
			if (strpos($fileName, $value) === 0)
			{
				return false;
			}
		}
		
		foreach ($skipFileArr as $value)
		{
			if (strpos($fileName, $value) === 0)
			{
				return true;
			}
		}
		
		$fileNameArr = explode(".", $fileName);
		if (count($fileNameArr) < 2)
		{
			return false;
		}
		
		$fileFormat = $fileNameArr[count($fileNameArr) - 1];
		foreach ($skipFileFormatArr as $value)
		{
			if ($value == $fileFormat)
			{
				return true;
			}
		}
		
		return false;
	}
	
	/*
	*������
	*/	
	function main($argc, $argv)
	{
		echo "Create file diff ";
		if ($argc < 3)
		{
			echo "Error : please enter [commit1/tag1] [commit2/tag2] <outputDir>\n";
			return false;
		}
		$cm1 = $argv[1];
		$cm2 = $argv[2];
		if (strlen($cm1) === 40 || strlen($cm1) === 40)
		{
			if (strlen($cm1) !== 40 || strlen($cm2) !== 40)
			{
				echo "Error : diff commit should be 40 chars\n";
				return false;
			}
			$cm1 = substr($cm1, 0, 7);
			$cm2 = substr($cm2, 0, 7);			
		}
		echo "from {$cm1} to {$cm2}\n";
		
		$t1 = time();
		
		if (!isset($argv[3]))
		{
			$argv[3] = ".";
		}
		if ($argv[3] != "." && !file_exists($argv[3]))
		{
			mkdir($argv[3]);
		}
		$output = $argv[3]."/diff_output".date("ymd_Hi",$t1);
		
		if (!createFileDiff($argv[1], $argv[2], $output))
		{
			return false;
		}
        $t2 = time();
		echo "time cost = ". ($t2 - $t1) . "s \n";

		//echo "parse file diff \n";
		//$infoArr = parseInfo($infoPath);
		//echo "finish parse file diff : " . count($infoArr) . "\n";
		
		//createXX($infoArr);
	}
	
	main($argc, $argv);
?>
