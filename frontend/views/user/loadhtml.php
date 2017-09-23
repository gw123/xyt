<?php


use kartik\form\ActiveForm;

use common\models\Category;

$categoryList = Category::getCategoryHashByCodes(['xueduan','xueke']);
?>
<?php $form = ActiveForm::begin([
    'id'=>'userform',
    'action'=>'/user/adduser'
	]);

?>
<?= $form->field($model,'id')->hiddenInput()->label(false) ?>
<?= $form->field($model,'nickname')->textInput() ?>
<?= $form->field($model,'password')->passwordInput() ?>

<?php $form->end() ?>
