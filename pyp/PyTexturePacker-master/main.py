# -*- coding: utf-8 -*-
"""----------------------------------------------------------------------------
Author:
    Huang Quanyong (wo1fSea)
    quanyongh@foxmail.com
Date:
    2016/10/19
Description:
    main.py
----------------------------------------------------------------------------"""

from PyTexturePacker import Packer


def pack_test():
    # create a MaxRectsPacker
    packer = Packer.create(max_width=2048, max_height=2048, trim_mode=1, border_padding=1,enable_rotated=False)
    # pack texture images under the directory "test_case/" and name the output images as "test_case".
    # "%d" in output file name "test_case%d" is a placeholder, which is a multipack index, starting with 0.
    packer.pack("test_image/stand/", "test_image/stand", "")
    print('done!')

def main():
    pack_test()


if __name__ == '__main__':
    main()
