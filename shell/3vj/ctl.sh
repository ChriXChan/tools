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

THEME_PACKER_BAT=${DIR_ROOT}/../h5tools/SvjThemeExplorerForTs/run.bat # 资源打包

NORMAL_DIRS=(${DIR_BASE} ${DIR_CLOUD3D_PLUGIN} ${DIR_DOMAIN} ${DIR_FRAMEWORK} ${DIR_MAIN} ${DIR_PLUGIN} ${DIR_RESOURCE} ${DIR_SERVICE} ${DIR_THIRDPART})
COMPILE_DIRS=(${DIR_CLOUD3D_PLUGIN} ${DIR_MAIN} ${DIR_PLUGIN} ${DIR_SERVICE} ${DIR_THIRDPART})

COMPILE_CMDS=("framework" "domain" "domain_domain" "base" "base_base")
UNCOMMIT_CMDS=()

#判断值是否在数组中
fun_array_contains(){ 
    local array="$1[@]"
    local seeking=$2
    local in=1
    for element in "${!array}"; do
        if [[ $element == "$seeking" ]]; then
            in=0
            break
        fi
    done
    return $in
}
#查找文件夹下未提交的编译命令[/d/xxx/yyy/swjia_cloud3d_plugin/parameter.cabinet -> cloud3d_plugin_parameter_cabinet]
fun_find_dir_compiles(){
	local dir=$1
	local splits=(${dir//_/ })
	local cmd_pre=${splits[1]}
	splits=("${splits[@]:2}")
	for item in ${splits[@]}
	do
		cmd_pre="${cmd_pre}_${item}"
	done
	# echo $cmd
	# if $(fun_array_contains COMPILE_CMDS $cmd_pre); then
	# 	return 0
	# fi

	local splits2=
	local cmd_next=
	for f in $dir/*; do
	    if [ -d "$f" ]; then
	        cd $f
	        if [ -n "$(git status . --porcelain)" ]; then
				splits2=(${f//\// })
				local temp=${splits2[-1]}
				splits2=(${temp//./ })
				cmd_next=${splits2[0]}
				splits2=("${splits2[@]:1}")
				for item2 in ${splits2[@]}
				do
					cmd_next="${cmd_next}_${item2}"
				done
				# echo $cmd_next
				UNCOMMIT_CMDS+=("${cmd_pre}_${cmd_next}")
	            # echo "`pwd`:there are changes";
	        fi
	    fi
	done
	return 1
}

fun_save_temp_file(){
	local dir=$1
	local file=$2
	cp $dir/$file ${DIR_ROOT}/$file
}

fun_restore_temp_file(){
	local dir=$1
	local file=$2
	mv ${DIR_ROOT}/$file $dir/$file
}

fun_save_www_temp_files(){
	fun_save_temp_file debugParams param-pre.json
	fun_save_temp_file debugParams param-test.json
	fun_save_temp_file . index.html
	fun_save_temp_file js init.js
}

fun_restore_www_temp_files(){
	fun_restore_temp_file debugParams param-pre.json
	fun_restore_temp_file debugParams param-test.json
	fun_restore_temp_file . index.html
	fun_restore_temp_file js init.js
}

#切分支+同步+编译
fun_build(){
	local params=$*
	local branch_name=
	if [[ $2 != *-* ]]; then
		branch_name=$2
	fi

	cd ${DIR_ROOT}
	git pull
	_INTERUPT=
	for dir in ${NORMAL_DIRS[@]}; do
		cd $dir
		echo -e "\e[1;36m build>>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		git stash -u
		if [ -n "$branch_name" ]; then
			git checkout $branch_name
		fi
		git pull --rebase
		conflictRefs=`git diff --name-only --diff-filter=U`
		if [ -n "$conflictRefs" ]; then
    		echo -e "\e[1;31m [更新冲突]${conflictRefs}\e[0m"
    		_INTERUPT="1"
    		# break # 有冲突不中止，继续更新剩下的库
		else
			git stash pop
			conflictRefs=`git diff --name-only --diff-filter=U`
			if [ -n "$conflictRefs" ]; then
				echo -e "\e[1;31m [贮藏冲突]${conflictRefs}\e[0m"
				_INTERUPT="1"
				git stash drop #冲突了执行一次drop
			fi
		fi
		if $(fun_array_contains COMPILE_DIRS $dir); then
			fun_find_dir_compiles $dir
		fi
	done

	if [ -z "$_INTERUPT" ]; then
		
		fun_updatelibs $branch_name

		if [[ "$params" == *-n* ]]; then
			fun_updatewww $branch_name
			gulp --env fastbuild # gulp
		elif [[ "$params" == *-r* ]]; then
			fun_updatewww $branch_name
			gulp --env rebuild
		else #只执行pubilsh
			fun_updatewww $branch_name
			gulp publish
			fun_build_common
			fun_build_uncommit
		fi
		if [[ "$params" == *-exebat* ]]; then
			fun_callbat $THEME_PACKER_BAT
		fi
	else
		echo  -e "\e[1;31m [严重!解决完上面的冲突再执行build]\e[0m"
	fi
}

fun_build_common(){
	for cmd in ${COMPILE_CMDS[@]}; do
		gulp $cmd
	done
}

fun_build_uncommit(){
	for cmd in ${UNCOMMIT_CMDS[@]}; do
		gulp $cmd
	done
}

fun_updatelibs(){
	if [ "$1" != "updatelibs" ]; then
		branch_name=$1
	fi
	cd ${DIR_LIBS}
	echo -e "\e[1;36m update>>>>>>>>>>>>>>>>>>`pwd`\e[0m"
	git checkout .
	git checkout .
	git clean -fd
	if [ -n "$branch_name" ]; then
		git checkout $branch_name
	fi
	git pull
}

fun_updatewww(){
	if [ "$1" != "updatewww" ]; then
		branch_name=$1
	fi
	cd ${DIR_WWW}
	echo `pwd`
	echo -e "\e[1;36m update>>>>>>>>>>>>>>>>>>`pwd`\e[0m"
	
	fun_save_www_temp_files

	git checkout .
	git checkout .
	git clean -fd
	if [ -n "$branch_name" ]; then
		git checkout $branch_name
	fi
	git pull
	
	fun_restore_www_temp_files
}

fun_callbat(){
	local batdir=`dirname $1`
	local batname=`basename $1`
	cd ${batdir}
	./$batname
}

#切分支+合并+编译
fun_merge(){
	local params=$*
	_INTERUPT=
	for dir in ${NORMAL_DIRS[@]}; do
		cd $dir
		echo -e "\e[1;36m merge>>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		git stash && git checkout $2 
		
		if [[ "$params" == *-local* ]]; then
			git pull
		else
			git pull --rebase
		fi
		
		git merge origin/$3 --no-commit
		conflictRefs=`git diff --name-only --diff-filter=U`
		if [ -n "$conflictRefs" ]; then
    		echo -e "\e[1;31m [合并冲突]${conflictRefs}\e[0m"
    		_INTERUPT="1"
    		break
		fi

		if [[ "$params" == *-push* ]]; then
			git push
		fi
		
		git stash pop
		conflictRefs=`git diff --name-only --diff-filter=U`
		if [ -n "$conflictRefs" ]; then
    		echo -e "\e[1;31m [贮藏冲突]${conflictRefs}\e[0m"
    		git stash drop #冲突了执行一次drop
    		break
		fi
	done

	if [ -z "$_INTERUPT" ]; then
		cd ${DIR_LIBS}
		echo -e "\e[1;36m merge>>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		git checkout .
		git checkout .
		git clean -fd && git checkout $2 && git pull && git merge origin/$3
		
		conflictRefs=`git diff --name-only --diff-filter=U`
		if [ -n "$conflictRefs" ]; then
    		git checkout MERGE_HEAD .
    		git commit -am "merge orign/$3"
		fi

		if [[ "$params" == *-push* ]]; then
			git push
		fi
	fi
}

#创建分支
fun_create(){
	local params=$*
	for dir in ${NORMAL_DIRS[@]}; do
		cd $dir
		echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		git stash && git checkout -b $2 origin/$3 
		if [[ "$params" == *-push* ]]; then
			git push --set-upstream origin $2 
		fi
		git stash pop
	done
	fun_updatelibs
	git checkout -b $2 origin/$3 
	
	if [[ "$params" == *-push* ]]; then
		git push --set-upstream origin $2
	fi

	fun_updatewww
	
	fun_save_www_temp_files

	git checkout .
	git checkout -b $2 origin/$3
	
	if [[ "$params" == *-push* ]]; then
		git push --set-upstream origin $2
	fi
	
	fun_restore_www_temp_files
}

## 命令行帮助
fun_help(){
	echo -e "\e[1;31m######################帮助说明#####################\e[0m"
	echo -e "\e[1;31m[]表示必选参数\e[0m"
	echo -e "\e[1;31m<>表示可选参数\e[0m"
	echo -e "\e[1;31m######################帮助说明#####################\e[0m"
    echo -e "\e[33mbuild [branch_id] <-n|-r|-onlyupdate>          全部编译[默认编译framework/domain/base库]\e[0m
-n:执行gulp编译
-r:执行gulp rebuild编译
-onlyupdate:只更新库不编译
	"
	echo -e "\e[33mmerge [merge branch_id] [from branch_id] <-local|-nopush> 全部合并[默认只合并]\e[0m
-push:合并完push到远程分支
-local:合并分支是本地分支没有远程分支
	"
    echo -e "\e[33mcreate [new branch_id] [from branch_id]          全部创建[默认只创建]\e[0m
-push:创建完push到远程分支
	"
    echo -e "\e[33mupdatewww [branch_id]              更新www[重置当前并拉取最新;保留prams_pre/test配置]\e[0m
	"
    echo -e "\e[33mupdatelibs [branch_id]             更新libs[重置当前并拉取最新]\e[0m
	"
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
