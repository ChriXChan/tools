import json
import operator

if __name__ == '__main__':
    file_path = "data3/client_config_list.json"
    file3_path = "data3/c3.json"
    main_path = "D:/projects/h5/client/trunk/Client/resource/config/data/client_config_list.json"
    config_list = json.load(open(file_path, encoding='UTF-8'))
    c3_list = json.load(open(main_path, encoding='UTF-8'))
    countDic = {}
    for key in config_list:#     print(row, config_list[row])
        if str(key).find('..') == -1 and len(config_list[key]) == 0:
            # print(key, config_list[key])
            config_json = json.load(open("data3/" + key + ".json", encoding='UTF-8'))
            if config_json is None:
                continue
            # attrs = []
            # for row in config_json: #  遍历配置，找到所有key
            #     for column_name in row:
            #         if column_name not in attrs:
            #             attrs.append(column_name)
            if c3_list.get(key) is not None:
                countDic[key] = len(c3_list[key])
                config_list[key] = sorted(c3_list[key])
    dic = sorted(countDic.items(),key=operator.itemgetter(1),reverse=True)
    for key in dic:
        print('属性长度：', key)
    # print(config_list)
    # with open('data3/client_config_list_new2.json', 'w', encoding='UTF-8') as f:
    #     json.dump(config_list, f, ensure_ascii=False)
