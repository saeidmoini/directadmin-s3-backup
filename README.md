# DirectAdmin S3 Backup

DirectAdmin S3 Backup is a tool designed to automate the process of uploading backups to the Pars Pack Cloud Bucket using the S3 platform. This package integrates seamlessly with DirectAdmin, enabling administrators to schedule and manage backups efficiently.

## Features

- **Automated Backup Uploads**: Automatically upload backups to your Pars Pack Cloud Bucket.
- **DirectAdmin Integration**: Easily integrate with DirectAdmin's Admin Backup/Transfer feature.
- **Customizable Configuration**: Configure your Pars Pack access keys and bucket name for a tailored experience.

## Installation

Follow these steps to install and set up the package:

```bash
# Create a tools directory for the package
mkdir -p /home/admin/tools/

# Download the package
wget -O /home/admin/tools/s3backup.zip https://github.com/saeidmoini/directadmin-s3-backup/archive/master.zip

# Extract the package
cd /home/admin/tools
unzip s3backup.zip
mv directadmin-s3-backup-master directadmin-s3-backup
cd directadmin-s3-backup

# Copy the sample configuration file
cp config.sample.php config.php

# Install Composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Update dependencies
php composer.phar update

# Set up custom scripts for DirectAdmin
mkdir -p /usr/local/directadmin/scripts/custom
cp -f "/home/admin/tools/directadmin-s3-backup/ftp_upload.php" /usr/local/directadmin/scripts/custom/ftp_upload.php
cp -f "/home/admin/tools/directadmin-s3-backup/ftp_list.php" /usr/local/directadmin/scripts/custom/ftp_list.php
chmod +x /usr/local/directadmin/scripts/custom/ftp_upload.php
chmod +x /usr/local/directadmin/scripts/custom/ftp_list.php
```

Update `config.php` with your ParsPack access keys and bucket name

Finally, go to `DirectAdmin \ Admin Backup/Transfer` to create Cron Schedule backup, select FTP for the backup location.

NOTE: The FTP user/pass is your DirectAdmin admin account & password, FTP IP is `127.0.0.1`.
