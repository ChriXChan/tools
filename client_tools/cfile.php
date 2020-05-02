<?php
	
	$SIZE = 0;
	$SIZE_LIST = array();
	/*
	*主程序
	*/	
	function main()
	{
		global $SIZE;
		global $SIZE_LIST;
        $dir_path = $_SERVER["argv"][1];
		//echo $dir_path."\n";
		$files = scan_dir($dir_path);
		foreach($files as $file)
		{
			$pathinfo = pathinfo($file);
			print_r($pathinfo);
			if (is_directory($pathinfo))
			{
				$SIZE_LIST[$dir_path . "/" . $pathinfo['filename']] = 0;
			}
		}
		calc($files, $dir_path);
		echo "memsize:".$SIZE."B".",".($SIZE/1024)."KB"."\n";
		print_r($SIZE_LIST);
	}
	
	function calc($files, $dir_path)
	{
		global $SIZE;
		global $SIZE_LIST;
		$cur_files_size = 0;
		echo "\n";
		foreach($files as $file)
		{
			$pathinfo = pathinfo($file);
			if (!is_directory($pathinfo))
			{
				if ($pathinfo['extension'] != "fla" && $file != "." && $file != "..")
				{
					$size = getimagesize($dir_path . '/' . $file);
					$weight = $size["0"];//获取图片的宽
					$height = $size["1"];//获取图片的高
					echo $file.$weight."*".$height."\n";
					$cur_files_size = intval($weight) * intval($height) * 4;
					$SIZE = $SIZE + $cur_files_size;
					foreach($SIZE_LIST as $key => $value)
					{
						if (strpos($dir_path, $key) !== false)
						{
							$SIZE_LIST[$key] = $SIZE_LIST[$key] + $cur_files_size;
							echo $key."+".$dir_path."\n";
						}
					}
				}
			}
			else
			{
				$dir_path1 = $dir_path . '/' . $file;
				$files = scan_dir($dir_path1);
				echo "----------".$dir_path1."----------";
				calc($files, $dir_path1);
			}
		}
	}
	
	function scan_dir($path)
	{
		$files = scandir($path);
		array_shift($files);
		array_shift($files);
		return $files;
	}

	function is_directory($info)
	{
		return $info['filename'] == $info['basename'];
	}
	
	main();
?>