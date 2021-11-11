import sys
import bcrypt
from PyQt5.QtWidgets import *
from calyxtract_App import *
from serialfunc import serialFunc


class MiApp(QMainWindow):
    def __init__(self):
        super().__init__()
        self.ui = Ui_Application()
        self.ui.setupUi(self)
        #page
        self.ui.stackedWidget.setCurrentWidget(self.ui.homePage)
        # Serial
        self.serial = serialFunc()

        # Threads
        self.thread = {}

        self.ui.baudrateList.addItems(self.serial.baudratesDIC.keys())
        self.ui.baudrateListconfig.addItems(self.serial.baudratesDIC.keys())
        self.ui.baudrateList.setCurrentText('9600')
        self.ui.baudrateListconfig.setCurrentText('9600')
        self.update_ports()

        self.ui.colorInput.addItems(['color1', 'color2', 'color3', 'color4'])
        self.ui.heightInput.addItems(['100mm', '120mm', '140mm', '180mm'])
        self.ui.widthInput.addItems(['30mm', '35mm', '40mm',  '45mm'])

        # Events
        self.ui.homeBtn.clicked.connect(self.open_homepage)
        self.ui.onBtn.clicked.connect(self.open_profilepage)
        self.ui.submitBtn.clicked.connect(self.sendprofile)
        self.ui.goBtn.clicked.connect(self.open_analytispage)
        self.ui.config_Btn.clicked.connect(self.open_configpage)
        self.ui.connectBtnconfig.clicked.connect(self.connect_config)
        self.ui.login_Btn.clicked.connect(self.open_loginpage)
        self.ui.submitBtnL.clicked.connect(self.loginAccess)
        self.ui.signupBtn.clicked.connect(self.open_signuppage)
        self.ui.submitBtnS.clicked.connect(self.signupAccess)
        self.ui.forgotBtn.clicked.connect(self.open_forgotpage)
        self.ui.submitBtnF.clicked.connect(self.forgot_pwd)
        self.ui.offBtn.clicked.connect(self.open_homepage)
        self.ui.connectBtn.clicked.connect(self.connect_serial)
        self.ui.sendBtn.clicked.connect(self.send_data)
        self.ui.clearBtn.clicked.connect(self.clear_terminal)
        self.ui.refreshBtn.clicked.connect(self.update_ports)
        self.ui.startBtn.clicked.connect(self.start_sys)
        self.ui.stopBtn.clicked.connect(self.stop_sys)
        self.ui.acceptBtn.clicked.connect(self.pod_accept)
        self.ui.rejectBtn.clicked.connect(self.pod_reject)
        self.ui.cwBtn.clicked.connect(self.rotate_cw)
        self.ui.ccwBtn.clicked.connect(self.rotate_ccw)
        self.ui.updateBtn.clicked.connect(self.update_admin)
        self.serial.data_available.connect(self.update_terminal)
        #self.serial.data_available.connect(self.update_speed)
        #self.serial.data_available.connect(self.update_chilly)
        #self.serial.data_available.connect(self.update_accepted)
        #self.serial.data_available.connect(self.update_rejected)

    def open_homepage(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.homePage)
        self.ui.homeBtn.show()
        self.ui.config_Btn.show()

    def open_configpage(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.configPage)

    def open_profilepage(self):
        data = "ON"
        self.serial.send_data(data)
        self.ui.stackedWidget.setCurrentWidget(self.ui.profilePage)

    def open_analytispage(self):
        data = "GO"
        self.serial.send_data(data)
        self.ui.stackedWidget.setCurrentWidget(self.ui.analyticsPage)
        self.ui.homeBtn.hide()
        self.ui.config_Btn.hide()

    def open_loginpage(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.loginPage)

    def open_signuppage(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.signupPage)

    def open_forgotpage(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.page)

    def sendprofile(self):
        color = self.ui.colorInput.currentText()
        height = self.ui.heightInput.currentText()
        width = self.ui.widthInput.currentText()
        data = color + height + width
        self.serial.send_data(data)
        self.ui.stackedWidget.setCurrentWidget(self.ui.readypage)

    # Analytics update
    def update_speed(self, data):
        if data.startswith("S"):
            data = data.replace('S', '')
            data = int(data)
            self.ui.guage.update_value(data)

    def update_accepted(self, data):
        if data.startswith("A"):
            data = data.replace('A', '')
            data = int(data)
            self.ui.acceptLCD.display(data)

    def update_rejected(self, data):
        if data.startswith("R"):
            data = data.replace('R', '')
            data = int(data)
            self.ui.rejectLCD.display(data)

    def update_chilly(self, data):
        if data.startswith("C"):
            data = data.replace('C', '')
            data = int(data)
            self.ui.progressBar.setValue(data)

    def loginAccess(self):
        username = self.ui.userInputL.text()
        password = self.ui.pwdInputL.text()
        if not len(username or password) < 1:
            if True:
                db = open("database.txt", "r")
                d = []
                f = []
                for i in db:
                    a, b = i.split(",")
                    b = b.strip()
                    c = a, b
                    d.append(a)
                    f.append(b)
                    data = dict(zip(d, f))
                try:
                    if username in data:
                        hashed = data[username].strip('b')
                        hashed = hashed.replace("'", "")
                        hashed = hashed.encode('utf-8')
                        try:
                            if bcrypt.checkpw(password.encode(), hashed):
                                print("Login success!")
                                print("Hi", username)
                                self.ui.stackedWidget.setCurrentWidget(self.ui.adminPage)
                                self.ui.login_Btn.setText("Log Out")
                                self.ui.login_Btn.clicked.connect(self.logout)
                                self.ui.user.setText(' ' + username.capitalize())
                            else:
                                print("Wrong password")
                        except:
                            print("Incorrect passwords or username")
                    else:
                        print("Username doesn't exist")
                except:
                    print("Password or username doesn't exist")
            else:
                print("Error logging into the system")
        else:
            print("Please attempt login again")

    def logout(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.loginPage)
        self.ui.login_Btn.setText("LogIn")
        self.ui.user.setText(" "+"User")

    def signupAccess(self):
        username = self.ui.userInputS.text()
        password1 = self.ui.pwdInputS.text()
        password2 = self.ui.confirmpwdInputS.text()
        db = open("database.txt", "r")
        d = []
        for i in db:
            a, b = i.split(",")
            b = b.strip()
            c = a, b
            d.append(a)
        if not len(password1) <= 8:
            db = open("database.txt", "r")
            if not username == '':
                if len(username) < 1:
                    print("Please provide a username")
                elif username in d:
                    print("Username exists")
                else:
                    if password1 == password2:
                        password1 = password1.encode('utf-8')
                        password1 = bcrypt.hashpw(password1, bcrypt.gensalt())

                        db = open("database.txt", "a")
                        db.write(username + ", " + str(password1) + "\n")
                        print("User created successfully!")
                        print("Please login to proceed:")
                    # print(texts)
                    else:
                        print("Passwords do not match")
        else:
            print("Password too short")

    def forgot_pwd(self):
        username = self.ui.userInputF.text()
        password1 = self.ui.pwdInputF.text()
        password2 = self.ui.confirmpwdInputS_2.text()
        db = open("database.txt", "r")
        d = []
        for i in db:
            a, b = i.split(",")
            b = b.strip()
            c = a, b
            d.append(a)
        print(d)
        if not len(password1) <= 8:
            db = open("database.txt", "r")
            if not username == '':
                if len(username) < 1:
                    print("Please provide a username")
                elif username in d:
                    print(username)
                    print("Username exists")
                    user = username
                    for number, line in enumerate(db):
                        if user in line:
                            line_number = number
                            print(line_number)
                            if password1 == password2:
                                password1 = password1.encode('utf-8')
                                password1 = bcrypt.hashpw(password1, bcrypt.gensalt())

                                db = open("database.txt", "r")
                                list_of_line = db.readlines()
                                list_of_line[line_number] = username + ", " + str(password1) + "\n"
                                db = open("database.txt", "w")
                                db.writelines(list_of_line)
                                print("User created successfully!")
                                print("Please login to proceed:")
                            # print(texts)
                            else:
                                print("Passwords do not match")
        else:
            print("Password too short")

    def update_ports(self):
        self.serial.update_ports()
        self.ui.portList.clear()
        self.ui.portListconfig.clear()
        self.ui.portList.addItems(self.serial.portList)
        self.ui.portListconfig.addItems(self.serial.portList)

    def connect_config(self):
        if self.ui.connectBtnconfig.isChecked():
            port = self.ui.portListconfig.currentText()
            baud = self.ui.baudrateListconfig.currentText()
            self.serial.serialPort.port = port
            self.serial.serialPort.baudrate = baud
            self.serial.serialPort.bytesize = 8
            self.serial.serialPort.parity = 'N'
            self.serial.serialPort.stopbits = 1
            self.serial.connect_serial()
            # Si se logra conectar
            if self.serial.serialPort.is_open:
                self.ui.connectBtnconfig.setText('Disconnect')
                icon = QtGui.QIcon()
                icon.addPixmap(QtGui.QPixmap("Green LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.On)
                self.ui.ledPort.setIcon(icon)
                # print("Me conecté")

            # No se logró conectar
            else:
                # print("No me conecte")
                self.ui.connectBtnconfig.setChecked(False)

        else:
            # print("Desconectarme")
            self.serial.disconnect_serial()
            self.ui.connectBtnconfig.setText('Connect')
            icon = QtGui.QIcon()
            icon.addPixmap(QtGui.QPixmap("Red LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.Off)
            self.ui.ledPort.setIcon(icon)

    def connect_serial(self):
        if self.ui.connectBtn.isChecked():
            port = self.ui.portList.currentText()
            baud = self.ui.baudrateList.currentText()
            self.serial.serialPort.port = port
            self.serial.serialPort.baudrate = baud
            self.serial.serialPort.bytesize = 8
            self.serial.serialPort.parity = 'N'
            self.serial.serialPort.stopbits = 1
            self.serial.connect_serial()
            # Si se logra conectar
            if self.serial.serialPort.is_open:
                self.ui.connectBtn.setText('Disconnect')
                icon = QtGui.QIcon()
                icon.addPixmap(QtGui.QPixmap("Green LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.On)
                self.ui.ledPort.setIcon(icon)
                # print("Me conecté")

            # No se logró conectar
            else:
                # print("No me conecte")
                self.ui.connectBtn.setChecked(False)

        else:
            # print("Desconectarme")
            self.serial.disconnect_serial()
            self.ui.connectBtn.setText('Connect')
            icon = QtGui.QIcon()
            icon.addPixmap(QtGui.QPixmap("Red LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.Off)
            self.ui.ledPort.setIcon(icon)

    def send_data(self):
        data = self.ui.sendData.toPlainText()
        self.serial.send_data(data)

    def update_terminal(self, data):
        self.ui.readData.append(data)
        if data.startswith("S"):
            data = data.replace('S', '')
            data = int(data)
            self.ui.guage.update_value(data)
        elif data.startswith("A"):
            data = data.replace('A', '')
            data = int(data)
            self.ui.acceptLCD.display(data)
        elif data.startswith("R"):
            data = data.replace('R', '')
            data = int(data)
            self.ui.rejectLCD.display(data)
        elif data.startswith("C"):
            data = data.replace('C', '')
            data = int(data)
            self.ui.progressBar.setValue(data)
            if data < 26:
                icon = QtGui.QIcon()
                icon.addPixmap(QtGui.QPixmap("Red LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.Off)
                self.ui.ledChillyIncicator.setIcon(icon)
            else:
                icon = QtGui.QIcon()
                icon.addPixmap(QtGui.QPixmap("Green LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.On)
                self.ui.ledChillyIncicator.setIcon(icon)

    def clear_terminal(self):
        self.ui.readData.clear()

    def update_admin(self):
        port = self.ui.portListconfig.currentText()
        baud = self.ui.baudrateListconfig.currentText()
        self.ui.portList.setCurrentText(port)
        self.ui.baudrateList.setCurrentText(baud)
        if self.ui.connectBtnconfig.isChecked():
            self.ui.connectBtn.setText('Disconnect')
            self.ui.connectBtn.setChecked(True)
        else:
            self.ui.connectBtn.setText('Connect')
            self.ui.connectBtn.setChecked(False)

    def update_user(self):
        port = self.ui.portList.currentText()
        baud = self.ui.baudrateList.currentText()
        self.ui.portListconfig.setCurrentText(port)
        self.ui.baudrateListconfig.setCurrentText(baud)
        if self.ui.connectBtn.isChecked():
            self.ui.connectBtnconfig.setText('Disconnect')
            self.ui.connectBtnconfig.setChecked(True)
        else:
            self.ui.connectBtnconfig.setText('Connect')
            self.ui.connectBtnconfig.setChecked(False)

    def start_sys(self):
        data = "st01"
        self.serial.send_data(data)

    def stop_sys(self):
        data = "sx01"
        self.serial.send_data(data)

    def pod_accept(self):
        data = "P_accept"
        self.serial.send_data(data)

    def pod_reject(self):
        data = "P_reject"
        self.serial.send_data(data)

    def rotate_cw(self):
        data = "R_cw"
        self.serial.send_data(data)

    def rotate_ccw(self):
        data = "R_ccw"
        self.serial.send_data(data)

    def ch_shiftin(self):
        data = "ch_shift"
        self.serial.send_data(data)


class ThreadClass(QtCore.QThread):
    any_signal = QtCore.pyqtSignal(int)

    def __init__(self, parent=None, index=0):
        super(ThreadClass, self).__init__(parent)
        self.index = index
        self.is_running = True

    def run(self):
        print('Starting thread...', self.index)
        cnt = 0
        while (True):
            cnt += 1
            if cnt == 99: cnt = 0
            time.sleep(0.01)
            self.any_signal.emit(cnt)

    def stop(self):
        self.is_running = False
        print('Stopping thread...', self.index)
        self.terminate()


if __name__ == "__main__":
    app = QApplication(sys.argv)
    w = MiApp()
    w.show()
    sys.exit(app.exec_())
