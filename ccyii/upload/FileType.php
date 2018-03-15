<?php

namespace ccyii\upload;

use yii\helpers\Html;

/**
 * Project: yacht-management
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 8.3.18.
 */
class FileType
{
    public static function show($path, $url)
    {
        $basename  = basename($path);
        $array     = explode('.', $path);
        $extension = strtolower(end($array));

        switch ($extension) {
            case 'pdf':
                $icon = 'fa fa-file';
                break;
            default:
                $icon = 'fa fa-file';
        }
        $text = '<span style="file-icon"><i class="' . $icon . '" title="' . $basename . '"></i></span>'
                . ' <span class="file-name">' . $basename . '</span>';

        return Html::a($text, $url, ['target' => '_blank']);
    }
}