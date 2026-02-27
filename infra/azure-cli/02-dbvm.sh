#!/bin/bash
set -euo pipefail

RG="rg-mademyday"
LOC="eastus"
VNET="vnet-mademyday"
DB_SUBNET="db-subnet"
DB_PREFIX="10.0.2.0/24"
DBVM="vm-db-01"

# Create DB subnet (private)
az network vnet subnet create -g "$RG" --vnet-name "$VNET" -n "$DB_SUBNET" --address-prefixes "$DB_PREFIX"

# Create DB VM without public IP (portal is often easier for labs)
echo "Create DB VM (no public IP) in portal or extend this script."
