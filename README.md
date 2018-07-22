phpAIRAC
========

[![Build Status](https://travis-ci.org/GetSky/php-airac.svg?branch=1.1)](https://travis-ci.org/GetSky/php-airac) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GetSky/php-airac/badges/quality-score.png?b=1.1)](https://scrutinizer-ci.com/g/GetSky/php-airac/?b=1.1) [![Code Coverage](https://scrutinizer-ci.com/g/GetSky/php-airac/badges/coverage.png?b=1.1)](https://scrutinizer-ci.com/g/GetSky/php-airac/?branch=1.1)

This generator helps you to count the date [AIRAC](https://en.wikipedia.org/wiki/Aeronautical_Information_Publication#AIRAC_effective_dates_.2828-day_cycle.29). it's very easy:

```php
<?php
use GetSky\AIRAC\AiracProducer;

$producer = new AiracProducer();

$nowAirac = $producer->now(new DateTime('2018-04-05'));
// or
$nowAirac = $producer->nowByNumber('1804');  
// return Airac with dateStart 2018-03-29 and number 1804

$nextAirac = $producer->next(new DateTime('2018-01-10'));
// or
$nextAirac = $producer->nextByNumber('1801'); 
// or
$airac = $producer->now(new DateTime('2018-01-10'));
$nextAirac = $producer->nextByAirac($airac); 
// return Airac with dateStart 2018-02-01 and number 1802

$lastAirac = $producer->last(new DateTime('2018-01-10')); 
// or
$lastAirac = $producer->lastByNumber('1801');
// or
$airac = $producer->now(new DateTime('2018-01-10'));
$nextAirac = $producer->lastByAirac($airac); 
// return Airac with dateStart 2017-12-07 and number 1713
```

Installation
------------
Run command:

```
composer require getsky/airac
```

Or add string in your composer.json:

```json
"getsky/airac": "1.1.*"
```

Change bearing date
-------------------
You can change the reference date to shift your cycles:

```php
<?php
use GetSky\AIRAC\AiracProducer;

$producer = new AiracProducer(new DateTime('2015-01-22')); // now cycle shifted by 14 days
```
