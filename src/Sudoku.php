<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 15.02.12
 * Time: 21:34
 */

class Sudoku
{
    const MAX_WIDTH     = 9;
    const MAX_HEIGHT    = 9;

    private $matrix;

    public function __construct($matrix = null)
    {
        if (!is_null($matrix))
        {
            for ($i = 0; $i < self::MAX_HEIGHT; $i++)
            {
                for ($j = 0; $j < self::MAX_WIDTH; $j++)
                {
                    if (isset($matrix[$j][$i]))
                    {
                        if ($matrix[$j][$i] instanceof Field)
                        {
                            $this->matrix[$j][$i] = $matrix[$j][$i];
                        }
                        else if (($matrix[$j][$i]) > 0 && ($matrix[$j][$i] < 10))
                        {
                            $this->matrix[$j][$i] = new Field($matrix[$j][$i], false);
                        }
                        else
                        {
                            $this->matrix[$j][$i] = new Field();
                        }
                    }
                    else
                    {
                        $this->matrix[$j][$i] = new Field();
                    }
                }
            }
        }
        else
        {
            for ($i = 0; $i < self::MAX_HEIGHT; $i++)
            {
                for ($j = 0; $j < self::MAX_WIDTH; $j++)
                {
                    $this->matrix[$j][$i] = new Field();
                }
            }
        }
    }

    public function isSolved()
    {
        for ($i = 0; $i < self::MAX_HEIGHT; $i++)
        {
            for ($j = 0; $j < self::MAX_WIDTH; $j++)
            {
                if ($this->matrix[$i][$j]->getNumber() == null)
                {
                    return false;
                }
            }
        }

        for ($i = 0; $i < self::MAX_WIDTH; $i++)
        {
            $colNumbers = array();
            for ($j = 0; $j < self::MAX_HEIGHT; $j++)
            {
                if (in_array($this->matrix[$i][$j]->getNumber(), $colNumbers))
                {
                    return false;
                }

                $colNumbers[] = $this->matrix[$i][$j]->getNumber();
            }
        }

        for ($i = 0; $i < self::MAX_HEIGHT; $i++)
        {
            $rowNumbers = array();
            for ($j = 0; $j < self::MAX_WIDTH; $j++)
            {
                if (in_array($this->matrix[$j][$i]->getNumber(), $rowNumbers))
                {
                    return false;
                }

                $rowNumbers[] = $this->matrix[$j][$i]->getNumber();
            }
        }

        for ($q = 0; $q < 9; $q++)
        {
            $ki = $q % 3;
            $kj = floor($q / 3);

            for ($i = 0; $i < 3; $i++)
            {
                $squareNumbers = array();
                for ($j = 0; $j < 3; $j++)
                {
                    if (in_array($this->matrix[$j + 3 * $kj][$i + 3 * $ki]->getNumber(), $squareNumbers))
                    {
                        return false;
                    }

                    $squareNumbers[] = $this->matrix[$j + 3 * $kj][$i + 3 * $ki]->getNumber();
                }
            }
        }

        return true;
    }

    private function solveRecursive($x, $y)
    {
        $final = false;

        $nextX = ($x + 1) % self::MAX_WIDTH;

        if ((($x + 1) / self::MAX_WIDTH) >= 1)
        {
            $nextY = $y + 1;
            if (($nextY / self::MAX_WIDTH) >= 1)
            {
                $final = true;
            }
        }
        else
        {
            $nextY = $y;
        }

        if ($this->matrix[$x][$y]->isChangeable())
        {
            $availableNumbers = $this->getAvailableNumbers($x, $y);
            foreach ($availableNumbers as $number)
            {
                $this->matrix[$x][$y]->setNumber($number);
                if (!$final)
                {
                    $result = $this->solveRecursive($nextX, $nextY);
                    if ($result)
                    {
                        return true;
                    }
                    else
                    {
                        $this->matrix[$x][$y]->setNumber(null);
                    }
                }
                else
                {
                    $result = $this->isSolved();
                    if ($result)
                    {
                        return true;
                    }
                }
            }

            return false;
        }

        if (!$final)
        {
            return $this->solveRecursive($nextX, $nextY);
        }
        else
        {
            return $this->isSolved();
        }
    }

    public function solve()
    {
        return $this->solveRecursive(0, 0);
    }

    public function getAvailableNumbers($x, $y)
    {
        if (!$this->matrix[$x][$y]->isChangeable())
        {
            return array();
        }

        $availableNumbers = range(1, 9);

        for ($i = 0; $i < self::MAX_WIDTH; $i++)
        {
            if ($i != $x)
            {
                $number = $this->matrix[$i][$y]->getNumber();
                $key = array_search($number, $availableNumbers);
                if ($key !== false)
                {
                    unset($availableNumbers[$key]);
                }
            }
        }

        if (empty($availableNumbers))
        {
            return array();
        }

        for ($i = 0; $i < self::MAX_HEIGHT; $i++)
        {
            if ($i != $y)
            {
                $number = $this->matrix[$x][$i]->getNumber();
                $key = array_search($number, $availableNumbers);
                if ($key !== false)
                {
                    unset($availableNumbers[$key]);
                }
            }
        }

        if (empty($availableNumbers))
        {
            return array();
        }

        $ki = floor($y / 3);
        $kj = floor($x / 3);

        for ($i = 0; $i < 3; $i++)
        {
            for ($j = 0; $j < 3; $j++)
            {
                if (($i + 3 * $ki != $y) && ($j + 3 * $kj != $x))
                {
                    $number = $this->matrix[$j + 3 * $kj][$i + 3 * $ki]->getNumber();
                    $key = array_search($number, $availableNumbers);
                    if ($key !== false)
                    {
                        unset($availableNumbers[$key]);
                    }
                }
            }
        }

        return $availableNumbers;
    }

    public function getField($x, $y)
    {
        return $this->matrix[$x][$y];
    }
}
