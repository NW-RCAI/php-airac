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
    private $dateStart;
    
    /**
     * @var \DateTime
     */
    private $dateEnd;

    /**
     * @var string
     */
    private $number;

    public function __construct(\DateTime $dateStart, \DateTime $dateEnd, $number)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->number = $number;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }
    
    /**
     * @deprecated Use getDataStart()
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->dateStart;
    }
    
    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
}
