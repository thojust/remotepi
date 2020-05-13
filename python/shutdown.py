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
f = open('/var/www/html/remote/python/reboot.log', 'a')

# write the timestamp and text to the file
f.write(st)
f.write(' : SHUTDOWN command issued\n')

###Wait 5 sec to refresh the browser#####
time.sleep(5)
# Following commands replicate command line 'sudo reboot'
# NOte that apache default user www-data needs to be given sud access - see 'sudo vidsudo'
command = "/usr/bin/sudo /sbin/shutdown -r now"
import subprocess
process = subprocess.Popen(command.split(), stdout=subprocess.PIPE)
output = process.communicate()[0]
print output
