#
# Construct a timestamp variable
#
import time
ts = time.time()
import datetime
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')

###### Log boot in database 
import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="admin",
  passwd="relax",
  database="pi_stats"
)

mycursor = mydb.cursor()

sql = "INSERT INTO log (time, action) VALUES ('%s', 'shutdown')" %(st)
mycursor.execute(sql)


mydb.commit()

print(mycursor.rowcount, "record inserted.")

###Wait 5 sec to refresh the browser#####
time.sleep(5)
# Following commands replicate command line 'sudo reboot'
# NOte that apache default user www-data needs to be given sud access - see 'sudo vidsudo'
command = "/usr/bin/sudo /sbin/shutdown -r now"
import subprocess
process = subprocess.Popen(command.split(), stdout=subprocess.PIPE)
output = process.communicate()[0]
print output
