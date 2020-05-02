@echo off

rem ---------------------------------------------------------
rem 控制脚本（windows版）（使用前需正确设置以下变量）
rem @author yeahoo2000@gmail.com
rem @author abu
rem ---------------------------------------------------------

rem D:\php
set PHP=php.exe

rem 主目录
set DIR_MAIN=..\..

rem erl服务端所在目录
set DIR_ERL=%DIR_MAIN%\server
rem web服务端所在目录
set DIR_WEB=%DIR_MAIN%\web
rem client所在目录
set DIR_CLI=%DIR_MAIN%\client
rem 资源库所在目录
set DIR_RES=%DIR_MAIN%\resources
rem 工具库所在目录
set DIR_TLS=%DIR_MAIN%\tools
rem 数据所在目录
set DIR_DOC=%DIR_MAIN%\doc\data


goto fun_wait_input

:fun_wait_input
    echo 请输入物品表全名进行数据转换
    set inp=
    echo.
    set /p inp=请选择:
    if [%inp%]==[quit] goto fun_quit
    if [%inp%]==[dev] goto fun_dev
    if [%inp%]==[combat_skill_data] goto fun_convert_combat_skill_data
    if [%inp%]==[] goto fun_wait_input
    goto fun_convert_data

:fun_convert_data
		cd %DIR_TLS%\convert
        echo 开始转换数据
		%PHP% convert.php %inp%
		echo 数据转换成功 %inp%
        echo 数据已经生成到代码目录
		goto fun_wait_input
:end

:fun_quit
    echo "退出"
:end

:fun_dev
    cd %DIR_ERL%
    cd ..
    dev.bat
:end

:fun_convert_combat_skill_data
	cd %DIR_TLS%\convert\
    echo 开始转换数据 %inp%
	%PHP% convert.php combat_skill_data
    echo 复制数据到代码目录
	xcopy %DIR_TLS%\convert\target\combat_skill_data.erl %DIR_ERL%\src\data\ /s/q/y
	echo 数据转换成功 %inp%
    goto fun_wait_input
:end
