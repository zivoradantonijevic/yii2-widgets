<?php
/**
 * Created by PhpStorm.
 * User: zivorad
 * Date: 15.3.18.
 * Time: 02.48
 */

namespace ccyii\widgets;


use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * Returns header cell label.
     * This method may be overridden to customize the label of the header cell.
     * @return string label
     * @since 2.0.8
     */
    protected function getHeaderCellLabel()
    {
        return 'Show: '.Html::dropDownList('pagesize', 10,
            [10 => 10, 20 => 20, 50 => 50, 100 => 100, 1000 => 1000],
            ['id' => 'pagesize','class'=>'form-control']
        );
    }

    /**
     * Renders the filter cell content.
     * The default implementation simply renders a space.
     * This method may be overridden to customize the rendering of the filter cell (if any).
     * @return string the rendering result
     */
    protected function renderFilterCellContent()
    {
        return '<a class="clear-filters" href="#"><i class="fa fa-refresh"></i></a>';
    }


}