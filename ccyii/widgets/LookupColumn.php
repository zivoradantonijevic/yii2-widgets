<?php
/**
 * Created by PhpStorm.
 * User: zivorad
 * Date: 15.3.18.
 * Time: 00.55
 */

namespace ccyii\widgets;


use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;

class LookupColumn extends DataColumn
{
    /**
     * Returns the data cell value.
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @return string the data cell value
     */
    public function getDataCellValue($model, $key, $index)
    {
        if ($this->value !== null) {
            if (is_string($this->value)) {
                $key = ArrayHelper::getValue($model, $this->value);
                if( $key === null){
                    return null;
                }
                if (isset($this->filter[$key])) {
                    return $this->filter[$key];
                }
                return 'Not set for:' . $key;
            }

            return call_user_func($this->value, $model, $key, $index, $this);
        } elseif ($this->attribute !== null) {
            $key = ArrayHelper::getValue($model, $this->attribute);
            if( $key === null){
                return null;
            }
            if (isset($this->filter[$key])) {
                return $this->filter[$key];
            }
            return 'Not set for:' . $key;
        }

        return null;
    }
}