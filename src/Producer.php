<?php
namespace GetSky\AIRAC;

/**
 * Class Producer
 * @deprecated Use AiracProducer. This class will be removed in version 1.2.0
 * @package GetSky\AIRAC
 */
class Producer
{
    /**
     * @var \DateTime
     */
    private $bearing;

    /**
     * @param \DateTime|null $bearing
     * @throws \Exception
     */
    public function __construct(\DateTime $bearing = null)
    {
         $this->bearing = $bearing ? $bearing : new \DateTime('2016-01-07');
    }

    /**
     * @return \DateTime
     */
    public function getBearingDate(): \DateTime
    {
        return $this->bearing;
    }

    /**
     * Get next AIRAC date.
     *
     * @param \DateTime $date
     * @return Airac
     */
    public function next(\DateTime $date): Airac
    {
        return $this->circle($date, 1);
    }

    /**
     * Get next AIRAC date.
     *
     * @param string $number
     * @return Airac
     * @throws AiracNumberValidationException
     */
    public function nextByNumber(string $number): Airac
    {
        return $this->circleByNumber($number, 1);
    }

    /**
     * Get next AIRAC date.
     *
     * @param Airac $airac
     * @return Airac
     */
    public function nextByAirac(Airac $airac): Airac
    {
        return $this->circle($airac->getDateStart(), 1);
    }

    /**
     * Get current AIRAC date.
     *
     * @param \DateTime $date
     * @return Airac
     */
    public function now(\DateTime $date): Airac
    {
        return $this->circle($date, 0);
    }

    /**
     * Get current AIRAC date.
     *
     * @param string $number
     * @return Airac
     * @throws AiracNumberValidationException
     */
    public function nowByNumber(string $number): Airac
    {
        return $this->circleByNumber($number, 0);
    }

    /**
     * Get last AIRAC date.
     *
     * @param \DateTime $date
     * @return Airac
     */
    public function last(\DateTime $date): Airac
    {
        return $this->circle($date, -1);
    }

    /**
     * Get last AIRAC date.
     *
     * @param string $number
     * @return Airac
     * @throws AiracNumberValidationException
     */
    public function lastByNumber(string $number): Airac
    {
        return $this->circleByNumber($number, -1);
    }

    /**
     * Get last AIRAC date.
     *
     * @param Airac $airac
     * @return Airac
     */
    public function lastByAirac(Airac $airac): Airac
    {
        return $this->circle($airac->getDateStart(), -1);
    }

    /**
     * Generator AIRAC dates.
     *
     * @param \DateTime $date
     * @param $step
     * @return Airac
     */
    private function circle(\DateTime $date, int $step): Airac
    {
        $positive = ($date >= $this->bearing) ? 1 : -1;
        $days = $date->diff($this->bearing)->days;
        $countCircle = $positive * floor($days / 28) + $step - (($positive < 0 && $days % 28 != 0) ? 1 : 0);
        $dateStart = clone $this->bearing;
        $dateStart->modify(($countCircle * 28) . ' day');
        $dateEnd = clone $dateStart;
        $dateEnd->modify('28 day');

        return new Airac($dateStart, $dateEnd, $this->calcNumber($dateStart));
    }

    /**
     * Generator AIRAC dates.
     *
     * @param string $number
     * @param int $step
     * @return Airac
     * @throws AiracNumberValidationException
     */
    private function circleByNumber(string $number, int $step): Airac
    {
        $date = \DateTime::createFromFormat('!y', substr($number, 0, 2));
        if (preg_match("/[0-9]{4}/", $number) === 0 || $date === false) {
            throw new AiracNumberValidationException("Number '$number' isn't correct AIRAC.");
        }

        return $this->circle($date, $step + substr($number, 2, 2));
    }

    /**
     *Calculated number of AIRAC.
     *
     * @param \DateTime $date
     * @return string
     */
    private function calcNumber(\DateTime $date): string
    {
        $year = \DateTime::createFromFormat('!Y', $date->format('Y'));
        $number = 1 + floor($year->diff($date)->days / 28);
        
        return $year->format('y') . sprintf("%02d", $number);
    }
}
