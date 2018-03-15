<?php
/**
 * Created by PhpStorm.
 * User: marica
 * Date: 14.3.18.
 * Time: 11.33
 */

namespace ccyii\widgets;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

class DetailViewDd extends DetailView
{
    public $emptyText = '';
    public $columns = 1;
    public $template =  '<dt{captionOptions}>{label}</dt><dd{contentOptions}>{value}</dd>';
    public $options = ['class' => 'detail-view'];

    /**
     * Renders the detail view.
     * This is the main entry of the whole detail view rendering.
     */
    public function run()
    {
        if( $this->columns < 1){
            $this->columns = 1;
        }
        if( $this->columns > 4){
            $this->columns = 4;
        }
        $rows = [];
        $i = 0;
        foreach ($this->attributes as $attribute) {
            $rows[] = $this->renderAttribute($attribute, $i++);
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'dl');
        echo Html::tag($tag, implode("\n", $rows), $options);
    }
    /**
     * Renders a single attribute.
     * @param array $attribute the specification of the attribute to be rendered.
     * @param int $index the zero-based index of the attribute in the [[attributes]] array
     * @return string the rendering result
     */
    protected function renderAttribute($attribute, $index)
    {
        if (is_string($this->template)) {
            $captionOptions = Html::renderTagAttributes(ArrayHelper::getValue($attribute, 'captionOptions', []));
            $contentOptions = Html::renderTagAttributes(ArrayHelper::getValue($attribute, 'contentOptions', []));
            $value = $this->formatter->format($attribute['value'], $attribute['format']);
            if ($value === '') {
                $value = $this->emptyText;
            }
            $data = strtr($this->template, [
                '{label}' => $attribute['label'],
                '{value}' => $value,
                '{captionOptions}' => $captionOptions,
                '{contentOptions}' => $contentOptions,
            ]);

            if ($this->columns > 1 && $this->columns < 4) {
                $col = 12 / $this->columns;
                $data = '<div class="col-md-' . $col . '">' . $data . '</div>';
                if ($index % $this->columns == 0) {
                    $data = '<div class="row">' . $data;
                    if ($index > 0) { // zatvaramo prethodni
                        $data = '</div>'.$data;
                    }
                }
                if ($index == count($this->attributes) - 1) {
                    $data .= '</div>';
                }
            }
            return $data;

        }

        return call_user_func($this->template, $attribute, $index, $this);
    }
}