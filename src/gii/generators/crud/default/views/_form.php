<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \ccyii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use ccyii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form ccyii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if( $generator->shallSkipField($attribute)){
        continue;
    }
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
    <div class="form-group clearfix">
        <?= "<?= " ?>Html::submitButton('<i class="fa fa-save"></i> '.<?= $generator->generateString('Save') ?>, ['class' => 'btn btn-success pull-right']) ?>

        <?= "<?= " ?>Html::a('<i class="fa fa-arrow-left"></i> '.<?= $generator->generateString('Cancel') ?>, 'javascript:window.history.back()', ['class' => 'btn btn-danger btn-sm']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
