import sys
import os
import json
from enum import Enum

DIR_ACTION_NAMES = ['stand', 'move', 'attack', 'jump', 'die', 'mount_stand', 'mount_move', 'mask_stand', 'mask_move']

class SettingType(Enum):
    Warrior = 1
    Other = 2

def isImageFolder(folder):
    for file in os.listdir(folder):
        shotname, extension = os.path.splitext(os.path.join(folder, file))
        if extension == '.png':
            return True
    return False

if __name__ == '__main__':
    if len(sys.argv) < 2:
        print('error:usage should be: texture_to_egret.py [dir] [setting_type]')
        exit(1)

    folderPath = sys.argv[1]
    settingType = sys.argv[2] or SettingType.Other
    settingData = json.load("config/setting%s.json" % str(settingType))
    if not os.path.exists(folderPath):
        print('error:dir[' + folderPath + '] not exists')
        exit(1)
    parentFolder, folderName = os.path.split(folderPath)
    print(folderPath, folderName, parentFolder, isImageFolder(folderPath))

    imageFolderList = []
    if isImageFolder(folderPath):
        imageFolderList.append(folderPath)
    for file in os.listdir(folderPath):
        filePath = os.path.join(folderPath, file)
        if os.path.isdir(filePath) and isImageFolder(filePath):
            imageFolderList.append(filePath)