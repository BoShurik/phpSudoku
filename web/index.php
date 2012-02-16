<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: BoShurik
 * Date: 15.02.12
 * Time: 21:34
 */

//set_time_limit(0);

function __autoload($className)
{
    include  __DIR__ ."/../src/". $className .".php";
}

function printSudoku(Sudoku $sudoku)
{
    $result = '<table width="270" border="1px">';
    for ($i = 0; $i < Sudoku::MAX_HEIGHT; $i++)
    {
        $result .= '<tr>';
        for ($j = 0; $j < Sudoku::MAX_WIDTH; $j++)
        {
            $result .= '<td>'. $sudoku->getField($j, $i) .'</td>';
        }
        $result .= '</tr>';
    }
    $result .= '</table>';

    return $result;
}

// Простенький пример
$matrix[0][0] = 8; $matrix[2][0] = 5; $matrix[3][0] = 4; $matrix[4][0] = 9; $matrix[7][0] = 6;
$matrix[1][1] = 3; $matrix[2][1] = 1; $matrix[6][1] = 9; $matrix[7][1] = 8;
$matrix[0][2] = 4; $matrix[2][2] = 9; $matrix[4][2] = 3; $matrix[8][2] = 2;
$matrix[3][3] = 9; $matrix[4][3] = 1; $matrix[5][3] = 5;
$matrix[1][4] = 4; $matrix[4][4] = 8; $matrix[7][4] = 9;
$matrix[3][5] = 2; $matrix[4][5] = 4; $matrix[5][5] = 3;
$matrix[0][6] = 3; $matrix[4][6] = 7; $matrix[6][6] = 2; $matrix[8][6] = 6;
$matrix[1][7] = 1; $matrix[2][7] = 6; $matrix[6][7] = 7; $matrix[7][7] = 4;
$matrix[1][8] = 7; $matrix[4][8] = 2; $matrix[5][8] = 9; $matrix[6][8] = 8; $matrix[8][8] = 1;

// Решенный пример
//$matrix[0][0] = 8; $matrix[1][0] = 2; $matrix[2][0] = 5;
//$matrix[3][0] = 4; $matrix[4][0] = 9; $matrix[5][0] = 7;
//$matrix[6][0] = 1; $matrix[7][0] = 6; $matrix[8][0] = 3;
//
//$matrix[0][1] = 7; $matrix[1][1] = 3; $matrix[2][1] = 1;
//$matrix[3][1] = 5; $matrix[4][1] = 6; $matrix[5][1] = 2;
//$matrix[6][1] = 9; $matrix[7][1] = 8; $matrix[8][1] = 4;
//
//$matrix[0][2] = 4; $matrix[1][2] = 6; $matrix[2][2] = 9;
//$matrix[3][2] = 8; $matrix[4][2] = 3; $matrix[5][2] = 1;
//$matrix[6][2] = 5; $matrix[7][2] = 7; $matrix[8][2] = 2;
//
//
//$matrix[0][3] = 6; $matrix[1][3] = 8; $matrix[2][3] = 3;
//$matrix[3][3] = 9; $matrix[4][3] = 1; $matrix[5][3] = 5;
//$matrix[6][3] = 4; $matrix[7][3] = 2; $matrix[8][3] = 7;
//
//$matrix[0][4] = 1; $matrix[1][4] = 4; $matrix[2][4] = 2;
//$matrix[3][4] = 7; $matrix[4][4] = 8; $matrix[5][4] = 6;
//$matrix[6][4] = 3; $matrix[7][4] = 9; $matrix[8][4] = 5;
//
//$matrix[0][5] = 9; $matrix[1][5] = 5; $matrix[2][5] = 7;
//$matrix[3][5] = 2; $matrix[4][5] = 4; $matrix[5][5] = 3;
//$matrix[6][5] = 6; $matrix[7][5] = 1; $matrix[8][5] = 8;
//
//
//$matrix[0][6] = 3; $matrix[1][6] = 9; $matrix[2][6] = 8;
//$matrix[3][6] = 1; $matrix[4][6] = 7; $matrix[5][6] = 4;
//$matrix[6][6] = 2; $matrix[7][6] = 5; $matrix[8][6] = 6;
//
//$matrix[0][7] = 2; $matrix[1][7] = 1; $matrix[2][7] = 6;
//$matrix[3][7] = 3; $matrix[4][7] = 5; $matrix[5][7] = 8;
//$matrix[6][7] = 7; $matrix[7][7] = 4; $matrix[8][7] = 9;
//
//$matrix[0][8] = 5; $matrix[1][8] = 7; $matrix[2][8] = 4;
//$matrix[3][8] = 6; $matrix[4][8] = 2; $matrix[5][8] = 9;
//$matrix[6][8] = 8; $matrix[7][8] = 3; $matrix[8][8] = 1;

// Сложный пример
//$matrix[3][0] = 1; $matrix[7][0] = 2; $matrix[8][0] = 9;
//$matrix[2][1] = 5; $matrix[8][1] = 4;
//$matrix[1][2] = 6; $matrix[2][2] = 8;
//$matrix[3][3] = 7; $matrix[6][3] = 5;
//$matrix[1][4] = 2; $matrix[4][4] = 6; $matrix[7][4] = 8;
//$matrix[2][5] = 3; $matrix[5][5] = 9;
//$matrix[4][6] = 5; $matrix[6][6] = 1; $matrix[7][6] = 6;
//$matrix[0][7] = 4; $matrix[4][7] = 3;
//$matrix[0][8] = 7; $matrix[5][8] = 2;

$sudoku = new Sudoku($matrix);

echo printSudoku($sudoku);

if ($sudoku->solve())
{
    echo "Done!<br />\n";
}
else
{
    echo "Fail!<br />\n";
}

echo printSudoku($sudoku);