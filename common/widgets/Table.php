<?php
/**
 * Created by PhpStorm.
 * User: nico.nuernberger
 * Date: 10.08.2018
 * Time: 12:33
 */

namespace common\widgets;


use yii\base\Widget;

/*
Das Table Widget kann zum Aufbauen einer Tabelle ohne DataProvider genutzt werden.
Im config array kann das tableArray übergeben werden um der Tabelle, den Spalten und den Zellen Daten und Eigenschaften zu übergeben.
Ein Beispiel-Aufruf wäre:

    echo Table::widget(
        [
                'tableArray' =>
             [
                'class' => 'test1',
                [   //TR-Element
                    [// TD/TH-Element
                        'type'    => 'th',
                        'style'   => 'color: red',
                        'colspan' => 2,
                        'class'   => 'test2',
                        'html' => '<div>Hallo Welt1</div>',
                    ],
                    'class' => 'test3',
                    'style' => 'background-color: blue',
                ],
                [   //TR-Element
                    [// TD/TH-Element
                        'type'    => 'th',
                        'html' => '<div>Hallo Welt2</div>',
                    ],
                    [// TD/TH-Element
                        'type'    => 'td',
                        'style'   => 'color: red',
                        'class'   => 'test2',
                        'html' => '<div>Hallo Welt3</div>',
                    ],
                    'class' => 'test3',
                    'style' => 'background - color: blue',
                ]
            ]
        ]);

Jeder Parameter außer 'html' einer einzelnen Zelle kann weggelassen werrden.
*/

/**
 * Class Table
 * @package common\widgets
 */
class Table extends Widget
{
    public $tableArray = [];
    public $class = "table table-striped table-bordered detail-view";
    public $style = '';

    public function init()
    {
        parent::init();
        if(!isset($this->tableArray))
        {
            $tableArray = [];
        }
        if($this->class === null)
        {
            $class = 'table table-striped table-bordered detail-view';
        }
        if(!isset($this->style))
        {
            $style = '';
        }
    }

    protected function escape($input)
    {
        return str_replace('%','%%',$input);
    }

    public function run()
    {
        $template = '<table class="%s" style="%s">%s</table>';
        $toInsert = '';
        foreach ($this->tableArray as $tr)
        {
            if(!is_array($tr))
            {
                continue;
            }
            $frame1 = '<tr %s %s>';
            if(is_array($tr) and 0 < count($tr))
            {
                foreach ($tr as $tdh)
                {
                    if(!is_array($tdh))
                    {
                        continue;
                    }
                    if (!isset($tdh['type']))
                    {
                        $frame2 = '<td %s %s %s>%s</td>';
                    }
                    else
                    {
                        $frame2 = '<' . $tdh['type'] . ' %s %s %s>%s</' . $tdh['type'] . '>';
                    }
                    if (isset($tdh['html']))
                    {
                        $frame2 = sprintf($frame2,isset($tdh['class']) ? 'class="'.$this->escape($tdh['class']).'"' : '',
                            isset($tdh['style']) ? 'style="'.$this->escape($tdh['style']).'"' : '',
                            isset($tdh['colspan']) ? 'colspan="'.$this->escape($tdh['colspan']).'"' : '',
                            $this->escape($tdh['html']));
                    }
                    $frame1 .= $frame2;
                }

                $frame1 = sprintf($frame1,isset($tr['class']) ? 'class="'.$this->escape($tr['class']).'"' : '', isset($tr['style']) ? 'style="'.$this->escape($tr['style']).'"' : '').'</tr>';
                $toInsert .=$frame1;
            }
        }
        return sprintf($template,$this->class,$this->style,$toInsert);
    }
}