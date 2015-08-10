<?php
namespace GetSky\AIRAC;

/**
 * Class Airac
 * @package GetSky\AIRAC
 */
class Airac
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $number;

    public function __construct(\DateTime $date, $number)
    {
        $this->date = $date;
        $this->number = $number;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
}
