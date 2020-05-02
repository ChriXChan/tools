%% -----------------------------------------------------------------------------
%% 文本数据
%% @author luoxueqing
%% -----------------------------------------------------------------------------
-module(text_data).
-include("text.hrl").

-export([
    get_notice/1
    ,get_mail/1
    ,num2mail/1
    ]
).


%% 获取消息公告配置
<?php
$data = $xml_data[0];
array_shift($data);
array_shift($data);
foreach($data as $row){
    echo "get_notice({$row['key']}) ->\n";
    echo "\t#notice_data{key = {$row['key']}, id = {$row['id']}, target = {$row['target']}, args = {$row['args']}};\n";
}
?>
get_notice(_) -> false.


%% 获取邮件配置
<?php
$data = $xml_data[1];
array_shift($data);
array_shift($data);
foreach($data as $row){
	$row['content'] = preg_replace("/{[0-9]+}/", "~s", $row['content']);
	$row['subject'] = preg_replace("/{[0-9]+}/", "~s", $row['subject']);
    echo "get_mail({$row['key']}) ->\n";
    echo "\t#mail_data{key = {$row['key']}, id = {$row['id']}, subject = <<\"{$row['subject']}\">>, content = <<\"{$row['content']}\">>, content_args = {$row['args']}};\n";
}
?>
get_mail(_) -> false.

%% 获取邮件配置
<?php
foreach($data as $row){
    echo "num2mail({$row['id']}) -> {$row['key']};\n";
}
?>
num2mail(_) -> false.
