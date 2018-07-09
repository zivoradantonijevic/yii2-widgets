<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \ccyii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use ccyii\widgets\Box;

use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

<?= $generator->enablePjax ? "    <?php Pjax::begin(); ?>\n" : '' ?>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

<?= "    <?php Box::begin([
        'box'     => Box::BOX_PRIMARY,
        'solid'   => false,
        'label'=>\$this->title,
        'actions' => [
            ['value'=>Html::a('<i class=\"fa fa-plus\"></i> Add New', ['create'], ['class' => 'btn btn-success']) ]
        ]
    ]); ?>
";?>


<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            //'" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        $attribute = $column->name;

        $columnDefinition = ["\n            [\n",
            "            'attribute'=>'$attribute',\n"
            ];
        if( $format == 'boolean'){
            $format = 'raw';
            $class = '\ccyii\widgets\ToggleColumn::className()';
            $action = 'toggle-'.$attribute;
            $columnDefinition[] = "            'format'=>'$format', \n";
            $columnDefinition[] = "            'class'=>$class,\n";
            $columnDefinition[] = "            'action'=>'$action',\n";
            $columnDefinition[] = "            'filter'=>[0=>'No',1=>'Yes'],\n";


        }else{
            $columnDefinition[] = "            'format'=>'$format', \n";

        }
        $columnDefinition[] = "            ],";

        $string = implode('', $columnDefinition);
        if (++$count < 6) {
            echo $string ."\n";
        } else {
            echo "/* ".$string ."\n*/\n";
        }
    }
}
?>

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>
<?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '' ?>
<?= "    <?php Box::end(); ?> ";
?>

</div>
