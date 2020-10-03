# Upload to S3 webhook ![PHP Test](https://github.com/David-Crty/upload-to-s3-webhook/workflows/PHP%20Test/badge.svg)

## Goal
Allow you to upload folders & files to s3 and trigger a webkook containing all upload infos


## Installation
#### Docker run
```bash
docker run --rm  \
    -v ~/my-local-folder:/upload \
    -e AWS_REGION=eu-central-1 \
    -e AWS_ID=XXX \
    -e AWS_PRIVATE=XXX \
    -e AWS_BUCKET=XXX \
    -e WEBHOOK_ENDPOINT=https://my-host.com/webhook \
    davidcrty/uptoload-to-s3-webhook:latest upload-to-s3-webhook upload /upload
```
___
#### Cloning repo & build phar

```bash
git clone https://github.com/David-Crty/upload-to-s3-webhook
composer install
```
Create a .env.local to overright the env values :
```text
AWS_REGION=eu-central-1
AWS_ID=XXX
AWS_PRIVATE=XXX
AWS_BUCKET=XXX
WEBHOOK_ENDPOINT=https://my-host.com/webhook
``` 
##### Build phar (optional, you can just use ./bin/main upload)
(maybe you need to update the php.ini of php cli (eg: /etc/php/7.4/cli/php.ini) to allow phar to edit files)
```text
[Phar]
; http://php.net/phar.readonly
phar.readonly = Off
```
```bash
composer run compile
```


## Use
Execute script like this

```bash
./upload-to-s3-webhook.phar upload ./composer.json
```
Will upload file to s3 and call webhook with POST application/json
```json
{
  "name": "composer.lock",
  "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/composer.lock",
  "size": 147130,
  "mineType": "text/plain",
  "s3Key": "composer-lock/composer-lock_5f776fa525f36"
}
```
---
```bash
./upload-to-s3-webhook.phar upload ./src
```
Will upload src folder to s3 and call webhook with POST application/json
```json
{
  "name": "src",
  "files": [
    {
      "name": "ScanPath.php",
      "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/ScanPath.php",
      "size": 1813,
      "mineType": "text/x-php",
      "s3Key": "src/scanpath-php_5f776dc1b0fd3"
    },
    {
      "name": "Serializer.php",
      "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/Serializer.php",
      "size": 965,
      "mineType": "text/x-php",
      "s3Key": "src/serializer-php_5f776dc2c33be"
    },
    {
      "name": "UploadToS3.php",
      "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/UploadToS3.php",
      "size": 1395,
      "mineType": "text/x-php",
      "s3Key": "src/uploadtos3-php_5f776dc3aa07e"
    },
    {
      "name": "WebHook.php",
      "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/WebHook.php",
      "size": 855,
      "mineType": "text/x-php",
      "s3Key": "src/webhook-php_5f776dc5c8472"
    },
    {
      "name": "bootstrap.php",
      "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/bootstrap.php",
      "size": 1203,
      "mineType": "text/x-php",
      "s3Key": "src/bootstrap-php_5f776dc6cd606"
    }
  ],
  "folders": [
    {
      "name": "Command",
      "files": [
        {
          "name": "UploadCommand.php",
          "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/Command/UploadCommand.php",
          "size": 1903,
          "mineType": "text/x-php",
          "s3Key": "src/uploadcommand-php_5f776dc7c3244"
        }
      ],
      "folders": []
    },
    {
      "name": "Helper",
      "files": [
        {
          "name": "Env.php",
          "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/Helper/Env.php",
          "size": 199,
          "mineType": "text/x-php",
          "s3Key": "src/env-php_5f776dc8b6bb1"
        }
      ],
      "folders": []
    },
    {
      "name": "Model",
      "files": [
        {
          "name": "File.php",
          "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/Model/File.php",
          "size": 2907,
          "mineType": "text/x-php",
          "s3Key": "src/file-php_5f776dc9c1b09"
        },
        {
          "name": "Folder.php",
          "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/Model/Folder.php",
          "size": 3651,
          "mineType": "text/x-php",
          "s3Key": "src/folder-php_5f776dcaafb78"
        },
        {
          "name": "ResourceInterface.php",
          "realPath": "/home/david/Sites/op-serv/upload-to-s3-webhook/src/Model/ResourceInterface.php",
          "size": 99,
          "mineType": "text/x-php",
          "s3Key": "src/resourceinterface-ph_5f776dcc182cc"
        }
      ],
      "folders": []
    }
  ]
}
```
## Test

You can test it with phpunit

```bash
phpunit
```