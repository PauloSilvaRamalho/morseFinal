import serial
import time
import os
from env import Banco

bd = Banco()

total  = ''

porta ="COM5"
baudrate = 9600
arduino = serial.Serial(porta,baudrate,timeout=1)
time.sleep(2)

      
def main(total = ''):                                                                                                                                                                              
    os.system("cls")
    while True:
            if arduino.in_waiting>0:
                resposta = arduino.readline().decode().strip()

                if resposta == '|':
                    bd.env(total)
                    total = ''
                    resposta = ''

                elif resposta == '':
                    resposta = ' '

                total = total + resposta
                print(total)
                                                                     
if __name__ == "__main__":
    main()    