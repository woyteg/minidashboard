# Raspberry Pi Web Files - Automated Installer

This repository contains PHP files for your Raspberry Pi web application with an automated installation script.

## Quick Installation

Run this single command on your Raspberry Pi to install/update all files:

```bash
curl -sSL https://raw.githubusercontent.com/YOUR_USERNAME/YOUR_REPO/main/install.sh | sudo bash
```

**Alternative method** (if curl is not available):

```bash
wget -qO- https://raw.githubusercontent.com/YOUR_USERNAME/YOUR_REPO/main/install.sh | sudo bash
```

## What This Script Does

1. ✅ Creates a backup of existing files (saved to `/tmp/webfiles_backup_TIMESTAMP/`)
2. ✅ Changes permissions on existing files that need to be overwritten
3. ✅ Copies new files to the correct locations
4. ✅ Sets proper ownership (`www-data:www-data`)
5. ✅ Sets proper permissions (644)

## Files Installed

### Main Directory (`/var/www/html/`)
- `Mini.php`
- `settings.php`
- `talkgroup_config.php`

### Include Directory (`/var/www/html/include/`)
- `top_menu.php` (overwrites existing)
- `change_tg.php`
- `check_nodes.php`
- `lh.php` (overwrites existing)
- `reflecor_status.php`

## Manual Installation

If you prefer to install manually:

1. Clone this repository:
   ```bash
   git clone https://github.com/YOUR_USERNAME/YOUR_REPO.git
   cd YOUR_REPO
   ```

2. Run the installation script:
   ```bash
   sudo bash install.sh
   ```

## Requirements

- Raspberry Pi with Raspbian/Raspberry Pi OS
- Apache/Nginx web server installed
- SSH access with sudo privileges
- Git installed (automatically installed by script if missing)

## Troubleshooting

**Error: "must be run as root"**
- Make sure to include `sudo` before the command

**Error: "files directory not found"**
- The repository structure may be incorrect. Contact the maintainer.

**Files not showing on website**
- Try restarting the web server: `sudo systemctl restart apache2`

## Backup

The script automatically backs up your existing files before making any changes. Backups are stored in `/tmp/webfiles_backup_TIMESTAMP/`

To restore from backup:
```bash
sudo cp /tmp/webfiles_backup_TIMESTAMP/* /var/www/html/include/
```

## Support

If you encounter any issues, please open an issue on GitHub.
