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
    $result = '<table width="270">';
    for ($i = 0; $i < Sudoku::MAX_HEIGHT; $i++)
    {
        $result .= '<tr>';
        for ($j = 0; $j < Sudoku::MAX_WIDTH; $j++)
        {
            $style = '';
            if (($i % 3) == 0)
            {
                $style .= 'border-top: 2px solid;';
            }
            else if ($i == Sudoku::MAX_HEIGHT - 1)
            {
                $style .= 'border-bottom: 2px solid;';
            }
            else if (($i % 3) == 1)
            {
                $style .= 'border-top: 1px dotted;';
                $style .= 'border-bottom: 1px dotted;';
            }

            if (($j % 3) == 0)
            {
                $style .= 'border-left: 2px solid;';
            }
            else if ($j == Sudoku::MAX_WIDTH - 1)
            {
                $style .= 'border-right: 2px solid;';
            }
            else if (($j % 3) == 1)
            {
                $style .= 'border-left: 1px dotted;';
                $style .= 'border-right: 1px dotted;';
            }
            $result .= '<td style="'. $style .'">'. $sudoku->getField($j, $i) .'</td>';
        }
        $result .= '</tr>';
    }
    $result .= '</table>';

    $result .= "\n<!-- init string for cpp application\n";
    for ($i = 0; $i < Sudoku::MAX_HEIGHT; $i++)
    {
        for ($j = 0; $j < Sudoku::MAX_WIDTH; $j++)
        {
            $number = $sudoku->getField($j, $i)->getNumber();
            $result .= $number ? $number : 0;
        }
    }
    $result .= "\n-->";

    return $result;
}

function printSudokuForm()
{
    $result  = '<form action="" method="post">';
    $result .= '<table width="270">';
    for ($i = 0; $i < Sudoku::MAX_HEIGHT; $i++)
    {
        $result .= '<tr>';
        for ($j = 0; $j < Sudoku::MAX_WIDTH; $j++)
        {
            $style = '';
            if (($i % 3) == 0)
            {
                $style .= 'border-top: 1px solid;';
            }
            else if ($i == Sudoku::MAX_HEIGHT - 1)
            {
                $style .= 'border-bottom: 1px solid;';
            }

            if (($j % 3) == 0)
            {
                $style .= 'border-left: 1px solid;';
            }
            else if ($j == Sudoku::MAX_WIDTH - 1)
            {
                $style .= 'border-right: 1px solid;';
            }

            $result .= '<td style="'. $style .'"><input style="width: 30px;" type="text" name="matrix['. $j .']['. $i .']" value="" maxlength="1"/></td>';
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