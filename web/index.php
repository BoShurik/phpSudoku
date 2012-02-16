<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: BoShurik
 * Date: 15.02.12
 * Time: 21:34
 */

function __autoload($className)
{
    include  __DIR__ ."/../src/". $className .".php";
}

function printSudoku(Sudoku $sudoku)
{
    $result = '<table width="270" border="1px">';
    for ($i = 0; $i < Sudoku::MAX_WIDTH; $i++)
    {
        $result .= '<tr>';
        for ($j = 0; $j < Sudoku::MAX_HEIGHT; $j++)
        {
            $result .= '<td>'. $sudoku->getField($i, $j) .'</td>';
        }
        $result .= '</tr>';
    }
    $result .= '</table>';

    return $result;
}

$matrix[3][0] = 1;
$matrix[7][0] = 2;
$matrix[8][0] = 9;
$matrix[2][1] = 5;
$matrix[8][1] = 4;
$matrix[1][2] = 6;
$matrix[2][2] = 8;
$matrix[3][3] = 7;
$matrix[6][3] = 5;
$matrix[1][4] = 2;
$matrix[4][4] = 6;
$matrix[7][4] = 8;
$matrix[2][5] = 3;
$matrix[5][5] = 9;
$matrix[4][6] = 5;
$matrix[6][6] = 1;
$matrix[7][6] = 6;
$matrix[0][7] = 4;
$matrix[4][7] = 3;
$matrix[0][8] = 7;
$matrix[5][8] = 2;

$sudoku = new Sudoku($matrix);

echo printSudoku($sudoku);

$sudoku->solve();

echo printSudoku($sudoku);