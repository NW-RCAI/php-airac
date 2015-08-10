phpAIRAC
========
[![Build Status](https://travis-ci.org/GetSky/php-airac.svg)](https://travis-ci.org/GetSky/php-airac) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GetSky/php-airac/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GetSky/php-airac/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/GetSky/php-airac/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GetSky/php-airac/?branch=master)

This generator helps you to count the date [AIRAC](https://en.wikipedia.org/wiki/Aeronautical_Information_Publication#AIRAC_effective_dates_.2828-day_cycle.29). t's very easy:
```php
<?php
use GetSky\AIRAC\Producer;

$producer = new Producer();

$nextAirac = $producer->next(new DateTime('2015-01-10')); // return Airac with DateTime 2015-02-05 and number 1502
$lastAirac = $producer->last(new DateTime('2015-01-10')); // return Airac with DateTime 2015-01-08 and number 1501
$nowAirac = $producer->last(new DateTime('2014-12-20'));  // return Airac with DateTime 2014-12-11 and number 1413
```

Installation
------------
Run command:
```
composer require getsky/airac
```
Or add string in your composer.json:
```json
"getsky/airac": "dev-master"
```

Change bearing date
-------------------
You can change the reference date to shift your cycles:

```php
<?php
use GetSky\AIRAC\Producer;

$producer = new Producer(new DateTime('2015-01-22')); // now cycle shifted by 14 days
```
