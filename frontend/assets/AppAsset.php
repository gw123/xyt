<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
        'css/common.css',
        'css/bootstrap-extends.css',
        'css/theme-default.css',
        'css/web.css',
        'css/font-awesome.min.css',
        /*'css/ace.min.css',
        'css/ace-rtl.min.css',
        'css/ace-skins.min.css',*/
    ];

    public $js = [
        'js/lib/layer/layer.js',
        'js/common/common.js',
        'js/jquery-sortable.js',
        'js/jquery.cookie.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        /*'\yii\bootstrap\BootstrapPluginAsset',*/
    ];
}
