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

class DetailViewInfo extends DetailView
{
    public $emptyText = '';
    public $template =  '<strong{captionOptions}>{label}</strong><p{contentOptions}>{value}</p><hr/>';
    public $options = ['class' => 'detail-view'];
    /**
     * Renders the detail view.
     * This is the main entry of the whole detail view rendering.
     */
    public function run()
    {
        $rows = [];
        $i = 0;
        foreach ($this->attributes as $attribute) {
            $rows[] = $this->renderAttribute($attribute, $i++);
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
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
            $icon = ArrayHelper::getValue($attribute, 'icon', 'info');
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
            $data = '<i class="fa fa-'.$icon.'  margin-r-5"></i>'.$data;
            return $data;

        }

        return call_user_func($this->template, $attribute, $index, $this);
    }
}
