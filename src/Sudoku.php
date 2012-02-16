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
            for ($i = 0; $i < self::MAX_WIDTH; $i++)
            {
                for ($j = 0; $j < self::MAX_HEIGHT; $j++)
                {
                    if (isset($matrix[$i][$j]))
                    {
                        if ($matrix[$i][$j] instanceof Field)
                        {
                            $this->matrix[$i][$j] = $matrix[$i][$j];
                        }
                        else if (is_int($matrix[$i][$j]))
                        {
                            $this->matrix[$i][$j] = new Field($matrix[$i][$j], false);
                        }
                        else
                        {
                            $this->matrix[$i][$j] = new Field();
                        }
                    }
                    else
                    {
                        $this->matrix[$i][$j] = new Field();
                    }
                }
            }
        }
        else
        {
            for ($i = 0; $i < self::MAX_WIDTH; $i++)
            {
                for ($j = 0; $j < self::MAX_HEIGHT; $j++)
                {
                    $this->matrix[$i][$j] = new Field();
                }
            }
        }
    }

    public function isSolve()
    {
        for ($i = 0; $i < self::MAX_WIDTH; $i++)
        {
            for ($j = 0; $j < self::MAX_HEIGHT; $j++)
            {
                if ($this->matrix[$i][$j]->getNumber() == null)
                {
                    return false;
                }
            }
        }

        for ($i = 0; $i < self::MAX_WIDTH; $i++)
        {
            $rowNumbers = array();
            for ($j = 0; $j < self::MAX_HEIGHT; $j++)
            {
                if (in_array($this->matrix[$i][$j]->getNumber(), $rowNumbers))
                {
                    return false;
                }

                $rowNumbers[] = $this->matrix[$i][$j]->getNumber();
            }
        }

        for ($i = 0; $i < self::MAX_HEIGHT; $i++)
        {
            $colNumbers = array();
            for ($j = 0; $j < self::MAX_WIDTH; $j++)
            {
                if (in_array($this->matrix[$j][$i]->getNumber(), $colNumbers))
                {
                    return false;
                }

                $colNumbers[] = $this->matrix[$j][$i]->getNumber();
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
                    if (in_array($this->matrix[$i + 3 * $ki][$j + 3 * $kj]->getNumber(), $squareNumbers))
                    {
                        return false;
                    }

                    $squareNumbers[] = $this->matrix[$i + 3 * $ki][$j + 3 * $kj]->getNumber();
                }
            }
        }

        return true;
    }

    public function solveRecursive($x, $y)
    {

    }

    public function solve()
    {
        $this->solveRecursive(0, 0);
    }

    public function getField($x, $y)
    {
        return $this->matrix[$y][$x];
    }
}
