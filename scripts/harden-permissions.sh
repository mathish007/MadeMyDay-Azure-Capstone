#!/bin/bash
set -euo pipefail

# Sensible permissions for Apache web root
sudo chown -R www-data:www-data /var/www/html
sudo find /var/www/html -type d -exec chmod 755 {} \;
sudo find /var/www/html -type f -exec chmod 644 {} \;

echo "Permissions hardened for /var/www/html"
