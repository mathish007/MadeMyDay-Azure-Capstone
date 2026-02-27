#!/bin/bash
set -euo pipefail

sudo apt-get update -y
sudo apt-get install -y php-curl php-xml composer unzip

cd /var/www/html

# Install Azure Blob SDK for PHP (creates vendor/)
composer require microsoft/azure-storage-blob

echo "Azure Blob SDK installed in /var/www/html/vendor"
echo "Now create /var/www/html/.env and set BLOB_ACCOUNT_NAME and BLOB_ACCOUNT_KEY"
