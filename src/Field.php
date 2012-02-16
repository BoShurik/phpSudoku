<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 15.02.12
 * Time: 21:42
 */

class Field
{
    private $number;

    private $changeable;

    public function __construct($number = null, $changeable = true)
    {
        $this->number = $number;
        $this->changeable = $changeable;
    }

    public function __toString()
    {
        $number = is_null($this->number) ? '&nbsp;' : $this->number;

        if ($this->isChangeable())
        {
            return (string)$number;
        }
        else
        {
            return '<strong>'. $this->number .'</strong>';
        }
    }

    public function setNumber($number)
    {
        if ($this->changeable)
        {
            $this->number = $number;

            return true;
        }

        return false;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function isChangeable()
    {
        return $this->changeable;
    }
}
