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
     * @return \DateTime
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
     * @return \DateTime
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
     * @return \DateTime
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
     * @return \DateTime
     */
    private function circle(\DateTime $date, $step)
    {
        $countCircle = floor((($date->getTimestamp() - $this->bearing->getTimestamp()) / (60 * 60 * 24)) / 28) + $step;
        $airac = clone $this->bearing;
        $airac->modify(($countCircle * 28) . ' day');

        return $airac;
    }
}
