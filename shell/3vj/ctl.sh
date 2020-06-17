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
COMPILE_DIRS=(${DIR_BASE} ${DIR_CLOUD3D_PLUGIN} ${DIR_DOMAIN} ${DIR_FRAMEWORK} ${DIR_MAIN} ${DIR_PLUGIN} ${DIR_SERVICE} ${DIR_THIRDPART})

COMPILE_CMDS=("framework" "base" "domain" "plugin_su")

#测试
fun_test(){
	# if [ "$3" == "--fast" ]; then
	# 	echo "[3 == fast]"
	# else
	# 	echo "[3 == null]"
	# fi
    for dir in ${NORMAL_DIRS[@]}; do
        if [[ " ${COMPILE_DIRS[@]} " == " ${dir} " ]]; then
            # whatever you want to do when array contains value
            echo "`dir`:is compile dir"
        fi
        for f in $dir/*; do
            if [ -d "$f" ]; then
                # Will not run if no directories are available
                cd $f
                if [ -n "$(git status . --porcelain)" ]; then
                    echo "`pwd`:there are changes";
                fi
            fi
        done
    done
}

#切分支+同步+编译
fun_build(){
	cd ${DIR_ROOT}
	git pull
	_INTERUPT=
	for dir in ${NORMAL_DIRS[@]}; do
		cd $dir
		echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		git stash -u && git checkout $2 && git pull --rebase && git stash pop
		conflictRefs=`git diff --name-only --diff-filter=U`
		if [ -n "$conflictRefs" ]; then
    		echo -e "\e[1;31m [冲突]${conflictRefs}\e[0m"
    		_INTERUPT="1"
    		break
		fi
	done

	for cmd in ${COMPILE_CMDS[@]}; do
		gulp $cmd
	done

	if [ -z "$_INTERUPT" ]; then
		cd ${DIR_LIBS}
		echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		git checkout .
		git checkout .
		git clean -fd && git checkout $2 && git pull

		# cd ${DIR_WWW}
		# echo -e "\e[1;36m >>>>>>>>>>>>>>>>>>`pwd`\e[0m"
		# cp debugParams/param-pre_平台3.0.txt ../param-pre_平台3.0.txt
		# cp debugParams/param-test_平台3.0.txt ../param-test_平台3.0.txt
		# git checkout .
		# git checkout .
		# git clean -fd && git checkout $2 && git pull
		# mv ../param-pre_平台3.0.txt debugParams/param-pre_平台3.0.txt
		# mv ../param-test_平台3.0.txt debugParams/param-test_平台3.0.txt

		if [ "$3" == "-n" ]; then
			gulp
		elif [ "$3" == "-r" ]; then
			gulp --env rebuild
		else
			gulp publish
		fi
	fi
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