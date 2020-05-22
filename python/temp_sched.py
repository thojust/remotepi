#! /usr/bin/python
import time
ts = time.time()
import datetime
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')

from gpiozero import CPUTemperature

cpu = CPUTemperature()
##print(cpu.temperature)
tempz=(cpu.temperature)


###### Log boot in database 
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="admin",
  passwd="relax",
  database="pi_stats"
)

mycursor = mydb.cursor()

sql = "INSERT INTO temp (temp,time) VALUES ('%s', '%s')" %(tempz,st) 
mycursor.execute(sql)


mydb.commit()

#print(mycursor.rowcount, "record inserted.") 
print(tempz)
