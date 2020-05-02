#!/usr/bin/env bash
#/bin/bash
# ---------------------------------------------------------
# 开发脚本
# @author abu
# ---------------------------------------------------------

DIR_ROOT=`pwd` # 起始目录

DIR_ERL=${DIR_ROOT}/server # ERL服务端安装目录
DIR_WEB=${DIR_ROOT}/web # web服务端安装目录
DIR_CLI=${DIR_ROOT}/client # flash客户端安装目录
DIR_RES=${DIR_ROOT}/resources # 资源库安装目录
DIR_TLS=${DIR_ROOT}/tools # 辅助工具安装目录
DIR_SEA=${DIR_ROOT}/oversea # 海外版目录
DIR_DOC=doc/data # 数值数据
DIR_DOC_MASTER=doc/data_master # master数值数据
DIR_DOC_STABLE=doc/data_stable # stable数值数据
DIR_RMDOC=doc/策划文档（开发） # 需求文档数据

## 程序目录
ERL=erl # erlang主程序所在路径
WERL=werl # erlang主程序所在路径
PHP=php  # php主程序所在路径
MXMLC=mxmlc # mxmlc的所在路径

ERL_PORT_MIN=40001 # erl节点间通讯端口
ERL_PORT_MAX=40100 # erl节点间通讯端口

#source config.sh
srv=""

## 获取服务器信息
fun_get_srv() {
    server=`cat x.config | grep "server_cfg" | grep $1`
    srv=($server)
    #echo ${srv[0]}
    #echo $srv
}

## 编译服务端
fun_ms(){ 
    fun_make_server $*
}

fun_msu(){ 
    fun_make_server $*
    cd ${DIR_ROOT}
    fun_up $*
}

fun_make_server(){
    srv_name=x_1
    fun_get_srv $srv_name
    cd ${srv[7]}
    rm -f ebin/sys_conn.beam
    rm -f ebin/boot_misc.beam
    rm -f ebin/tester.beam
    ${ERL} -eval "mmake:all(8, [{d, debug}])" -s c q
    echo "服务端编译完成"
}

## 编译服务端, 开启socket打印
fun_mss(){ 
    fun_make_server_socket $*
}
fun_make_server_socket(){
    srv_name=x_1
    fun_get_srv $srv_name
    cd ${srv[7]}
    rm -f ebin/sys_conn.beam
    rm -f ebin/boot_misc.beam
    rm -f ebin/tester.beam
    ${ERL} -eval "make:all([{d, debug_socket}, {d, debug}])" -s c q
    echo "服务端编译完成"
}

## 编译服务端, 开启协议数量记录
fun_msss(){ 
    fun_make_server_socket_save $*
}
fun_make_server_socket_save(){
    srv_name=x_1
    fun_get_srv $srv_name
    cd ${srv[7]}
    rm -f ebin/sys_conn.beam
    rm -f ebin/boot_misc.beam
    rm -f ebin/tester.beam
    ${ERL} -eval "make:all([{d, debug_socket_save}, {d, debug}])" -s c q
    echo "服务端编译完成"
}

## 编译全部
fun_make_all(){
    fun_make_server $*
    fun_make_server_single x_2
    fun_make_server_single x_plat
    fun_make_server_single x_cdb
    fun_make_server_single x_group
    fun_make_server_single x_log
}

fun_make_merge(){
    fun_make_server_single x_merge
}

fun_up_all(){
    fun_up fun_up x_1
    fun_up fun_up x_2
    fun_up fun_up x_cdb
    fun_up fun_up x_plat
    fun_up fun_up x_group
    fun_up fun_up x_log
}

fun_make_up_all(){
    fun_make_all $*
    fun_up_all $*
}

fun_ma(){
    fun_make_all $*
}

fun_mua(){
    fun_make_up_all $*
}

fun_ua(){
    fun_up_all $*
}

## 编译单个服务端
fun_make_server_single(){
    cd ${DIR_ROOT}
    srv_name=$1
    fun_get_srv $srv_name
    cd ${srv[7]}
    rm -f ebin/*.beam
    cp -r ../server/ebin/*.beam ebin/
    echo "${srv_name} 服务端编译完成"
}

## 启动服务器
fun_master(){
    fun_start $*
}
fun_master2(){
    fun_start_2 $*
}
fun_group(){
    fun_start_group $*
}
fun_plat(){
    fun_start_plat $*
}
fun_cdb(){
    fun_start_cdb $*
}
fun_log(){
    fun_start_log $*
}
## fun_start(){
##     srv_name=zk_1
##     if [ $# -eq 2 ]; then
##         srv_name=$2
##     fi
##     fun_get_srv $srv_name
##     cd ${srv[7]}/config/
##     # werl +P 204800 -smp enable -env ERL_MAX_PORTS 5000 -pa ../ebin -name  -setcookie %COOKIE% -boot start_sasl -config %CONFIG_FILE% -s main server_start -s reloader
##     ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -pa ../ebin -setcookie ${srv[4]} -config run_1 -s -boot start_sasl main server_start -s reloader &
## }

fun_start_all(){
    cd ${DIR_ROOT}
	fun_start $*
    cd ${DIR_ROOT}
	fun_start_2 $*
    cd ${DIR_ROOT}
	fun_start_plat $*
    cd ${DIR_ROOT}
	fun_start_group $*
    cd ${DIR_ROOT}
	fun_start_cdb $*
	#cd ${DIR_ROOT}
	#fun_start_log $*
}

fun_sa(){
    fun_start_all $*
}

fun_merge(){
    srv_name=x_merge
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s merge_main start -extra merge ${srv[2]} ${srv[3]} &
}

fun_start(){
    srv_name=x_1
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
    #${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name zk_kxwan_27@m339.arpg.g.1360.com -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}

fun_start_2(){
    srv_name=x_2
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}

fun_start_3(){
    srv_name=x_3
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}

fun_start_4(){
    srv_name=x_4
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}
fun_start_5(){
    srv_name=x_5
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}
fun_start_6(){
    srv_name=x_6
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}
fun_start_7(){
    srv_name=x_7
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}
fun_start_8(){
    srv_name=x_8
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}
fun_start_9(){
    srv_name=x_9
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}
fun_start_10(){
    srv_name=x_10
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra master ${srv[2]} ${srv[3]} &
}

fun_start_cdb(){
    srv_name=x_cdb
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s main start -extra cross_cdb ${srv[2]} ${srv[3]} &
}

fun_start_log(){
    srv_name=x_log
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra log ${srv[2]} ${srv[3]} &
}

fun_start_group(){
    srv_name=x_group
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s main start -extra cross_group ${srv[2]} ${srv[3]} &

}

fun_start_group2(){
    srv_name=x_group2
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s main start -extra cross_group ${srv[2]} ${srv[3]} &
}

fun_start_group3(){
    srv_name=x_group3
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s main start -extra cross_group ${srv[2]} ${srv[3]} &
}

fun_start_group4(){
    srv_name=x_group4
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s main start -extra cross_group ${srv[2]} ${srv[3]} &
}

fun_start_plat(){
    srv_name=x_plat
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ## ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s main start -extra cross_plat ${srv[2]} ${srv[3]} &
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -mnesia dir \"../var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra cross_plat ${srv[2]} ${srv[3]} &
}
fun_start_plat2(){
    srv_name=x_plat
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s main start -extra cross_plat ${srv[2]} ${srv[3]} &
}
fun_start_plat3(){
    srv_name=x_plat
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s main start -extra cross_plat ${srv[2]} ${srv[3]} &
}
fun_start_plat4(){
    srv_name=x_plat
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    echo "${DIR_ROOT}"
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]} -config elog -s main start -extra cross_plat ${srv[2]} ${srv[3]} &
}

## 关闭服务器
fun_stop_all(){
    cd ${DIR_ROOT}
	fun_stop $*
    cd ${DIR_ROOT}
	fun_stop_2 $*
    cd ${DIR_ROOT}
	fun_stop_plat $*
    cd ${DIR_ROOT}
	fun_stop_group $*
    cd ${DIR_ROOT}
	fun_stop_cdb $*
	cd ${DIR_ROOT}
	fun_stop_log $*
}

fun_sta(){
    fun_stop_all $*
}

fun_stop(){
    srv_name=x_1
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    ${ERL} -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} -name ${srv[1]}_stop@${srv[2]} -setcookie ${srv[4]} -config elog -s main stop_from_shell -extra ${srv[1]}@${srv[2]}
}

fun_stop_2(){
    srv_name=x_2
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    ${ERL} -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} -name ${srv[1]}_stop@${srv[2]} -setcookie ${srv[4]} -config elog -s main stop_from_shell -extra ${srv[1]}@${srv[2]}
}

fun_stop_group(){
    srv_name=x_group
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    ${ERL} -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} -name ${srv[1]}_stop@${srv[2]} -setcookie ${srv[4]} -config elog -s main stop_cross_from_shell -extra ${srv[1]}@${srv[2]}
}

fun_stop_plat(){
    srv_name=x_plat
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    ${ERL} -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} -name ${srv[1]}_stop@${srv[2]} -setcookie ${srv[4]} -config elog -s main stop_cross_from_shell -extra ${srv[1]}@${srv[2]}
}
fun_stop_cdb(){
    srv_name=x_cdb
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    ${ERL} -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} -name ${srv[1]}_stop@${srv[2]} -setcookie ${srv[4]} -config elog -s main stop_cross_from_shell -extra ${srv[1]}@${srv[2]}
}

fun_stop_log(){
    srv_name=x_log
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    ${ERL} -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} -name ${srv[1]}_stop@${srv[2]} -setcookie ${srv[4]} -config elog -s main stop_cross_from_shell -extra ${srv[1]}@${srv[2]}
}

## 清理erlang编译结果
fun_clean(){
    srv_name=x_1
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    rm -f *.beam 
    echo 清理erlang编译结果完成
}

## 清档
fun_clean_data(){
    srv_name=x_1
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    cd ${srv[7]}/var/
    echo "清理dets"
    rm -rf *.dets
    echo "清理mnesai"
    rm -rf mnesia
    echo "清理mysql"
    mysql -uroot -p${srv[6]} -e "drop database ${srv[5]}"
    mysql -uroot -p${srv[6]} -e "create database ${srv[5]}"
    echo 清档完成
}

## 热更
fun_up() {
    cd ${DIR_ROOT}
    srv_name=x_1
    if [ $# -eq 2 ]; then
        srv_name=$2
    fi
    fun_get_srv $srv_name
    ${ERL} -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} -name ${srv[1]}_hotswap@${srv[2]} -setcookie ${srv[4]}  -eval "rpc:call('${srv[1]}@${srv[2]}', dev, u, []), erlang:halt()."
    echo "完成热更"
}

## 启动测试器
fun_tester1(){
    srv_name=x_1
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name x_1_tester@${srv[2]} -setcookie ${srv[4]}_tester -config elog -s main start -extra tester ${srv[2]} ${srv[3]} $2 &
}

fun_tester2(){
    srv_name=x_1
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name x_2_tester@${srv[2]} -setcookie ${srv[4]}_tester -config elog -s main start -extra tester ${srv[2]} ${srv[3]} $2 &
}

## 启动数据管理
fun_dbm(){
    srv_name=x_1
    fun_get_srv $srv_name
    cd ${srv[7]}/ebin
    ${WERL} -hidden -kernel inet_dist_listen_min ${ERL_PORT_MIN} -kernel inet_dist_listen_max ${ERL_PORT_MAX} +P 204800 +K true -smp enable -name ${srv[1]}@${srv[2]} -setcookie ${srv[4]}_dbm -config elog -mnesia dir \"${DIR_ROOT}/${srv[7]}/var/mnesia\" -mnesia dump_log_write_threshold 100000 -s main start -extra dbm &
}

## 生成协议文件
fun_proto() {
    if [ ! -n "$2" ]; then 
        echo "stax error.  sh ctl.sh proto Num"
        return 1
    fi
    cd ${DIR_TLS}/protocol
	${PHP} gen.php proto_$2
    echo "finish gen proto $2"
}

## 生成策划数据文件
fun_convert() {
    if [ ! -n "$2" ]; then
        echo "stax error. sh ctl.sh convert xxx"
        return 1
    fi
    fun_convert_2 convert_develop.php $2
}
fun_convert_master() {
    if [ ! -n "$2" ]; then
        echo "stax error. sh ctl.sh convert xxx"
        return 1
    fi
	cd ${DIR_TLS}
	fun_git_checkout "master"
	cd ${DIR_ROOT}
	fun_gtpl "" "master" "master"
	cd ${DIR_ROOT}
	svn update ${DIR_DOC_MASTER}/
    fun_convert_2 convert_master.php $2
}

fun_convert_master2() {
    if [ ! -n "$2" ]; then
        echo "stax error. sh ctl.sh convert xxx"
        return 1
    fi
    fun_convert_2 convert_master.php $2
}

fun_convert_stable() {
    if [ ! -n "$2" ]; then
        echo "stax error. sh ctl.sh convert xxx"
        return 1
    fi
	svn update ${DIR_DOC_STABLE}/
    fun_convert_2 convert_stable.php $2
}

fun_convert_2() {
    case $2 in
        fun_open_data) 
            cd ${DIR_TLS}/convert/
            ${PHP} $1 $2 fun_open_define
            mv -f ${DIR_ERL}/src/data/fun_open_define.erl ${DIR_ERL}/include/fun_open_define.hrl
            ${PHP} $1 $2;;
        scene_jump) 
            cd ${DIR_TLS}/convert/
            ${PHP} $1 scene_data run_tpl scene_jump;;
        *)
            cd ${DIR_TLS}/convert/
            ${PHP} $1 $2;;
    esac
}

## 更新策划文档
fun_doc(){
    ##TortoiseProc /command:update /path:${DIR_DOC}/../ /closeonend:0
	svn update ${DIR_DOC}/
}
## 更新策划需求文档
fun_docall(){
	svn update ${DIR_DOC}/
	svn update ${DIR_RMDOC}/
}
fun_docc(){
    TortoiseProc /command:update /path:${DIR_DOC}/../ /closeonend:0
}
## 提交策划文档
fun_dcm(){
    ##TortoiseProc /command:update /path:${DIR_DOC}/../ /closeonend:0
	svn commit ${DIR_DOC}/ -m "其他-提交文档"
}
## 更新并转化策划文档
fun_cvt(){
    svn update ${DIR_DOC}/
	fun_convert 0 $2
}
## 更新场景
fun_map(){
    fun_doc
    cp ${DIR_ROOT}/doc/map_edit/for_server/map_data.erl ${DIR_ERL}/src/data/
    cp ${DIR_ROOT}/doc/map_edit/for_server/map_data_walkable.erl ${DIR_ERL}/src/data/
    echo "成功更新地图数据"
}

fun_git(){
    if [ $# -lt 5 ]; then
        echo "usage: $0 git (server,tools) (pull,push) source_branch target_branch [comment]"
        return 1
    fi
    project=$2
    action=$3
    source_b=$4
    target_b=$5
    comment=$6
    if [ -z "$6" ]; then
        comment="其它-更新修改"
    fi
    cd ${DIR_ROOT}/$2

    case $action in
        commit) fun_git_commit $source_b $comment;;
        pull) fun_git_pull $source_b $target_b $comment;;
        push) fun_git_push $source_b $target_b $comment;;
        *)
            echo "未知动作(pull,push)"
            break;;
    esac
}

fun_git_checkout(){ 
    git checkout $1
}

fun_gspl(){ 
    fun_git git server pull $2 $3 $4 
}
fun_gsps(){ 
    fun_git git server push $2 $3 $4 
}
fun_gtpl(){
    fun_git git tools pull $2 $3 $4 
}
fun_gtps(){ 
    fun_git git tools push $2 $3 $4 
}

fun_git_commit(){
    git checkout $1 && git add -A && git commit -m "$2"
}

fun_git_pull(){
    fun_git_commit $1 $3
    git pull origin $2 && git push origin $1
}

fun_git_push(){
    fun_git_commit $1 $3 
    git push origin $1
    if [ $? != 0 ]; then
        echo "push fail --------------"
        return 1
    fi
    if [ "$1" = "$2" ]; then 
        return 0
    fi
    git checkout $2 && git pull && git merge origin/$1 && git push origin $2 && git checkout $1
}

## 使用dialyzer检查代码
fun_check_src(){
    dialyzer --add_to_plt --plt server/qz.plt -r server/ebin/
}

## 使用dialyzer检查代码
fun_recheck_src(){
    dialyzer --build_plt --apps erts kernel stdlib compiler mnesia crypto --output_plt server/qz.plt
    dialyzer --add_to_plt --plt qz.plt -r server/ebin/
}

## 生成资源版本文件
fun_filetime(){
    cd ${DIR_RES}/assets/
    ${PHP} createFileTime.php $1
}

## 部署发布客户端(其他人要用要改下面xxmake.exe路径和config路径)
fun_depcli(){
    fun_filetime
	~/deployClient/AssetsMemoryCounter/AssetsMemoryCounter.exe h:/projects/xp/resources/assets
	echo "finish makeAssetsMemory"
	~/deployClient/xxmaker/xxmaker.exe h:/projects/xp/resources/assets/config
	echo "finish makejson"
}

## 部署发布客户端(mac下)
fun_mdepcli(){
    fun_filetime
	open -a /Applications/AssetsMemoryCounter.app -W --args /Users/chrischan/projects/xp/resources/assets
	echo "finish makeAssetsMemory"
	open -a /Applications/xxmaker.app -W --args /Users/chrischan/projects/xp/resources/assets/config
	echo "finish makejson"
}

## 热更客户端配置
fun_cheatconf(){
	cd ${DIR_RES}
	git checkout master
	git pull origin master
	cd ${DIR_ROOT}
	#echo ">master配置生成..." | _color_ yellow
	#IFS=, read -a confs <<<$2
	#declare -p confs
	#len=${#confs[@]}
	#for ((i=0;i<$len;i++))
	#do
	#	if [ $i -eq 0 ]; then
	#		echo "convert_master ${confs[$i]}" | _color_ yellow
	#		fun_convert_master 0 ${confs[$i]}
	#	else
	#		echo "convert_master2 ${confs[$i]}" | _color_ yellow
	#		fun_convert_master2 0 ${confs[$i]}
	#	fi
	#done
	svn update ${DIR_DOC_MASTER}/
	cd ${DIR_TLS}
	git checkout master
	git pull origin master
	cd ${DIR_ROOT}
	echo ">master配置生成..." | _color_ yellow
	fun_convert_master2 0 $2
	cd ${DIR_RES}
	git status
	git add .
	git commit -am "自动热更资源配置"
	echo ">master配置生成ok!" | _color_ yellow
	cd ${DIR_CLI}
    fun_depcli
	cd ${DIR_RES}
	git status
	git commit -am "自动发布资源"
	git push origin master
	echo ">>master资源发布ok!" | _color_ yellow
	
	if [ $# -eq 3 ]; then
		echo ">>>同步stable..." | _color_ yellow
		git checkout stable
		git pull origin stable
		git merge origin/master --no-edit
		git push origin stable
		git checkout master
		echo ">>>同步stable ok!" | _color_ yellow
	fi
	cd ${DIR_CLI}
}

function _color_()  
{
    case "$1" in
        red)    nn="31";;
        green)  nn="32";;
        yellow) nn="33";;
        blue)   nn="34";;
        purple) nn="35";;
        cyan)   nn="36";;
    esac
    ff=""
    case "$2" in
        bold)   ff=";1";;
        bright) ff=";2";;
        uscore) ff=";4";;
        blink)  ff=";5";;
        invert) ff=";7";;
    esac
    color_begin=`echo -e -n "\033[${nn}${ff}m"`
    color_end=`echo -e -n "\033[0m"`
    while read line; do
        echo "${color_begin}${line}${color_end}"
    done
}

## 计算文件的占用和内存
fun_cfile(){
	cd ${DIR_TLS}/client_tools
    ${PHP} cfile.php $2
}

## 对比版本间的差异文件
fun_cdiff(){
	cd ${DIR_RES}
    ${PHP} $4."/tools/client_tools/createFileDiff.php" $2 $3 $5
}

fun_build_cross(){
    for val in server_2 server_group server_plat server_cdb
    do
        fun_build_cross_single ${val}
    done
}

fun_build_cross_single(){
    cd ${DIR_ROOT}
    tardir="./$1"

    if [ ! -d "${tardir}" ]; then
        mkdir "${tardir}"
    fi
    if [ ! -d "${tardir}/var" ]; then
        mkdir "${tardir}/var"
    fi
    if [ ! -d "${tardir}/ebin" ]; then
        mkdir "${tardir}/ebin"
    fi

    rm -rf ${tardir}/ebin/*.beam
    rm -rf ${tardir}/var/*
    cp -r ${DIR_ERL}/ebin/*.beam ${tardir}/ebin/
    cp -r ${DIR_ERL}/elog.config.sample ${tardir}/ebin/elog.config

    case $1 in
        server_2) 
            cp -r ${DIR_ERL}/game.app.server2.sample ${tardir}/ebin/game.app;;
        server_group) 
            cp -r ${DIR_ERL}/game.app.group.sample ${tardir}/ebin/game.app;;
        server_plat) 
            cp -r ${DIR_ERL}/game.app.plat.sample ${tardir}/ebin/game.app;;
        server_cdb) 
            cp -r ${DIR_ERL}/cross_cfg.sample ${tardir}/var/cross_cfg.dat
            cp -r ${DIR_ERL}/game.app.cdb.sample ${tardir}/ebin/game.app;;
        *)
            break;;
    esac
    echo "$1 搭建完成"
}

##  海外版本
fun_tr(){
	if [ ! -n "$3" ]; then
        echo "stax error. sh ctl.sh tr (cli or srv) kr"
        return 1
    fi
	tardir="${DIR_TLS}/convert/lang/$3"
	if [ ! -d "${tardir}" ]; then
        mkdir "${tardir}"
		cp -r ${DIR_TLS}/convert/lang/ch/lang.php ${tardir}/lang.php
		cp -r ${DIR_TLS}/convert/lang/ch/lang_add.php ${tardir}/lang_add.php
	fi
	cd ${DIR_TLS}/convert/	
	case $2 in
        cli) 
			echo "开始更新资源到 ${DIR_SEA}/$3"
			if [ ! -d "${DIR_SEA}" ]; then
				mkdir "${DIR_SEA}"
			fi			
			seadir="${DIR_SEA}/$3"			
			rm -rf "${seadir}"
			mkdir -p "${seadir}/resources/assets/"
			mkdir -p "${seadir}/client/cymmo/"
			cp -rf ${DIR_CLI}/cymmo/src ${seadir}/client/cymmo/src
			cp -rf ${DIR_RES}/assets/config ${seadir}/resources/assets/config
			echo "完成资源更新!"
            ${PHP} tr_cli.php $3;;
        srv) 
            ${PHP} tr_srv.php $3;;
        *)
            break;;
    esac
	
}



## 命令行帮助
fun_help(){
    echo "make_server [srv_id]           编译服务端源码"
    echo "ms [srv_id]                    同make_server"
    echo "mss [srv_id]                   编译服务端，打印socket信息"
    echo "msu [srv_id]                   编译服务端，并热更"
    echo "master [srv_id]                启动服务器"
    echo "stop [srv_id]                  关闭服务器"
    echo "up [srv_id]                    热更服务器"
    echo "clean [srv_id]                 清理erlang编译结果"
    echo "clean_data"                    清档
    echo "proto [proto_num]     生成协议文件"
    echo "convert [xml_name]    转换xml数据"
    echo "map                   更新场景数据"
    echo "doc                   更新svn策划数据"
    echo "tester                启动tester"
    echo "check_src/recheck_src     使用dialyzer检查/重新检查代码"
    echo "filetime              生成资源版本文件"
	echo "cfile [path]			计算文件的占用和内存"			
	echo "cdiff [cm1/tag1] [cm2/tag2] [zk_path] [dir]	对比版本间的差异文件"	
	echo "tr [srv/cli] [ch/en/kr/XX]	海外版翻译工具"	
	echo "depcli 				部署客户端(filetime,mem,makejson)"	
	echo "cheatconf [confs] [sync_stable] 热更客户端配置"
}

## 退出
fun_quit(){
    exit 0
}

## 执行入口
Cmd=""
if [ $# -eq 0 ]; then
    fun_help
else
    fun_$1 $*
fi
exit 0

