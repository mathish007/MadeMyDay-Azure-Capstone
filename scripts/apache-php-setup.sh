#!/bin/bash
set -euo pipefail

sudo apt-get update -y
sudo apt-get install -y apache2 php libapache2-mod-php php-mysql

sudo systemctl enable apache2
sudo systemctl restart apache2

echo "Apache + PHP installed."
echo "Next: copy app/* into /var/www/html and update db.php or .env"
