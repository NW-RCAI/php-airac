<?php
namespace GetSky\AIRAC;

/**
 * Class Producer
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
     */
    public function __construct(\DateTime $bearing = null)
    {
         $this->bearing = $bearing ? $bearing : new \DateTime('2016-01-07');
    }

    /**
     * @return \DateTime
     */
    public function getBearingDate()
    {
        return $this->bearing;
    }

    /**
     * Get next AIRAC date.
     *
     * @param \DateTime $date
     *
     * @return Airac
     */
    public function next(\DateTime $date)
    {
        return $this->circle($date, 1);
    }

    /**
     * Get current AIRAC date.
     *
     * @param \DateTime $date
     *
     * @return Airac
     */
    public function now(\DateTime $date)
    {
        return $this->circle($date, 0);
    }

    /**
     * Get last AIRAC date.
     *
     * @param \DateTime $date
     *
     * @return Airac
     */
    public function last(\DateTime $date)
    {
        return $this->circle($date, -1);
    }

    /**
     * Generator AIRAC dates.
     *
     * @param \DateTime $date
     * @param $step
     *
     * @return Airac
     */
    private function circle(\DateTime $date, $step)
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
     *Calculated number of AIRAC.
     *
     * @param \DateTime $date
     *
     * @return string
     */
    private function calcNumber(\DateTime $date)
    {
        $year = \DateTime::createFromFormat('!Y', $date->format('Y'));
        $number = 1 + floor($year->diff($date)->days / 28);
        
        return $year->format('y') . sprintf("%02d", $number);
    }
}
