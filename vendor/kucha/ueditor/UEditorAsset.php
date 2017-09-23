<?php
namespace kucha\ueditor;


use yii\web\AssetBundle;

class UEditorAsset extends AssetBundle
{
    public $js = [
        'ueditor.config.js',
        'ueditor.all.js',
        'kityformula-plugin/addKityFormulaDialog.js',
        'kityformula-plugin/getKfContent.js',
        'kityformula-plugin/defaultFilterFix.js',
    ];
   
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
    }
}