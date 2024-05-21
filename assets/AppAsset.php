<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/login.css',
        'css/site.css',
        'css/dashboard.css',
        'css/ie10-viewport-bug-workaround.css',
        'css/bootstrap-datepicker.css',
        'css/bootstrap-datepicker.min.css',
    ];
    public $cssOptions = ['type' => 'text/css'];

    public $js = [
        'assets/js/bootstrap.min.js',
        'assets/js/bootstrap-datepicker.js',
        'assets/js/bootstrap-datepicker.min.js',
        'js/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
