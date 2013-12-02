<?php
namespace Event\Entity;

use DateTime;

/**
 * Class Event
 *
 * @package Event\Entity
 */
class EventEntity
{
    protected $date;
    protected $description;
    protected $id;
    protected $name;
    protected $seatMatrix;
    protected $seats;
    protected $status;
    protected $time;

    function __construct()
    {
        $seatsPerRow = range('A', 'T');

        $this->seatMatrix = array(
            1  => array_fill_keys($seatsPerRow, false),
            2  => array_fill_keys($seatsPerRow, false),
            3  => array_fill_keys($seatsPerRow, false),
            4  => array_fill_keys($seatsPerRow, false),
            5  => array_fill_keys($seatsPerRow, false),
            6  => array_fill_keys($seatsPerRow, false),
            7  => array_fill_keys($seatsPerRow, false),
            8  => array_fill_keys($seatsPerRow, false),
            9  => array_fill_keys($seatsPerRow, false),
            10 => array_fill_keys($seatsPerRow, false),
            11 => array_fill_keys($seatsPerRow, false),
            12 => array_fill_keys($seatsPerRow, false),
            13 => array_fill_keys($seatsPerRow, false),
            14 => array_fill_keys($seatsPerRow, false),
            15 => array_fill_keys($seatsPerRow, false),
        );
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSeatMatrix()
    {
        return $this->seatMatrix;
    }

    /**
     * @param mixed $seatMatrix
     */
    public function setSeatMatrix($seatMatrix)
    {
        $this->seatMatrix = $seatMatrix;
    }

    /**
     * @return array
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * @param array $seats
     */
    public function setSeats(array $seats)
    {
        if (empty($seats)) {
            $this->seats = $this->seatMatrix;
        } else {
            $this->seats = $seats;
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param DateTime $time
     */
    public function setTime(DateTime $time)
    {
        $this->time = $time;
    }

}