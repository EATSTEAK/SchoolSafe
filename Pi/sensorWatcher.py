#!/usr/bin/python
# -*- coding: utf-8 -*-
import time
import serial
import os
from datetime import datetime

ser = serial.Serial('/dev/ttyACM0', 9600)
lastfiredetected = 0
lastvivedetected = 0
lastsounddetected = 0
while True:
    path = "/home/pi/SchoolSafe/sensors.txt"
    if len(ser.readline()) > 0:
        serialoutput = ser.readline()
        f=open(path, 'w')
        f.write(serialoutput)
        f.close()
        sensordata = serialoutput.split(" ")
        if len(sensordata) == 3 and int(sensordata[0]) < 200 and time.time() - lastfiredetected > 20:
            print "firedetected"
            os.system('raspistill -w 1280 -h 720 -o /var/www/html/timeline/fire_%s.jpg' % datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d-%H:%M'))
            os.system("googletts 화재가 감지되었습니다. 몸을 숙이고 침착하게 비상구를 향해 주시기 바랍니다.")
            os.system('sudo chmod 777 /var/www/html/timeline/fire_%s.jpg' % datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d-%H:%M'))
            lastfiredetected = time.time()
        if len(sensordata) == 3 and int(sensordata[1]) < 200 and time.time() - lastvivedetected > 20:
            print "vivedetected"
            os.system('raspistill -w 1280 -h 720 -o /var/www/html/timeline/vive_%s.jpg' % datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d-%H:%M'))
            os.system("googletts 진동이 감지되었습니다. 진동이 멈출 때까지 책상 밑에 들어가 머리를 보호하시고, 진동이 멈추면 최대한 빨리 건물 밖으로 나가 주시기 바랍니다.")
            os.system('sudo chmod 777 /var/www/html/timeline/vive_%s.jpg' % datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d-%H:%M'))
            lastvivedetected = time.time()
        if len(sensordata) == 3 and int(sensordata[2].replace("\r\n", "")) > 500 and time.time() - lastsounddetected > 20:
            print "sounddetected"
            os.system('raspistill -w 1280 -h 720 -o /var/www/html/timeline/sound_%s.jpg' % datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d-%H:%M'))
            os.system('sudo chmod 777 /var/www/html/timeline/sound_%s.jpg' % datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d-%H:%M'))
            lastsounddetected = time.time()
            
    time.sleep(0.3)