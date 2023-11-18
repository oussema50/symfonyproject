#! /bin/bash
########################################################
echo "install php 8.1  "
sudo apt-get update
sudo apt-get install ca-certificates apt-transport-https software-properties-common wget curl lsb-release
curl -sSL https://packages.sury.org/php/README.txt | sudo bash -x
sudo apt-get update
sudo apt-get install php8.1
sudo apt-get install libapache2-mod-php8.1
sudo service apache2 restart 
sudo apt-get install php8.1-common php8.1-curl php8.1-bcmath php8.1-intl php8.1-mbstring php8.1-xmlrpc php8.1-mcrypt php8.1-mysql php8.1-gd php8.1-xml php8.1-cli php8.1-zip

sudo service apache2 restart 
#########################################################
echo "install composer  "
wget -O composer-setup.php https://getcomposer.org/installer
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
##########################################################"
echo "symfony   "
curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
sudo apt install symfony-cli
##########################################################"
echo "install ngrok "
curl -s https://ngrok-agent.s3.amazonaws.com/ngrok.asc | sudo tee /etc/apt/trusted.gpg.d/ngrok.asc >/dev/null && echo "deb https://ngrok-agent.s3.amazonaws.com buster main" | sudo tee /etc/apt/sources.list.d/ngrok.list && sudo apt update && sudo apt install ngrok

ngrok config add-authtoken 2SyyW6K6p11TZsJtWHJhHjvkzjJ_7vFReCusa51dShz8tGfza
######"#######
sudo apt-get purge php7.*
