def mergejson(filedir):
    filenames = os.listdir(filedir)
    f = endwith('.json')
    filenames = list(filter(f,filenames))
    f = open(filedir + '/config.json','w',encoding='UTF-8')
    starttime = time.clock()
    f.writelines("{\n")
    filelen = len(filenames)
    for index in range(filelen):
        filename = filenames[index]
        if filename[-4:] != 'json' or filename[:6] == 'config':
            continue
        filepath = filedir+'/'+filename
        filekey = '"' + filename[:-5] + '":'
        fileIsNull = False
        lineindex = 0
        for line in open(filepath,'r',encoding='UTF-8'):
            # null content
            if line == 'null\r\n':
                fileIsNull = True
                break;
            elif lineindex == 0:
                f.writelines(filekey)
            line = line.replace('\t\r\n', '')
            f.writelines(line)
            lineindex+=1
        if fileIsNull == False and index < filelen - 1:
            f.writelines(",")
    f.writelines("}")
    f.close()
    endtime = time.clock()
    log('merge json cost:' + str(endtime-starttime) + 's')

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
    log('merge json cost:' + str(endtime-starttime) + 's')