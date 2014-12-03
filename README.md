KIMS (Karate Information Management System)
===========================================

Yii 2 Basic Application Template is a skeleton Yii 2 application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

REQUIREMENTS
------------

PHP 5.4.0+
[Composer](https://getcomposer.org): php -r "readfile('https://getcomposer.org/installer');" | php
To create initial /vendor dir: php composer.phar install


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources




INSTALLATION
------------

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

## Setting up composer globally via brew on OSX

OSX: install [homebrew](http://brew.sh/), then run (from the official composer install instructions):

```
brew update
brew tap homebrew/dupes
brew tap homebrew/php
brew install composer
```

Homebrew installs an old version of composer globally. If you try to run it you'll probably get memory errors. You can update composer to get around it:

~~~
composer selfupdate
~~~


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
	'class' => 'yii\db\Connection',
	'dsn' => 'mysql:host=localhost;dbname=yii2basic',
	'username' => 'root',
	'password' => '1234',
	'charset' => 'utf8',
];
```

**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.

Also check and edit the other files in the `config/` directory to customize your application.
