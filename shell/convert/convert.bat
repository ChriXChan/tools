@echo off

rem ---------------------------------------------------------
rem ���ƽű���windows�棩��ʹ��ǰ����ȷ�������±�����
rem @author yeahoo2000@gmail.com
rem @author abu
rem ---------------------------------------------------------

rem D:\php
set PHP=php.exe

rem ��Ŀ¼
set DIR_MAIN=..\..

rem erl���������Ŀ¼
set DIR_ERL=%DIR_MAIN%\server
rem web���������Ŀ¼
set DIR_WEB=%DIR_MAIN%\web
rem client����Ŀ¼
set DIR_CLI=%DIR_MAIN%\client
rem ��Դ������Ŀ¼
set DIR_RES=%DIR_MAIN%\resources
rem ���߿�����Ŀ¼
set DIR_TLS=%DIR_MAIN%\tools
rem ��������Ŀ¼
set DIR_DOC=%DIR_MAIN%\doc\data


goto fun_wait_input

:fun_wait_input
    echo ��������Ʒ��ȫ����������ת��
    set inp=
    echo.
    set /p inp=��ѡ��:
    if [%inp%]==[quit] goto fun_quit
    if [%inp%]==[dev] goto fun_dev
    if [%inp%]==[combat_skill_data] goto fun_convert_combat_skill_data
    if [%inp%]==[] goto fun_wait_input
    goto fun_convert_data

:fun_convert_data
		cd %DIR_TLS%\convert
        echo ��ʼת������
		%PHP% convert.php %inp%
		echo ����ת���ɹ� %inp%
        echo �����Ѿ����ɵ�����Ŀ¼
		goto fun_wait_input
:end

:fun_quit
    echo "�˳�"
:end

:fun_dev
    cd %DIR_ERL%
    cd ..
    dev.bat
:end

:fun_convert_combat_skill_data
	cd %DIR_TLS%\convert\
    echo ��ʼת������ %inp%
	%PHP% convert.php combat_skill_data
    echo �������ݵ�����Ŀ¼
	xcopy %DIR_TLS%\convert\target\combat_skill_data.erl %DIR_ERL%\src\data\ /s/q/y
	echo ����ת���ɹ� %inp%
    goto fun_wait_input
:end
