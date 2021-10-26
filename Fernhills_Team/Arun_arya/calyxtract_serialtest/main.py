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

        self.ui.baudRates.addItems(self.serial.baudratesDIC.keys())
        self.ui.baudRates.setCurrentText('9600')
        self.update_ports()

        #Events
        self.ui.open.clicked.connect(self.connect_serial)
        self.ui.send.clicked.connect(self.send_data)
        self.serial.data_available.connect(self.update_terminal)

    def update_ports(self):
        self.serial.update_ports()
        self.ui.portNames.clear()
        self.ui.portNames.addItems(self.serial.portList)
        
    def connect_serial(self):
        if self.ui.open.isChecked():
            port = self.ui.portNames.currentText()
            baud = self.ui.baudRates.currentText()
            self.serial.serialPort.port = port
            self.serial.serialPort.baudrate = baud
            self.serial.connect_serial()
            #Si se logra conectar
            if self.serial.serialPort.is_open:
               self.ui.open.setText('DISCONNECT')
                #print("Me conecté")

            #No se logró conectar
            else:
                #print("No me conecte")
                self.ui.open.setChecked(False)

        else:
            #print("Desconectarme")
            self.serial.disconnect_serial()
            self.ui.open.setText('CONNECT')
            
    def send_data(self):
        data = self.ui.sendData.toPlainText()
        self.serial.send_data(data)
    
    def update_terminal(self,data):
        self.ui.readData.append(data)
        
if __name__ == "__main__":
    app = QApplication(sys.argv)
    w = MiApp()
    w.show()
    sys.exit(app.exec_())
