#coding=utf-8 

def mergejson(filedir,filenames,attrsdict):
    #获取目标文件夹的路径
    #filedir = os.getcwd()+'/data'
    #获取当前文件夹中的文件名称列表  
    #filenames=os.listdir(filedir)
    #f = endwith('.json')
    #filenames = filter(f,filenames)
    #打开当前目录下的result.txt文件，如果没有则创建
    f=open('result.json','w')
    #合并json
    starttime = time.clock()
    f.writelines("{\n")
    filelen = len(filenames)
    for index in range(filelen):
        filename = filenames[index]
        filepath = filedir+'/'+filename+'.json'
        filekey = '"' + filename + '":'
        fileIsNull = False
        lineindex = 0
        attrs = attrsdict[filename]
        attrcount = len(attrs)
        curattrcount = 0
        for line in open(filepath,'r'):
            # null content
            if line.find('null') == 0:
                fileIsNull = True
                break;
            elif lineindex == 0:
                addsym = ','
                if index == 0:
                    addsym = ''
                f.writelines(addsym + filekey)
            line = line.replace('\t\r\n', '')
            line = line.replace('\t\n', '')
            
            # write attr line specify
            objectendline = line.find('\t},') == 0
            canwrite = False
            attrline = False
            if attrcount <= 0 or line.find('" :') == -1:
                canwrite = True
            else:
                for attr in attrs:
                    if attr in line:
                        curattrcount+=1
                        canwrite = True
                        attrline = True
                        break
            if attrline:
                addstr = ',\n'
                if curattrcount == 1:
                    addstr = ''
                if line.find(',\n') != -1:
                    line = addstr + line[:-2]
                else:
                    line = addstr + line[:-1]
            if attrcount > 0 and objectendline:
                curattrcount = 0
                line = '\n' + line
            if canwrite:
                f.writelines(line)
            lineindex+=1
    f.writelines("}")
    f.close()
    endtime = time.clock()
    print('合并json耗时:' + str(endtime-starttime) + 's')

def endwith(*endstring):
    ends = endstring
    def run(s):
        f = map(s.endswith,ends)
        if True in f: return s
    return run

def mergejson2(filedir,configlistfile):
    with open(configlistfile,'r') as loadfile:
        attrsdict = json.load(loadfile)
    filenames = []
    for (filename,attrs) in  attrsdict.items(): 
        filenames.append(filename)

    f = open(filedir + '/config.json','w',encoding='UTF-8')
    starttime = time.clock()
    f.writelines("{\n")
    filelen = len(filenames)
    for index in range(filelen):
        filename = filenames[index]
        filepath = filedir+'/'+filename+'.json'
        filekey = '"' + filename + '":'
        fileIsNull = False
        lineindex = 0
        attrs = attrsdict[filename]
        attrcount = len(attrs)
        curattrcount = 0
        for line in open(filepath,'r'):
            # null content
            if line.find('null') == 0:
                fileIsNull = True
                break;
            elif lineindex == 0:
                addsym = ','
                if index == 0:
                    addsym = ''
                f.writelines(addsym + filekey)
            line = line.replace('\t\r\n', '')
            line = line.replace('\t\n', '')
            
            # write attr line specify
            objectendline = line.find('\t},') == 0
            canwrite = False
            attrline = False
            if attrcount <= 0 or line.find('" :') == -1:
                canwrite = True
            else:
                for attr in attrs:
                    if attr in line:
                        curattrcount+=1
                        canwrite = True
                        attrline = True
                        break
            # ,/\n .. handle sympols
            if attrline:
                addstr = ',\n'
                if curattrcount == 1:
                    addstr = ''
                if line.find(',\n') != -1:
                    line = addstr + line[:-2]
                else:
                    line = addstr + line[:-1]
            if attrcount > 0 and objectendline:
                curattrcount = 0
                line = '\n' + line
            if canwrite:
                f.writelines(line)
            lineindex+=1
    f.writelines("}")
    f.close()
    endtime = time.clock()
    print('merge json cost:' + str(endtime-starttime) + 's')

def mergejson3(filedir, configlistfile):
    with open(configlistfile, 'r', encoding='UTF-8') as loadfile:
        attrsdict = json.load(loadfile)
    filenames = []
    for (filename, attrs) in attrsdict.items():
        filenames.append(filename)
        
    f = open(filedir + '/config.json', 'w', encoding='UTF-8')
    starttime = time.clock()
    f.writelines("{\n")
    filelen = len(filenames)
    for index in range(filelen):
        filename = filenames[index]
        filepath = filedir+'/'+filename+'.json'
        if os.path.exists(filepath) == False:
            continue
        fileIsNull = False
        lineindex = 0
        attrs = attrsdict[filename]
        filekey = '"' + filename.replace('../', '') + '":'
        attrcount = len(attrs)
        curattrcount = 0
        newFileContent = ""
        for line in open(filepath, 'r', encoding='UTF-8'):
            # null content
            if line.find('null') == 0:
                fileIsNull = True
                break
            elif lineindex == 0:
                addsym = ','
                if index == 0:
                    addsym = ''
                f.writelines(addsym + filekey)
            line = line.replace('\t\r\n', '')
            line = line.replace('\t\n', '')

            # write attr line specify
            objectendline = line.find('\t},') == 0
            canwrite = False
            attrline = False
            if attrcount <= 0 or line.find('" :') == -1:
                canwrite = True
            else:
                for attr in attrs:
                    if attr in line:
                        curattrcount += 1
                        canwrite = True
                        attrline = True
                        break
            # ,/\n .. handle sympols
            if attrline:
                addstr = ',\n'
                if curattrcount == 1:
                    addstr = ''
                if line.find(',\n') != -1:
                    line = addstr + line[:-2]
                else:
                    line = addstr + line[:-1]
            if attrcount > 0 and objectendline:
                curattrcount = 0
                line = '\n' + line
            if canwrite:
                f.writelines(line)
                newFileContent += line
            lineindex += 1
        if lineindex > 0:
            newFile = open(filepath,'w',encoding='UTF-8')
            newFile.write(newFileContent)
            newFile.close()
    f.writelines("}")
    f.close()
    endtime = time.clock()
    print('merge json cost:' + str(endtime-starttime) + 's')

def mergeMapScene(filedir, todir):
    filenames = os.listdir(filedir)
    sceneallfile = open(todir + '/scene_config.json','w',encoding='UTF-8')
    sceneallfile.writelines("{\n")
    fileindex = 0
    filelen = len(filenames)
    for dirname in filenames:
        scenefile = filedir + '/' + dirname + '/' + dirname + '_scene.json'
        if os.path.exists(scenefile) == False:
            continue
        filekey = '"' + dirname + '_scene":'
        sceneallfile.writelines(filekey)
        for line in open(scenefile,'r',encoding='UTF-8'):
            #line = line.replace('\t\r\n', '')
            sceneallfile.writelines(line)
        fileindex+=1
        if fileindex < filelen:
            sceneallfile.writelines(",\r\n")
    sceneallfile.writelines("}")
    sceneallfile.close()
        
if __name__ == '__main__':
    import os
    import time
    import json
    filedir = os.getcwd()+'/data'
    # filenames=os.listdir(filedir)
    # f = endwith('.json')
    # filenames = filter(f,filenames)
    # leng = len(filenames)
    # print('dir=' + filedir + ', len=' + str(leng))
    # for name in filenames:
    #     print(name)
    # print('config.json'[:6])
    #mergejson(filedir)
    clentcfgfile = os.getcwd()+'/client_config_list.json'
    with open(clentcfgfile,'r') as loadfile:
        jsonfiledict = json.load(loadfile)
        #print(len(jsonfiledict['t_achievement_detail']))
    filenames = []
    for (filename,attrs) in  jsonfiledict.items(): 
        filenames.append(filename)
        #print("[%s]=" % filename,attrs)
    #for name in filenames:
    #    print(name + '->' + str(jsonfiledict[name]))
    #mergejson(filedir,filenames,jsonfiledict)
    #mergejson2(filedir,clentcfgfile)
    #mergeMapScene('/home/Administrator/proj/h5/client/trunk/Client/resource/assets/rpgGame/map', '/home/Administrator/proj/h5/client/trunk/Client/resource/config')

    to_dir = "D:/projects/h5/client/trunk/Client/resource/config/data"
    mergejson3(to_dir, to_dir + '/client_config_list.json')
