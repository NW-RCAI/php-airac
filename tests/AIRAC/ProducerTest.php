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
     * @param DateTime $airacNext
     * @param string $number
     * @param DateTime $bearing
     */
    public function testNextDateAirac(\DateTime $date, \DateTime $airac, \DateTime $airacNext, $number, \DateTime $bearing = null)
    {
        $producer = new Producer($bearing);
        $this->assertSame($producer->next($date)->getDateStart()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->next($date)->getDate()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->next($date)->getDateEnd()->getTimestamp(), $airacNext->getTimestamp());
        $this->assertSame($producer->next($date)->getNumber(), $number);
    }

    /**
     * @dataProvider lastDateProvider
     * @param DateTime $date
     * @param DateTime $airac
     * @param DateTime $airacNext
     * @param $number
     * @param DateTime $bearing
     */
    public function testLastDateAirac(\DateTime $date, \DateTime $airac, \DateTime $airacNext, $number, \DateTime $bearing = null)
    {
        $producer = new Producer($bearing);
        $this->assertSame($producer->last($date)->getDateStart()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->last($date)->getDate()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->last($date)->getDateEnd()->getTimestamp(), $airacNext->getTimestamp());
        $this->assertSame($producer->last($date)->getNumber(), $number);
    }

    /**
     * @dataProvider nowDateProvider
     * @param DateTime $date
     * @param DateTime $airac
     * @param DateTime $airacNext
     * @param $number
     * @param DateTime $bearing
     */
    public function testNowDateAirac(\DateTime $date, \DateTime $airac, \DateTime $airacNext, $number, \DateTime $bearing = null)
    {
        $producer = new Producer($bearing);
        var_dump($producer->now($date)->getDateEnd());
        $this->assertSame($producer->now($date)->getDateStart()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->now($date)->getDate()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->now($date)->getDateEnd()->getTimestamp(), $airacNext->getTimestamp());
        $this->assertSame($producer->now($date)->getNumber(), $number);
    }

    public function nextDateProvider()
    {
        return [
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), new DateTime('2020-02-27'), '2002'],
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), new DateTime('2020-02-27'), '2002', new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), new DateTime('2020-02-27'), '2002',new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-30'), new DateTime('2020-02-27'), '2002',new DateTime('2020-01-02')],
            [new DateTime('2014-12-20'), new DateTime('2015-01-08'), new DateTime('2015-02-05'), '1501'],
            [new DateTime('2015-01-08'), new DateTime('2015-02-05'), new DateTime('2015-03-05'), '1502'],
        ];
    }

    public function lastDateProvider()
    {
        return [
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), new DateTime('2020-01-02'), '1913'],
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), new DateTime('2020-01-02'), '1913', new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), new DateTime('2020-01-02'), '1913', new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2019-12-05'), new DateTime('2020-01-02'), '1913', new DateTime('2020-01-02')],
            [new DateTime('2014-12-20'), new DateTime('2014-11-13'), new DateTime('2014-12-11'), '1412'],
            [new DateTime('2015-01-08'), new DateTime('2014-12-11'), new DateTime('2015-01-08'), '1413'],
        ];
    }

    public function nowDateProvider()
    {
        return [
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), new DateTime('2020-01-30'), '2001'],
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), new DateTime('2020-01-30'), '2001', new DateTime('2019-12-05')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), new DateTime('2020-01-30'), '2001', new DateTime('2020-01-30')],
            [new DateTime('2020-01-07'), new DateTime('2020-01-02'), new DateTime('2020-01-30'), '2001', new DateTime('2020-01-02')],
            [new DateTime('2014-12-20'), new DateTime('2014-12-11'), new DateTime('2015-01-08'), '1413'],
            [new DateTime('2015-01-08'), new DateTime('2015-01-08'), new DateTime('2015-02-05'), '1501'],
        ];
    }
}

