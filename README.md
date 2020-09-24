# Upload to S3 webhook

## Goal
Allow you to upload folders files to s3 and trigger a webkook containing all upload infos


## Installation

Install box to be able to build the phar cli https://github.com/box-project/box/blob/master/doc/installation.md#installation

Run composer install to install dependency
```bash
$ composer install
```

Update the `php.ini` of php cli (eg: `/etc/php/7.4/cli/php.ini`) to allow phar to edit files
```ini
[Phar]
; http://php.net/phar.readonly
phar.readonly = Off
```

Then build and move the simple-dot.phar file to you /usr/local/bin
```bash
$ box build && \
  chmod +x ./upload-to-s3-webhook.phar.phar && \
  sudo mv ./upload-to-s3-webhook.phar.phar /usr/local/bin/upload-to-s3-webhook.phar
```