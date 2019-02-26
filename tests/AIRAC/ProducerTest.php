<?php

use GetSky\AIRAC\AiracNumberValidationException;
use GetSky\AIRAC\AiracProducer;

class ProducerTest extends PHPUnit_Framework_TestCase
{
    public function testCreateProducer()
    {
        $producer = new AiracProducer();
        $this->assertSame($producer->getBearingDate()->getTimestamp(), (new DateTime('2016-01-07'))->getTimestamp());
    }

    public function testCreateProducerWithBearingAIRAC()
    {
        $bearing = new DateTime('2020-01-02');
        $producer = new AiracProducer($bearing);
        $this->assertSame($producer->getBearingDate()->getTimestamp(), $bearing->getTimestamp());
    }

    /**
     * @dataProvider nextDateProvider
     * @param DateTime $date
     * @param DateTime $airac
     * @param DateTime $airacNext
     * @param string $number
     * @param DateTime $bearing
     * @throws Exception
     */
    public function testNextDateAirac(\DateTime $date, \DateTime $airac, \DateTime $airacNext, $number, \DateTime $bearing = null)
    {
        $producer = new AiracProducer($bearing);
        $this->assertSame($producer->next($date)->getDateStart()->getTimestamp(), $airac->getTimestamp());
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
     * @throws Exception
     */
    public function testLastDateAirac(\DateTime $date, \DateTime $airac, \DateTime $airacNext, $number, \DateTime $bearing = null)
    {
        $producer = new AiracProducer($bearing);
        $this->assertSame($producer->last($date)->getDateStart()->getTimestamp(), $airac->getTimestamp());
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
        $producer = new AiracProducer($bearing);
        $this->assertSame($producer->now($date)->getDateStart()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->now($date)->getDateEnd()->getTimestamp(), $airacNext->getTimestamp());
        $this->assertSame($producer->now($date)->getNumber(), $number);
    }

    /**
     * @dataProvider nowDateProvider
     * @param DateTime $date
     * @param DateTime $airac
     * @param DateTime $airacNext
     * @param $number
     * @param DateTime $bearing
     * @throws AiracNumberValidationException
     */
    public function testNowDateAiracByNumber(\DateTime $date, \DateTime $airac, \DateTime $airacNext, $number, \DateTime $bearing = null)
    {
        $producer = new AiracProducer($bearing);
        $this->assertSame($producer->nowByNumber($number)->getDateStart()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->nowByNumber($number)->getDateEnd()->getTimestamp(), $airacNext->getTimestamp());
        $this->assertSame($producer->nowByNumber($number)->getNumber(), $number);
    }

    /**
     * @dataProvider lastDateProviderForNumber
     * @param DateTime $airac
     * @param DateTime $airacNext
     * @param $number
     * @param $lastNumber
     * @param DateTime $bearing
     * @throws AiracNumberValidationException
     */
    public function testLastDateAiracByNumber(\DateTime $airac, \DateTime $airacNext, $number, $lastNumber, \DateTime $bearing = null)
    {
        $producer = new AiracProducer($bearing);
        $this->assertSame($producer->lastByNumber($number)->getDateStart()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->lastByNumber($number)->getDateEnd()->getTimestamp(), $airacNext->getTimestamp());
        $this->assertSame($producer->lastByNumber($number)->getNumber(), $lastNumber);
    }

    /**
     * @dataProvider lastDateProviderForAirac
     * @param DateTime $airac
     * @param DateTime $airacNext
     * @param $number
     * @param $lastNumber
     * @param DateTime $bearing
     */
    public function testLastDateAiracByAirac(\DateTime $airac, \DateTime $airacNext, $lastNumber, \DateTime $bearing = null)
    {
        $producer = new AiracProducer($bearing);
        $cAirac = new \GetSky\AIRAC\Airac($airacNext, $airac, $lastNumber);
        $this->assertSame($producer->lastByAirac($cAirac)->getDateStart()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->lastByAirac($cAirac)->getDateEnd()->getTimestamp(), $airacNext->getTimestamp());
        $this->assertSame($producer->lastByAirac($cAirac)->getNumber(), $lastNumber);
    }

    /**
     * @dataProvider nextDateProviderForNumber
     * @param DateTime $airac
     * @param DateTime $airacNext
     * @param $number
     * @param $nextNumber
     * @param DateTime|null $bearing
     * @throws AiracNumberValidationException
     */
    public function testNextDateAiracByNumber(\DateTime $airac, \DateTime $airacNext, $number, $nextNumber, \DateTime $bearing = null)
    {
        $producer = new AiracProducer($bearing);
        $this->assertSame($producer->nextByNumber($number)->getDateStart()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->nextByNumber($number)->getDateEnd()->getTimestamp(), $airacNext->getTimestamp());
        $this->assertSame($producer->nextByNumber($number)->getNumber(), $nextNumber);
    }

    /**
     * @dataProvider nextDateProviderForAirac
     * @param DateTime $startAirac
     * @param DateTime $airac
     * @param DateTime $airacNext
     * @param $nextNumber
     * @param DateTime|null $bearing
     */
    public function testNextDateAiracByAirac(\DateTime $startAirac, \DateTime $airac, \DateTime $airacNext, $nextNumber, \DateTime $bearing = null)
    {
        $producer = new AiracProducer($bearing);
        $cAirac = new \GetSky\AIRAC\Airac($startAirac, $airacNext, $nextNumber);
        $this->assertSame($producer->nextByAirac($cAirac)->getDateStart()->getTimestamp(), $airac->getTimestamp());
        $this->assertSame($producer->nextByAirac($cAirac)->getDateEnd()->getTimestamp(), $airacNext->getTimestamp());
        $this->assertSame($producer->nextByAirac($cAirac)->getNumber(), $nextNumber);
    }

    /**
     * @dataProvider dateProviderForException
     * @param $circle
     * @throws AiracNumberValidationException
     */
    public function testAiracNumberValidationException($circle)
    {
        $this->expectException(AiracNumberValidationException::class);
        $producer = new AiracProducer();
        $producer->nextByNumber($circle);
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

    public function lastDateProviderForNumber()
    {
        return [
            [new DateTime('2019-12-05'), new DateTime('2020-01-02'), '2001', '1913'],
            [new DateTime('2019-12-05'), new DateTime('2020-01-02'), '2001', '1913', new DateTime('2019-12-05')],
            [new DateTime('2019-12-05'), new DateTime('2020-01-02'), '2001', '1913', new DateTime('2020-01-30')],
            [new DateTime('2019-12-05'), new DateTime('2020-01-02'), '2001', '1913', new DateTime('2020-01-02')],
            [new DateTime('2014-11-13'), new DateTime('2014-12-11'), '1413', '1412'],
            [new DateTime('2014-12-11'), new DateTime('2015-01-08'), '1501', '1413'],
        ];
    }

    public function lastDateProviderForAirac()
    {
        return [
            [new DateTime('2019-12-05'), new DateTime('2020-01-02'), '1913'],
            [new DateTime('2019-12-05'), new DateTime('2020-01-02'), '1913', new DateTime('2019-12-05')],
            [new DateTime('2019-12-05'), new DateTime('2020-01-02'), '1913', new DateTime('2020-01-30')],
            [new DateTime('2019-12-05'), new DateTime('2020-01-02'), '1913', new DateTime('2020-01-02')],
            [new DateTime('2014-11-13'), new DateTime('2014-12-11'), '1412'],
            [new DateTime('2014-12-11'), new DateTime('2015-01-08'), '1413'],
        ];
    }

    public function nextDateProviderForNumber()
    {
        return [
            [new DateTime('2020-02-27'), new DateTime('2020-03-26'), '2002', '2003'],
            [new DateTime('2020-02-27'), new DateTime('2020-03-26'), '2002', '2003', new DateTime('2019-12-05')],
            [new DateTime('2020-02-27'), new DateTime('2020-03-26'), '2002', '2003', new DateTime('2020-01-30')],
            [new DateTime('2020-02-27'), new DateTime('2020-03-26'), '2002', '2003', new DateTime('2020-01-02')],
            [new DateTime('2015-02-05'), new DateTime('2015-03-05'), '1501', '1502'],
            [new DateTime('2015-03-05'), new DateTime('2015-04-02'), '1502', '1503'],
        ];
    }

    public function nextDateProviderForAirac()
    {
        return [
            [new DateTime('2020-01-30'), new DateTime('2020-02-27'), new DateTime('2020-03-26'), '2003'],
            [new DateTime('2020-01-30'), new DateTime('2020-02-27'), new DateTime('2020-03-26'), '2003', new DateTime('2019-12-05')],
            [new DateTime('2020-01-30'), new DateTime('2020-02-27'), new DateTime('2020-03-26'), '2003', new DateTime('2020-01-30')],
            [new DateTime('2020-01-30'), new DateTime('2020-02-27'), new DateTime('2020-03-26'), '2003', new DateTime('2020-01-02')],
            [new DateTime('2015-02-04'), new DateTime('2015-02-05'), new DateTime('2015-03-05'), '1502'],
            [new DateTime('2015-03-04'), new DateTime('2015-03-05'), new DateTime('2015-04-02'), '1503'],
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

    public function dateProviderForException()
    {
        return [['cd34'], ['12cd'], ['1'], ['d'], ['54'], ['54d'], ['123']];
    }
}

