RelativeTime
============
[![Build Status](https://secure.travis-ci.org/mpratt/RelativeTime.png?branch=master)](http://travis-ci.org/mpratt/RelativeTime) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/mpratt/RelativeTime/badges/quality-score.png?s=7d8978c141f211feed8a9226a11e0eaeb5ea2c2d)](https://scrutinizer-ci.com/g/mpratt/RelativeTime/) [![Code Coverage](https://scrutinizer-ci.com/g/mpratt/RelativeTime/badges/coverage.png?s=aacc53653692a9ed3e24851707ead24346124351)](https://scrutinizer-ci.com/g/mpratt/RelativeTime/) [![Latest Stable Version](https://poser.pugx.org/mpratt/relativetime/v/stable.png)](https://packagist.org/packages/mpratt/relativetime) [![Total Downloads](https://poser.pugx.org/mpratt/relativetime/downloads.png)](https://packagist.org/packages/mpratt/relativetime)

RelativeTime is a lightweight and easy to use library that helps you calculate the time difference between two dates and returns the result in words
(like, 5 minutes ago or 5 Minutes left).  The library supports other languages aswell like Spanish and German.

It uses the standard \DateTime() and \DateInterval() classes found in modern PHP versions. For more information, please read the `Usage` section of
this README.

### Requirements
- PHP >= 5.3

Installation
============

### Install with Composer
If you're using [Composer](https://github.com/composer/composer) to manage
dependencies, you can use this library by creating a composer.json file and adding this:

    {
        "require": {
            "mpratt/relativetime": ">=1.0"
        }
    }

Save it and run `composer.phar install`

### Standalone Installation (without Composer)
Download the latest release or clone this repository, place the `Lib/RelativeTime` directory somewhere in your project. Afterwards, you only need to include
the included `Autoload.php` file.

```php
    require '/path/to/RelativeTime/Autoload.php';
    $relativeTime = new \RelativeTime\RelativeTime();
```

Or if you already have PSR-0 complaint autoloader, you just need to register RelativeTime
```php
    $loader->registerNamespace('RelativeTime', 'path/to/RelativeTime');
```

Usage
=====
Most of the times you are going to need the `convert($fromDate, $toDate)` method.
```php
    $relativeTime = new \RelativeTime\RelativeTime();
    echo $relativeTime->convert('2010-09-05', '2010-03-30');
    // 5 months, 6 days ago

    $relativeTime = new \RelativeTime\RelativeTime();
    echo $relativeTime->convert('2012-03-05', '2013/02/05');
    // 11 months left
```

There are 2 other useful methods `timeAgo($date)` and `timeLeft($date)`, that calculate the time since/until
the current date/time.

```php
    // Asumming Today is the 2013-09-23 17:23:47

    $relativeTime = new \RelativeTime\RelativeTime();
    echo $relativeTime->timeAgo('2012-08-29 06:00');
    // 1 year, 25 days, 16 hours, 23 minutes, 13 seconds ago

    $relativeTime = new \RelativeTime\RelativeTime();
    echo $relativeTime->timeLeft('2013-10-31 01:00:05');
    // 1 month, 7 days, 2 hours, 36 minutes, 52 seconds left
```

### Configuration Options
The main object accepts an array with configuration directives

```php
    $config = array(
        'language' => '\RelativeTime\Languages\English',
        'separator' => ', ',
        'suffix' => true,
        'truncate' => 0,
    );

    $relativeTime = new \RelativeTime\RelativeTime($config);
```

| Directive     | Definition
| ------------- |:-------------:
| language      | The language to be used, for example `English`, `Spanish` or `German` are supported. You can give the full class name (with namespaces) or just the last level of the namespace
| separator     | The separator between time units. `, ` by default.
| truncate      | The number of units you want to display. By default it displays all of the available ones.
| suffix        | Wether or not to append the `.... ago` or `..... left`


License
=======
**MIT**
For the full copyright and license information, please view the LICENSE file.

Author
=====
Hi! I'm Michael Pratt and I'm from Colombia!
My [Personal Website](http://www.michael-pratt.com) is in spanish.
