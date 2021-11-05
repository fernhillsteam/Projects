import sys
from PyQt5.QtWidgets import QMainWindow, QApplication
from calyxtract_App import *
from serialfun import serialFun
from login import *



class MiApp(QMainWindow):
    def __init__(self):
        super().__init__()
        self.ui = Ui_Application()
        self.ui.setupUi(self)
        #page
        self.ui.stackedWidget.setCurrentWidget(self.ui.homePage)
        # Serial
        self.serial = serialFun()

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
        self.ui.connectBtncongif.clicked.connect(self.connect_config)
        self.ui.login_Btn.clicked.connect(self.open_loginpage)
        self.ui.submitBtnL.clicked.connect(self.loginAccess)
        self.ui.signupBtn.clicked.connect(self.open_signuppage)
        self.ui.submitBtnS.clicked.connect(self.signupAccess)
        self.ui.forgotBtn.clicked.connect(self.open_forgotpage)
        self.ui.connectBtn.clicked.connect(self.connect_serial)
        self.ui.sendBtn.clicked.connect(self.send_data)
        self.ui.clearBtn.clicked.connect(self.clear_terminal)
        self.ui.updateBtn.clicked.connect(self.update_ports)
        self.ui.startBtn.clicked.connect(self.start_sys)
        self.ui.stopBtn.clicked.connect(self.stop_sys)
        self.ui.acceptBtn.clicked.connect(self.pod_accept)
        self.ui.rejectBtn.clicked.connect(self.pod_reject)
        self.ui.cwBtn.clicked.connect(self.rotate_cw)
        self.ui.ccwBtn.clicked.connect(self.rotate_ccw)
        self.serial.data_available.connect(self.update_terminal)
        #self.serial.data_available.connect(self.update_speed)
        #self.serial.data_available.connect(self.update_chilly)
        #self.serial.data_available.connect(self.update_accepted)
        #self.serial.data_available.connect(self.update_rejected)

    def open_homepage(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.homePage)

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

    def open_loginpage(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.loginPage)

    def open_signuppage(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.signupPage)

    def open_forgotpage(self):
        self.ui.stackedWidget.setCurrentWidget(self.ui.forgotpwdPage)

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
        Username = self.ui.userInputL.text()
        Password = self.ui.pwdInputL.text()
        if not len(Username or Password) < 1:
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
                    if Username in data:
                        hashed = data[Username].strip('b')
                        hashed = hashed.replace("'", "")
                        hashed = hashed.encode('utf-8')

                        try:
                            if bcrypt.checkpw(Password.encode(), hashed):
                                print("Login success!")
                                print("Hi", Username)
                                self.ui.stackedWidget.setCurrentWidget(self.ui.adminPage)
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
            gainAccess()

    def signupAccess(self):
        Username = self.ui.userInputS.text()
        Password1 = self.ui.pwdInputS.text()
        Password2 = self.ui.confirmpwdInputS.text()
        db = open("database.txt", "r")
        d = []
        for i in db:
            a, b = i.split(",")
            b = b.strip()
            c = a, b
            d.append(a)
        if not len(Password1) <= 8:
            db = open("database.txt", "r")
            if not Username == None:
                if len(Username) < 1:
                    print("Please provide a username")
                    register()
                elif Username in d:
                    print("Username exists")
                    register()
                else:
                    if Password1 == Password2:
                        Password1 = Password1.encode('utf-8')
                        Password1 = bcrypt.hashpw(Password1, bcrypt.gensalt())

                        db = open("database.txt", "a")
                        db.write(Username + ", " + str(Password1) + "\n")
                        print("User created successfully!")
                        print("Please login to proceed:")


                    # print(texts)
                    else:
                        print("Passwords do not match")
                        register()
        else:
            print("Password too short")


    def update_ports(self):
        self.serial.update_ports()
        self.ui.portList.clear()
        self.ui.portListconfig.clear()
        self.ui.portList.addItems(self.serial.portList)
        self.ui.portListconfig.addItems(self.serial.portList)

    def connect_config(self):
        if self.ui.connectBtncongif.isChecked():
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
                self.ui.connectBtncongif.setText('Disconnect')
                icon = QtGui.QIcon()
                icon.addPixmap(QtGui.QPixmap("Green LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.On)
                self.ui.ledconfig.setIcon(icon)
                # print("Me conecté")

            # No se logró conectar
            else:
                # print("No me conecte")
                self.ui.connectBtncongif.setChecked(False)

        else:
            # print("Desconectarme")
            self.serial.disconnect_serial()
            self.ui.connectBtncongif.setText('Connect')
            icon = QtGui.QIcon()
            icon.addPixmap(QtGui.QPixmap("Red LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.Off)
            self.ui.ledconfig.setIcon(icon)

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
                self.ui.ledadmin.setIcon(icon)
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
            self.ui.ledadmin.setIcon(icon)

    def send_data(self):
        data = self.ui.sendData.toPlainText()
        self.serial.send_data(data)

    def update_terminal(self,data):
        self.ui.readData.append(data)
        if data.startswith("S"):
            data = data.replace('S', '')
            data = int(data)
            self.ui.guage.update_value(data)
        elif data.startswith("A"):
            #self.ui.readData.append(data)
            data = data.replace('A', '')
            data = int(data)
            self.ui.acceptLCD.display(data)
        elif data.startswith("R"):
            #self.ui.readData.append(data)
            data = data.replace('R', '')
            data = int(data)
            self.ui.rejectLCD.display(data)
        elif data.startswith("C"):
            #self.ui.readData.append(data)
            data = data.replace('C', '')
            data = int(data)
            self.ui.progressBar.setValue(data)
            if data < 26 :
                icon = QtGui.QIcon()
                icon.addPixmap(QtGui.QPixmap("Red LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.Off)
                self.ui.ledChillyIncicator.setIcon(icon)
            else:
                icon = QtGui.QIcon()
                icon.addPixmap(QtGui.QPixmap("Green LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.On)
                self.ui.ledChillyIncicator.setIcon(icon)

    def clear_terminal(self):
        self.ui.readData.clear()

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


if __name__ == "__main__":
    app = QApplication(sys.argv)
    w = MiApp()
    w.show()
    sys.exit(app.exec_())

