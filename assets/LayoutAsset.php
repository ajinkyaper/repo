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
class LayoutAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'assets/css/bootstrap.min.css',
        'assets/css/croppie.css',
        'assets/css/helper.css',
        'assets/css/styles.css',
        'assets/css/bootstrap-datepicker.css',
        'assets/css/bootstrap-datepicker.min.css',
       
    ];
    public $cssOptions = ['type'=>'text/css'];  

    public $js = [ 
        'assets/js/bootstrap.min.js',
        'assets/js/bootstrap-datepicker.js',
        'assets/js/bootstrap-datepicker.min.js',
        
        'assets/js/jquery.dataTables.min.js',
        'assets/js/croppie.js',
        'assets/js/custom.js',
        'assets/js/ckeditor.js',
        'assets/js/jquery.validate.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
       //'yii\bootstrap\BootstrapAsset',
    ];

}
