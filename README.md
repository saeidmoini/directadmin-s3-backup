# directadmin-s3-backup

DirectAdmin S3 Backup based on https://github.com/powerkernel/directadmin-s3-backup

## Features

- Auto backup upload to Pars Pack Cloud Bucket

## Installation

```bash
mkdir -p /home/admin/tools/
wget -O /home/admin/tools/s3backup.zip https://github.com/saeidmoini/directadmin-s3-backup/archive/pars-pack.zip
cd /home/admin/tools
unzip s3backup.zip
mv directadmin-s3-backup-pars-pack directadmin-s3-backup
cd directadmin-s3-backup
cp config.sample.php config.php
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
php composer.phar update
mkdir -p /usr/local/directadmin/scripts/custom
wget -O /usr/local/directadmin/scripts/custom/ftp_upload.php https://raw.githubusercontent.com/powerkernel/directadmin-s3-backup/master/upload-script.sh
chmod +x /usr/local/directadmin/scripts/custom/ftp_upload.php
```

Update `config.php` with your ParsPack access keys and bucket name

Finally, go to `DirectAdmin \ Admin Backup/Transfer` to create Cron Schedule backup, select FTP for the backup location.

NOTE: The FTP user/pass is your DirectAdmin admin account & password, FTP IP is `127.0.0.1`.
