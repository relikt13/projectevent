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
class WebAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/jquery.fancybox.min.css',
        'css/sticky-footer.css'
    ];
    public $js = [
        'js/jquery-3.3.1.slim.min.js',
        'js/bootstrap.bundle.js',
        'js/bootstrap.js',
        'js/jquery.fancybox.min.js',

    ];
    public $depends = [

    ];
}
