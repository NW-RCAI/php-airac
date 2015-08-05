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
     * @param DateTime $bearing
     */
    public function testNextDateAirac(\DateTime $date, \DateTime $airac, \DateTime $bearing = null)
    {
        $producer = new Producer($bearing);
        $this->assertSame($producer->next($date)->getTimestamp(), $airac->getTimestamp());
    }

    /**
     * @dataProvider lastDateProvider
     * @param DateTime $date
     * @param DateTime $airac
     * @param DateTime $bearing
     */
    public function testLastDateAirac(\DateTime $date, \DateTime $airac, \DateTime $bearing = null)
    {
        $producer = new Producer($bearing);
        $this->assertSame($producer->last($date)->getTimestamp(), $airac->getTimestamp());
    }

    /**
     * @dataProvider nowDateProvider
     * @param DateTime $date
     * @param DateTime $airac
     * @param DateTime $bearing
     */
    public function testNowDateAirac(\DateTime $date, \DateTime $airac, \DateTime $bearing = null)
    {
        $producer = new Producer($bearing);
        $this->assertSame($producer->now($date)->getTimestamp(), $airac->getTimestamp());
    }

    public function nextDateProvider()
    {
        return [
            [new DateTime('2020-01-07'), new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), new DateTime('2020-01-02')],
            [new DateTime('2014-12-20'), new DateTime('2015-01-08')],
            [new DateTime('2015-01-08'), new DateTime('2015-02-05')],
        ];
    }

    public function lastDateProvider()
    {
        return [
            [new DateTime('2020-01-07'), new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), new DateTime('2020-01-02')],
            [new DateTime('2014-12-20'), new DateTime('2014-11-13')],
            [new DateTime('2015-01-08'), new DateTime('2014-12-11')],
        ];
    }

    public function nowDateProvider()
    {
        return [
            [new DateTime('2020-01-07'), new DateTime('2020-01-02')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), new DateTime('2020-01-02')],
            [new DateTime('2014-12-20'), new DateTime('2014-12-11')],
            [new DateTime('2015-01-08'), new DateTime('2015-01-08')],
        ];
    }
}

