import psutil

from flask import Flask

def memory():
    memory = psutil.virtual_memory()
    return  str(memory.percent)

def disk():
    disk = psutil.disk_usage('/')
    return  str(disk.percent) 


print  memory(), ",", disk(),

