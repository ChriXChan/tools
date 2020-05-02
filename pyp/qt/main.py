# -*- coding: utf-8 -*-
"""

This is a first qt program.

"""

import sys

from PyQt5 import QtWidgets

app = QtWidgets.QApplication(sys.argv)  # 定义一个窗口程序

widget = QtWidgets.QWidget()  # 定义一个窗口对象，用户可以通过接口来自定义

widget.resize(360, 360)

widget.setWindowTitle("Hello, PyQt5!")

widget.show()

sys.exit(app.exec_())
