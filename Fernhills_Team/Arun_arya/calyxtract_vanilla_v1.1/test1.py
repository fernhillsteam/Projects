

import serial
import time

serialPort = serial.Serial(
    port="COM1", baudrate=9600, bytesize=8, timeout=1, stopbits=serial.STOPBITS_ONE
)

while 1:
        b = serialPort.readline()
        print (b)