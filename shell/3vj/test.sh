#!/bin/bash
# ---------------------------------------------------------
# 开发脚本
# @author chenhaibin
# ---------------------------------------------------------
DIR_ROOT=`pwd` # 起始目录
DIR_BASE=${DIR_ROOT}/swjia_base # 
DIR_CLOUD3D_PLUGIN=${DIR_ROOT}/swjia_cloud3d_plugin # 
DIR_DOMAIN=${DIR_ROOT}/swjia_domain # 
DIR_FRAMEWORK=${DIR_ROOT}/swjia_framework # 
DIR_MAIN=${DIR_ROOT}/swjia_main # 
DIR_PLUGIN=${DIR_ROOT}/swjia_plugin # 
DIR_RESOURCE=${DIR_ROOT}/swjia_resource # 
DIR_SERVICE=${DIR_ROOT}/swjia_service # 
DIR_THIRDPART=${DIR_ROOT}/swjia_thirdpart # 
DIR_WWW=${DIR_ROOT}/swjia_www # 
DIR_LIBS=${DIR_ROOT}/swjia_libs # 

NORMAL_DIRS=(${DIR_BASE} ${DIR_CLOUD3D_PLUGIN} ${DIR_DOMAIN} ${DIR_FRAMEWORK} ${DIR_MAIN} ${DIR_PLUGIN} ${DIR_RESOURCE} ${DIR_SERVICE} ${DIR_THIRDPART})
COMPILE_DIRS=(${DIR_CLOUD3D_PLUGIN} ${DIR_MAIN} ${DIR_PLUGIN} ${DIR_SERVICE} ${DIR_THIRDPART})

COMPILE_CMDS=("framework" "domain" "base")
UNCOMMIT_CMDS=()

#测试
fun_all(){
	if [ "$3" == "--fast" ]; then
		echo "[3 == fast]"
	else
		echo "[3 == null]"
	fi

	   for dir in ${NORMAL_DIRS[@]}; do
        # fun_array_contains COMPILE_DIRS $dir && echo $dir yes || echo $dir no    # yes
		if $(fun_array_contains COMPILE_DIRS $dir); then
			# echo $dir yes
			fun_find_dir_compiles $dir
		fi
    done
	for cmd in ${UNCOMMIT_CMDS[@]}; do
		echo $cmd
	done

	for f in $dir/*; do
	    if [ -d "$f" ]; then
	        # Will not run if no directories are available
	        cd $f
	        if [ -n "$(git status . --porcelain)" ]; then
	            echo "`pwd`:there are changes";
	        fi
	    fi
	done

	branch_name=
	params=
	if [ -n "$2" ]; then
		if [[ $2 == *-* ]]; then
			params=$2
		else
			branch_name=$2
		fi
	fi
	if [ -n "$3" ]; then
		params=$3
	fi
	echo $branch_name
	echo $params

	fun_updatewww

	echo "asss $12"

	cd ${DIR_WWW}
	fun_save_temp_file . index.html
	fun_restore_temp_file debugParams param-pre.json
}

## 执行入口
Cmd=""
fun_$1 $*
exit 0
