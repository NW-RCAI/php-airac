phpAIRAC
========
## master 
[![Build Status](https://travis-ci.org/GetSky/php-airac.svg?branch=master)](https://travis-ci.org/GetSky/php-airac) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GetSky/php-airac/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GetSky/php-airac/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/GetSky/php-airac/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GetSky/php-airac/?branch=master)
## 1.0 
[![Build Status](https://travis-ci.org/GetSky/php-airac.svg?branch=1.0)](https://travis-ci.org/GetSky/php-airac) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GetSky/php-airac/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/GetSky/php-airac/?branch=1.0) [![Code Coverage](https://scrutinizer-ci.com/g/GetSky/php-airac/badges/coverage.png?b=1.0)](https://scrutinizer-ci.com/g/GetSky/php-airac/?branch=1.0)

This generator helps you to count the date [AIRAC](https://en.wikipedia.org/wiki/Aeronautical_Information_Publication#AIRAC_effective_dates_.2828-day_cycle.29). it's very easy:

```php
<?php
use GetSky\AIRAC\AiracProducer;

$producer = new AiracProducer();

$nextAirac = $producer->next(new DateTime('2018-01-10')); 
// return Airac with DateTime 2018-02-01 and number 1802

$lastAirac = $producer->last(new DateTime('2018-01-10')); 
// return Airac with DateTime 2017-12-07 and number 1713

$nowAirac = $producer->now(new DateTime('2018-04-05'));  
// return Airac with DateTime 2018-03-29 and number 1804

$nextAirac = $producer->nextByNumber('1802'); 
// return Airac with DateTime 2018-02-01 and number 1802

$lastAirac = $producer->lastByNumber('1713'); 
// return Airac with DateTime 2017-12-07 and number 1713

$nowAirac = $producer->nowByNumber('1804');  
// return Airac with DateTime 2018-03-29 and number 1804

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
use GetSky\AIRAC\AiracProducer;

$producer = new AiracProducer(new DateTime('2015-01-22')); // now cycle shifted by 14 days
```
