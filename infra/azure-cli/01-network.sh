#!/bin/bash
set -euo pipefail

# Fill these or load from infra/parameters.sample.json
RG="rg-mademyday"
LOC="eastus"
VNET="vnet-mademyday"
WEB_SUBNET="web-subnet"
WEB_PREFIX="10.0.1.0/24"

az group create -n "$RG" -l "$LOC"

az network vnet create   -g "$RG" -n "$VNET"   --address-prefix 10.0.0.0/16   --subnet-name "$WEB_SUBNET"   --subnet-prefix "$WEB_PREFIX"

echo "Network created."
