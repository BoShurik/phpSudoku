<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: BoShurik
 * Date: 15.02.12
 * Time: 21:34
 */

$beginTime = microtime(true);

set_time_limit(0);

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

function printSudokuForm()
{
    $result  = '<form action="" method="post">';
    $result .= '<table width="270" border="1px">';
    for ($i = 0; $i < Sudoku::MAX_HEIGHT; $i++)
    {
        $result .= '<tr>';
        for ($j = 0; $j < Sudoku::MAX_WIDTH; $j++)
        {
            $result .= '<td><input style="width: 30px;" type="text" name="matrix['. $j .']['. $i .']" value="" maxlength="1"/></td>';
        }
        $result .= '</tr>';
    }
    $result .= '</table>';
    $result .= '<input type="submit" value="Solve"/>';
    $result .= '</form>';

    return $result;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $sudoku = new Sudoku($_POST['matrix']);

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
}
else
{
    echo printSudokuForm();
}

$endTime = microtime(true);

echo '<br /><br />Время выполнения: '. ($endTime - $beginTime);