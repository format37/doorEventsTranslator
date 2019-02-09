import RPi.GPIO as GPIO
from time import sleep
import requests
import datetime
import picamera
import time

GPIO.setmode(GPIO.BCM)
GPIO.setup(12, GPIO.IN)
laststate='0'
newstate='0'
filepath = 'photo.jpg'
token=''
group=''

def callBackRising(channel):
	global newstate
	newstate	= str(GPIO.input(12))	

print('Waiting for IO12 state cahnges ...')
GPIO.add_event_detect(12, GPIO.RISING, callback=callBackRising, bouncetime=300)

with picamera.PiCamera() as camera:
	#camera.resolution = (2592, 1944)#max camera resolution
	camera.resolution = (1280, 960)#telegram fast photo size
	camera.rotation= 270
	camera.start_preview()
	try:
		while True:								
			if newstate!=laststate:
				laststate=newstate
				camera.capture('photo.jpg')
				dt=(datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S'))
				if newstate=='0':
					doorState='close'
				else:
					doorState='open'
				
				with open(filepath) as fh:
					mydata = fh.read()
					response = requests.put('http://scriptlab.net/telegram/bots/relaybot/relayPhotoViaPut.php',data=mydata,headers={'content-type':'text/plain'},params={'file': filepath})
					
				url = 'http://scriptlab.net/telegram/bots/relaybot/relaylocked.php?token='+token+'&chat='+group+'&text='+dt+' '+doorState
				requests.get(url)
				print(dt+' new state: '+newstate)
			#else:
			#	print('.')
			#sleep(2)
				
	except KeyboardInterrupt:
		GPIO.cleanup()
    

GPIO.cleanup()
