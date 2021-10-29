import sys
from PyQt5.QtWidgets import QMainWindow, QApplication
from calyxtract_chocolate_GUI import *
from serialfun import serialFun


class MiApp(QMainWindow):
    def __init__(self):
        super().__init__()
        self.ui = Ui_MainWindow()
        self.ui.setupUi(self)

        # Serial
        self.serial = serialFun()

        self.ui.baudrateList.addItems(self.serial.baudratesDIC.keys())
        self.ui.baudrateList.setCurrentText('9600')
        self.update_ports()

        # Events
        self.ui.connect.clicked.connect(self.connect_serial)
        self.ui.sendBtn.clicked.connect(self.send_data)
        self.ui.clearBtn.clicked.connect(self.clear_terminal)
        self.ui.updateBtn.clicked.connect(self.update_ports)
        self.ui.start.clicked.connect(self.start_sys)
        self.ui.stop.clicked.connect(self.stop_sys)
        self.ui.accept.clicked.connect(self.pod_accept)
        self.ui.reject.clicked.connect(self.pod_reject)
        self.ui.clockwise.clicked.connect(self.rotate_cw)
        self.ui.countercolckwise.clicked.connect(self.rotate_ccw)
        self.ui.shiftin.clicked.connect(self.ch_shiftin)
        self.serial.data_available.connect(self.update_terminal)

    def update_ports(self):
        self.serial.update_ports()
        self.ui.portList.clear()
        self.ui.portList.addItems(self.serial.portList)

    def connect_serial(self):
        if self.ui.connect.isChecked():
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
                self.ui.connect.setText('Disconnect')
                icon = QtGui.QIcon()
                icon.addPixmap(QtGui.QPixmap("Green LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.Off)
                self.ui.led.setIcon(icon)
                # print("Me conecté")

            # No se logró conectar
            else:
                # print("No me conecte")
                self.ui.connect.setChecked(False)

        else:
            # print("Desconectarme")
            self.serial.disconnect_serial()
            self.ui.connect.setText('Connect')
            icon = QtGui.QIcon()
            icon.addPixmap(QtGui.QPixmap("Red LED.png"), QtGui.QIcon.Normal, QtGui.QIcon.Off)
            self.ui.led.setIcon(icon)

    def send_data(self):
        data = self.ui.sendData.toPlainText()
        self.serial.send_data(data)

    def update_terminal(self, data):
        self.ui.readData.append(data)

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

