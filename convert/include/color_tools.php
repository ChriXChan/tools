<?php
/*
 * 颜色工具
 * @author hkw
 */
function color_red($string) {  
	return "\033[31m".$string." \033[0m";  
}
  
function color_green($string) {  
//	return "\033[01;40;32m".$string."\033[0m";
    return "\033[32m".$string."\033[0m";
}

?>
