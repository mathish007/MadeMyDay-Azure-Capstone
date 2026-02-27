#!/bin/bash
set -euo pipefail

DB_NAME="mademyday"
DB_USER="mademydayuser"
DB_PASS="StrongPassword123"

sudo apt-get update -y
sudo apt-get install -y mysql-server

sudo systemctl enable mysql
sudo systemctl start mysql

# Allow remote connections (for private VNet access)
sudo sed -i 's/^bind-address\s*=\s*127\.0\.0\.1/bind-address = 0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf
sudo systemctl restart mysql

sudo mysql -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME};
USE ${DB_NAME};
CREATE TABLE IF NOT EXISTS vegetables (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  price DECIMAL(10,2),
  description TEXT,
  image VARCHAR(255)
);
CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'%';
FLUSH PRIVILEGES;"
echo "MySQL configured: DB=${DB_NAME}, USER=${DB_USER}"
