<?php
/**
 * Created by PhpStorm.
 * User: zivorad
 * Date: 8.3.18.
 * Time: 02.01
 */

namespace ccyii\widgets;


use ccyii\upload\FileType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ActiveField extends \yii\widgets\ActiveField
{

    /**
     * Renders a text input.
     * This method will generate the `name` and `value` tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param string $converter meter_feet|litre_gallon
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     *
     * The following special options are recognized:
     *
     * - `maxlength`: int|bool, when `maxlength` is set `true` and the model attribute is validated
     *   by a string validator, the `maxlength` option will take the value of [[\yii\validators\StringValidator::max]].
     *   This is available since version 2.0.3.
     *
     * Note that if you set a custom `id` for the input element, you may need to adjust the value of [[selectors]] accordingly.
     *
     * @return $this the field object itself.
     */
    public function metricInput($converter = null, $options = [])
    {
        $options = array_merge($this->inputOptions, $options);

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        $input = Html::activeTextInput($this->model, $this->attribute, $options);
        if ($converter) {
            if ($converter == 'meter_feet') {
                $input = $this->getMeterFeedInput($input);
            } elseif ($converter == 'litre_gallon') {
                $input = $this->getLitreGallonInput($input);
            } elseif ($converter == 'kg_pound') {
                $input = $this->getKgPoundInput($input);
            }
            $options['data-converter'] = $converter;

        }
        $this->parts['{input}'] = $input;

        return $this;
    }

    protected function getMeterFeedInput($input)
    {
        $feetId = preg_replace('%_m$%', '_ft', $this->attribute);
        $inchId = preg_replace('%_m$%', '_in', $this->attribute);
        $input2 = '<input class="form-control" id="' . $feetId . '">';
        $input3 = '<input class="form-control"  id="' . $inchId . '">';
        $input = "
            <div class='row'>
            <div class='col-md-6'><div class=\"input-group\">$input <span class=\"input-group-addon\">m</span></div></div>
            <div class='col-md-3'><div class=\"input-group\">$input2 <span class=\"input-group-addon\">ft</span></div></div>
            <div class='col-md-3'><div class=\"input-group\">$input3 <span class=\"input-group-addon\">in</span></div></div>
            </div>";
        return $input;
    }

    protected function getLitreGallonInput($input)
    {
        $gallonId = preg_replace('%_l$%', '_g', $this->attribute);
        $input2 = '<input class="form-control" id="' . $gallonId . '">';
        $input = "
            <div class='row'>
            <div class='col-md-6'><div class=\"input-group\">$input <span class=\"input-group-addon\">lit.</span></div></div>
            <div class='col-md-6'><div class=\"input-group\">$input2 <span class=\"input-group-addon\">gal.</span></div></div>
            </div>";
        return $input;
    }

    protected function getKgPoundInput($input)
    {
        $poundId = preg_replace('%_kg$%', '_lb', $this->attribute);
        $ounceId = preg_replace('%_kg$%', '_oz', $this->attribute);
        $input2 = '<input class="form-control" id="' . $poundId . '">';
        $input3 = '<input class="form-control"  id="' . $ounceId . '">';
        $input = "
            <div class='row'>
            <div class='col-md-6'><div class=\"input-group\">$input <span class=\"input-group-addon\">kg</span></div></div>
            <div class='col-md-3'><div class=\"input-group\">$input2 <span class=\"input-group-addon\">lb</span></div></div>
            <div class='col-md-3'><div class=\"input-group\">$input3 <span class=\"input-group-addon\">oz</span></div></div>
            </div>";
        return $input;
    }


    public function uploadFileInput($options = [])
    {
        // https://github.com/yiisoft/yii2/pull/795
        if ($this->inputOptions !== ['class' => 'form-control']) {
            $options = array_merge($this->inputOptions, $options);
        }
        // https://github.com/yiisoft/yii2/issues/8779
        if (!isset($this->form->options['enctype'])) {
            $this->form->options['enctype'] = 'multipart/form-data';
        }

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $field = $this->attribute;
        $model = $this->model;

        $preview = ArrayHelper::remove($options, 'preview', 'preview');
        $imgOptions = ArrayHelper::remove($options, 'imgOptions');
        $linkOptions = ArrayHelper::remove($options, 'linkOptions');

        $type = ArrayHelper::remove($options, 'type');

        $deleteText = ArrayHelper::remove($options, 'deleteText');

        $input = Html::activeFileInput($this->model, $this->attribute, $options);

        if ($type == 'image') {
            $previewUrl = $model->getThumbUploadUrl($field, $preview);
            $fileUrl = $model->getUploadUrl($field);
            if (!$deleteText) {
                $deleteText = 'Delete Image';
            }
            $previewHtml = Html::a(Html::img($previewUrl, $imgOptions), $fileUrl, $linkOptions);
        } else {
            $previewHtml = FileType::show($model->getUploadPath('attachment'), $model->getUploadUrl('attachment'));
        }
        if (!$deleteText) {
            $deleteText = 'Delete File';
        }

        if ($model->$field) {
            $previewAndDelete = '<div class="upload-file-field">
            <div class="upload-file-preview">' .
                $previewHtml .
                ' </div>
            <div class="upload-file-delete">
                <label>' . $deleteText . '</label>
                <input type="checkbox" name="delete_file[]" value="' . $field . '">
            </div>
        </div>';

            $this->parts['{input}'] = $previewAndDelete . $input;
        } else {
            $this->parts['{input}'] = $input;
        }
        return $this;

    }
}