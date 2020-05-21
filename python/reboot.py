#
# Construct a timestamp variable
#
import time
ts = time.time()
import datetime
st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')

#
# Open a file and allow content to be appended to it
#
f = open('/var/www/html/remotepi/python/reboot.log', 'a')

# write the timestamp and text to the file
f.write(st)
f.write(' : REBOOT command issued\n')



import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="admin",
  passwd="relax",
  database="pi_stats"
)

mycursor = mydb.cursor()

sql = "INSERT INTO log (time) VALUES (%s timestampz)" % (cookies)
var=st
mycursor.execute(sql,var)


mydb.commit()

print(mycursor.rowcount, "record inserted.")


