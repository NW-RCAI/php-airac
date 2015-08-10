<?php

use GetSky\AIRAC\Producer;

class ProducerTest extends PHPUnit_Framework_TestCase
{
    public function testCreateProducer()
    {
        $producer = new Producer();
        $this->assertSame($producer->getBearingDate()->getTimestamp(), (new DateTime('2016-01-07'))->getTimestamp());
    }

    public function testCreateProducerWithBearingAIRAC()
    {
        $bearing = new DateTime('2020-01-02');
        $producer = new Producer($bearing);
        $this->assertSame($producer->getBearingDate()->getTimestamp(), $bearing->getTimestamp());
    }

    /**
     * @dataProvider nextDateProvider
     * @param DateTime $date
     * @param DateTime $airac
     * @param string $number
     * @param DateTime $bearing
     */
    public function testNextDateAirac(\DateTime $date, \DateTime $airac, $number, \DateTime $bearing = null)
    {
        $producer = new Producer($bearing);
        $this->assertSame($producer->next($date)->getDate()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->next($date)->getNumber(), $number);
    }

    /**
     * @dataProvider lastDateProvider
     * @param DateTime $date
     * @param DateTime $airac
     * @param $number
     * @param DateTime $bearing
     */
    public function testLastDateAirac(\DateTime $date, \DateTime $airac, $number, \DateTime $bearing = null)
    {
        $producer = new Producer($bearing);
        $this->assertSame($producer->last($date)->getDate()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->last($date)->getNumber(), $number);
    }

    /**
     * @dataProvider nowDateProvider
     * @param DateTime $date
     * @param DateTime $airac
     * @param $number
     * @param DateTime $bearing
     */
    public function testNowDateAirac(\DateTime $date, \DateTime $airac, $number, \DateTime $bearing = null)
    {
        $producer = new Producer($bearing);
        $this->assertSame($producer->now($date)->getDate()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->now($date)->getNumber(), $number);
    }

    public function nextDateProvider()
    {
        return [
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), '2002'],
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), '2002', new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), '2002',new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), '2002',new DateTime('2020-01-02')],
            [new DateTime('2014-12-20'), new DateTime('2015-01-08'), '1501'],
            [new DateTime('2015-01-08'), new DateTime('2015-02-05'), '1502'],
        ];
    }

    public function lastDateProvider()
    {
        return [
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), '1913'],
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), '1913', new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), '1913', new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), '1913', new DateTime('2020-01-02')],
            [new DateTime('2014-12-20'), new DateTime('2014-11-13'), '1412'],
            [new DateTime('2015-01-08'), new DateTime('2014-12-11'), '1413'],
        ];
    }

    public function nowDateProvider()
    {
        return [
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), '2001'],
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), '2001', new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), '2001', new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), '2001', new DateTime('2020-01-02')],
            [new DateTime('2014-12-20'), new DateTime('2014-12-11'), '1413'],
            [new DateTime('2015-01-08'), new DateTime('2015-01-08'), '1501'],
        ];
    }
}

