# Upload to S3 webhook

## Goal
Allow you to upload folders files to s3 and trigger a webkook containing all upload infos


## Installation

1. [PHAR](#phar)
1. [Phive](#phive)
1. [Composer](#composer)
### PHAR

The preferred method of installation is to use the Box PHAR which can be downloaded from the most recent
[Github Release][releases]. This method ensures you will not have any dependency conflict issue.


### Phive

You can install Box with [Phive][phive]

```bash
$ phive install humbug/box --force-accept-unsigned
```

To upgrade `box` use the following command:

```bash
$ phive update humbug/box --force-accept-unsigned
```


### Composer

You can install with [Composer][composer]:

```bash
$ composer global require humbug/box
```

## Homebrew

To install box using [Homebrew](https://brew.sh), you need to tap the box formula first

```bash
$ brew tap humbug/box
$ brew install box
```

The `box` command is now available to run from anywhere in the system:

```bash
$ box -v
```

To upgrade `box` use the following command:

```bash
$ brew upgrade box
```

<br />
<hr />

« [Table of Contents](../README.md#table-of-contents) • [Configuration](configuration.md#configuration) »


[releases]: https://github.com/humbug/box/releases
[composer]: https://getcomposer.org
[bamarni/composer-bin-plugin]: https://github.com/bamarni/composer-bin-plugin
[phive]: https://github.com/phar-io/phive

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