import sys
from PyQt5.QtWidgets import (QApplication, QDialog, QLineEdit, QTextBrowser,
                             QVBoxLayout)
#import qdarkstyle


class Form(QDialog):
    def __init__(self, parent=None):
        super(Form, self).__init__(parent)
        self.browser = QTextBrowser()
        self.lineEdit = QLineEdit()
        self.lineEdit.selectAll()
        self.lineEdit.setPlaceholderText("Type an expression and press Enter")
        layout = QVBoxLayout()
        layout.addWidget(self.browser)
        layout.addWidget(self.lineEdit)
        self.setLayout(layout)
        self.lineEdit.setFocus()
        self.lineEdit.returnPressed.connect(self.update_ui)
        self.setWindowTitle("Calculator")

    def update_ui(self):
        try:
            text = self.lineEdit.text()
            self.browser.append("%s = <b>%s</b>" % (text, eval(text)))
        except:
            self.browser.append("<font color=red>%s is invalid!</font>" % text)
        self.lineEdit.setText('')


if __name__ == "__main__":
    app = QApplication(sys.argv)
    form = Form()
    form.show()
    # app.setStyle(qdarkstyle.load_stylesheet())
    app.exec_()
