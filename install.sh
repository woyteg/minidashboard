#!/bin/bash
# Automated Installation Script for Raspberry Pi Web Files
# This script installs/updates PHP files for your web application

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo "=========================================="
echo "  Installation Script for Web Files"
echo "=========================================="
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}ERROR: This script must be run as root${NC}"
    echo "Please run: curl -sSL https://raw.githubusercontent.com/woyteg/minidashboard/main/install.sh | sudo bash"
    exit 1
fi

# Create backup directory with timestamp
BACKUP_DIR="/tmp/webfiles_backup_$(date +%Y%m%d_%H%M%S)"
echo -e "${YELLOW}Creating backup directory: $BACKUP_DIR${NC}"
mkdir -p "$BACKUP_DIR"

# Backup existing files if they exist
echo "Backing up existing files (if any)..."
[ -f /var/www/html/mini.php ] && cp /var/www/html/mini.php "$BACKUP_DIR/"
[ -f /var/www/html/settings.php ] && cp /var/www/html/settings.php "$BACKUP_DIR/"
[ -f /var/www/html/talkgroup_config.php ] && cp /var/www/html/talkgroup_config.php "$BACKUP_DIR/"
[ -f /var/www/html/include/top_menu.php ] && cp /var/www/html/include/top_menu.php "$BACKUP_DIR/"
[ -f /var/www/html/include/change_tg.php ] && cp /var/www/html/include/change_tg.php "$BACKUP_DIR/"
[ -f /var/www/html/include/check_nodes.php ] && cp /var/www/html/include/check_nodes.php "$BACKUP_DIR/"
[ -f /var/www/html/include/lh.php ] && cp /var/www/html/include/lh.php "$BACKUP_DIR/"
[ -f /var/www/html/include/reflecor_status.php ] && cp /var/www/html/include/reflecor_status.php "$BACKUP_DIR/"

echo -e "${GREEN}Backup complete!${NC}"
echo ""

# Check if unzip is installed, install if needed
if ! command -v unzip &> /dev/null; then
    echo "Installing unzip package..."
    apt-get update -qq
    apt-get install -y unzip
fi

# Download files from GitHub
echo "Downloading files from GitHub..."
cd /tmp
rm -rf webfiles_temp
mkdir -p webfiles_temp
cd webfiles_temp

# Download the repository as a zip file
echo "Downloading repository archive..."
wget -q https://github.com/woyteg/minidashboard/archive/refs/heads/main.zip -O repo.zip

# Check if download was successful
if [ ! -f "repo.zip" ]; then
    echo -e "${RED}ERROR: Failed to download repository${NC}"
    echo "Please check that your repository is PUBLIC and the URL is correct"
    exit 1
fi

# Extract the zip file
echo "Extracting files..."
unzip -q repo.zip

# Move into the extracted directory (GitHub adds -main to the folder name)
cd minidashboard-main

# Check if files exist in repo
if [ ! -d "files" ]; then
    echo -e "${RED}ERROR: 'files' directory not found in repository${NC}"
    exit 1
fi

# Change permissions for existing files that will be overwritten
echo "Preparing existing files for update..."
[ -f /var/www/html/include/top_menu.php ] && chmod 777 /var/www/html/include/top_menu.php
[ -f /var/www/html/include/lh.php ] && chmod 777 /var/www/html/include/lh.php

# Ensure target directories exist
echo "Ensuring target directories exist..."
mkdir -p /var/www/html/include

# Copy files to /var/www/html/
echo "Copying files to /var/www/html/..."
cp files/html/mini.php /var/www/html/
cp files/html/settings.php /var/www/html/
cp files/html/talkgroup_config.php /var/www/html/

# Copy files to /var/www/html/include/
echo "Copying files to /var/www/html/include/..."
cp files/html/include/top_menu.php /var/www/html/include/
cp files/html/include/change_tg.php /var/www/html/include/
cp files/html/include/check_nodes.php /var/www/html/include/
cp files/html/include/lh.php /var/www/html/include/
cp files/html/include/reflecor_status.php /var/www/html/include/

# Set proper ownership (www-data is the default web server user)
echo "Setting proper file ownership..."
chown -R www-data:www-data /var/www/html/mini.php
chown -R www-data:www-data /var/www/html/settings.php
chown -R www-data:www-data /var/www/html/talkgroup_config.php
chown -R www-data:www-data /var/www/html/include/top_menu.php
chown -R www-data:www-data /var/www/html/include/change_tg.php
chown -R www-data:www-data /var/www/html/include/check_nodes.php
chown -R www-data:www-data /var/www/html/include/lh.php
chown -R www-data:www-data /var/www/html/include/reflecor_status.php

# Set proper permissions (644 for PHP files is standard)
echo "Setting proper file permissions..."
chmod 644 /var/www/html/mini.php
chmod 644 /var/www/html/settings.php
chmod 644 /var/www/html/talkgroup_config.php
chmod 644 /var/www/html/include/top_menu.php
chmod 644 /var/www/html/include/change_tg.php
chmod 644 /var/www/html/include/check_nodes.php
chmod 644 /var/www/html/include/lh.php
chmod 644 /var/www/html/include/reflecor_status.php

# Cleanup
echo "Cleaning up temporary files..."
cd /tmp
rm -rf webfiles_temp

echo ""
echo -e "${GREEN}=========================================="
echo -e "  Installation Complete!"
echo -e "==========================================${NC}"
echo ""
echo "Files installed successfully!"
echo -e "Backup location: ${YELLOW}$BACKUP_DIR${NC}"
echo ""
echo "Installed files:"
echo "  - /var/www/html/mini.php"
echo "  - /var/www/html/settings.php"
echo "  - /var/www/html/talkgroup_config.php"
echo "  - /var/www/html/include/top_menu.php"
echo "  - /var/www/html/include/change_tg.php"
echo "  - /var/www/html/include/check_nodes.php"
echo "  - /var/www/html/include/lh.php"
echo "  - /var/www/html/include/reflecor_status.php"
echo ""
