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
fun_test(){
	# if [ "$3" == "--fast" ]; then
	# 	echo "[3 == fast]"
	# else
	# 	echo "[3 == null]"
	# fi

    # for dir in ${NORMAL_DIRS[@]}; do
    #     # fun_array_contains COMPILE_DIRS $dir && echo $dir yes || echo $dir no    # yes
	# 	if $(fun_array_contains COMPILE_DIRS $dir); then
	# 		# echo $dir yes
	# 		fun_find_dir_compiles $dir
	# 	fi
    # done
	# for cmd in ${UNCOMMIT_CMDS[@]}; do
	# 	echo $cmd
	# done

	# for f in $dir/*; do
	#     if [ -d "$f" ]; then
	#         # Will not run if no directories are available
	#         cd $f
	#         if [ -n "$(git status . --porcelain)" ]; then
	#             echo "`pwd`:there are changes";
	#         fi
	#     fi
	# done

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
}

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

#切分支+同步+编译
fun_build(){
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

	cd ${DIR_ROOT}
	git pull
	_INTERUPT=
	for dir in ${NORMAL_DIRS[@]}; do
		cd $dir
		echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		git stash -u
		if [ -n "$branch_name" ]; then
			git checkout $branch_name
		fi
		git pull --rebase && git stash pop
		conflictRefs=`git diff --name-only --diff-filter=U`
		if [ -n "$conflictRefs" ]; then
    		echo -e "\e[1;31m [冲突]${conflictRefs}\e[0m"
    		_INTERUPT="1"
    		break
		elif $(fun_array_contains COMPILE_DIRS $dir); then
			fun_find_dir_compiles $dir
		fi
	done

	if [ -z "$_INTERUPT" ]; then
		
		fun_update_libs

		if [ "$params" == "-n" ]; then
			fun_update_www
			gulp
		elif [ "$params" == "-r" ]; then
			fun_update_www
			gulp --env rebuild
		else #只执行pubilsh
			fun_build_common
			fun_build_uncommit
			gulp publish
		fi
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

fun_update_libs(){
	cd ${DIR_LIBS}
	echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
	git checkout .
	git checkout .
	git clean -fd && git checkout $2 && git pull
}

fun_update_www(){
	cd ${DIR_WWW}
	echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
	cp debugParams/param-pre_平台3.0.txt ../param-pre_平台3.0.txt
	cp debugParams/param-test_平台3.0.txt ../param-test_平台3.0.txt
	git checkout .
	git checkout .
	git clean -fd && git checkout $2 && git pull
	mv ../param-pre_平台3.0.txt debugParams/param-pre_平台3.0.txt
	mv ../param-test_平台3.0.txt debugParams/param-test_平台3.0.txt
}

#切分支+合并+编译
fun_merge(){
	_INTERUPT=
	for dir in ${NORMAL_DIRS[@]}; do
		cd $dir
		echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		git stash && git checkout $2 && git pull --rebase && git merge origin/$3
		conflictRefs=`git diff --name-only --diff-filter=U`
		if [ -n "$conflictRefs" ]; then
    		echo -e "\e[1;31m [冲突]${conflictRefs}\e[0m"
    		_INTERUPT="1"
    		break
		fi
		git push && git stash pop
	done

	# if [ -z "$_INTERUPT" ]; then
	# 	cd ${DIR_LIBS}
	# 	echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
	# 	git checkout .
	# 	git checkout .
	# 	git clean -fd && git checkout $2 && git pull && git merge origon/$3
		
	# 	conflictRefs=`git diff --name-only --diff-filter=U`
	# 	if [ -n "$conflictRefs" ]; then
 #    		echo -e "\e[1;31m [冲突]${conflictRefs}\e[0m"
 #    		_INTERUPT="1"
 #    		break
	# 	fi

	# 	if [ -z "$_INTERUPT" ]; then
	# 		gulp
	# 	fi
	# fi
}
#创建分支
fun_create(){
	for dir in ${NORMAL_DIRS[@]}; do
		cd $dir
		echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		git stash && git checkout -b $2 origin/$3 && git push --set-upstream origin $2 && git stash pop
	done
	cd ${DIR_LIBS}
	echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
	git checkout .
	git checkout .
	git clean -fd && git checkout -b $2 origin/$3 && git push origin $2

	cd ${DIR_WWW}
	echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
	cp debugParams/param-pre_平台3.0.txt ../param-pre_平台3.0.txt
	cp debugParams/param-test_平台3.0.txt ../param-test_平台3.0.txt
	git checkout .
	git checkout .
	git clean -fd && git checkout -b $2 origin/$3 && git push origin $2
	mv ../param-pre_平台3.0.txt debugParams/param-pre_平台3.0.txt
	mv ../param-test_平台3.0.txt debugParams/param-test_平台3.0.txt
}

## 命令行帮助
fun_help(){
    echo "build[branch_id] [-n|-r]          全部编译[默认直接publish;-n执行gulp;-r执行gulp rebuild]"
    echo "merge[mergin branch_id] [to merge branch_id]           全部合并"
    echo "create[new branch_id] [relate merge branch_id]         全部创建"
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
