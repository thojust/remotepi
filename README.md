
## Compiled by Justin Thomas 2020 ### 
### thojust@gmail.com ######

### Credits ####
#### based on tutorial here: https://www.element14.com/community/community/raspberry-pi/raspberrypi_projects/blog/2014/04/02/pi-webpage-reboot
#### and setting up .htaccess https://www.debiantutorials.com/password-protecting-a-directory-with-apache-and-htaccess/
#### and setting up apache and install php https://www.raspberrypi.org/documentation/remote-access/web-server/apache.md
#### and stats python code taken https://learn.pimoroni.com/tutorial/networked-pi/raspberry-pi-system-stats-python

## STEP 1 ###
### make sure apache is installed s
##### sudo apt update 
##### sudo apt install apache2 -y

## STEP 2 ######
## make sure php is installed 
##### sudo apt install php libapache2-mod-php -y


## STEP 3 #######
## make sure flask and pip python libs are installed 
## pip was already installed for me
##### sudo apt-get install python-pip 
##### sudo pip install psutil flask


## STEP 4 #### 
##copy /remote/ to /var/www/html/ ### apache documents folder 


## STEP 5 ###
### Make sure our python directory is writable & X (notably reboot.log is writable)

##### sudo chmod 777 /var/www/html/remote/python/
##### sudo chmod 777 /var/www/html/remote/python/reboot.log


## STEP 6 ###
####
### add the following code to bottom of file using sudo visudo to allow apache to execute python scripts that call sudo user  
### type: 
##### sudo visudo

### scroll to bottom
##### www-data ALL=/sbin/reboot
##### www-data ALL=NOPASSWD: /sbin/reboot
##### www-data ALL=/sbin/shutdown
##### www-data ALL=NOPASSWD: /sbin/shutdown



## STEP 6 ###
### add the following users to .htpasswd 
### admin pw= your choice 
### fakeuser pw= fake 


##### sudo htpasswd -c /etc/apache2/.htpasswd admin 
##### sudo htpasswd /etc/apache2/.htpasswd fakeuser

## STEP 7 ###
### Now edit Apache config file on my pi its here
##### sudo nano /etc/apache2/apache2.conf


### and edit this part to reflect this: 

##### <Directory /var/www/>
##### AllowOverride All
##### </Directory>


## STEP 8  ### Restart Apache 
##### sudo /etc/init.d/apache2 restart


### ALL SET!!! ##### Now browse to hostname.local/remote/ and you should be all set! ###


