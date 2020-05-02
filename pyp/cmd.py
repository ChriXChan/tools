# coding:utf-8
import subprocess
import re
import time
import os
import os.path
import shutil
import json

def writefileline(file, linenum, linecontent):
    lines = []
    lineindex = 0
    f = open(file,'r',encoding='UTF-8')
    for line in f:
        if lineindex+1 == linenum:
            line = linecontent + '\n'
        lines.append(line)
        print(str(lineindex) + '=' + line)
        lineindex+=1
    f = open(file,'w',encoding='UTF-8')
    f.write(''.join(lines))
    f.close()

def run_cmd(cmd, need_out=False):
    p = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.STDOUT, shell=True)
    out = ""
    if need_out:
        try:
            line = p.stdout.readline().decode()
            while line != '':
                line = p.stdout.readline().decode()
                out += line
        except Exception as e:
            print(str(e))
    p.wait()

    return int(p.returncode), out

def call_cmd(cmd, need_out=False):
    out = subprocess.call(cmd, shell=True)
    if need_out:
        return out

def svn_update(dir):
    return run_cmd('svn update %s' % dir, True)

def svn_commit(dir, filesym = '.', comment='commit frome dev'):
    os.chdir(dir)
    run_cmd('svn update %s' % dir)
    run_cmd('svn add %s --force' % filesym)
    status, out = run_cmd('svn commit -m "%s"' % comment, True)
    os.chdir(root)
    return status, out

def publish_client(dir, ver = 1):
    print('svn update...')
    print(svn_update(dir))
    cmd = 'egret publish %s --version %s' % (dir, ver)
    print(cmd)
    status, out = run_cmd(cmd, True)
    print('publish %s' % (status == 0))
    #out = call_cmd(cmd)
    #print('publish %s' % out == 0)
    return out

webroot_dir = "D:/xampp/htdocs"
client_dir = 'D:/projects/h5/client/trunk/Client'
client_release_dir = client_dir + 'bin-release/web/1'
root = ''

if __name__ == '__main__':
    root = os.getcwd()
    
    #writefileline('content1.txt', 1, 'aaa')
    
    #print(svn_update(client_dir))
    #svn_commit(client_dir, '【优化】\n配置解析完清理')
    stime = time.clock()
    #publish_client(client_dir)
    time.sleep(5)
    print('cost=%s' % (time.clock() - stime))
