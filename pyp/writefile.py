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

if __name__ == '__main__':
    writefileline('content1.txt', 1, 'aaa')
