<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostForm */
/* @var $form ActiveForm */

?>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'text') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Отправить сообщение', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <? foreach ($posts as $post){?>
        <div class="well">
            <h5><?= $post->user->username ?>:</h5>
            <p>
                <?= $post->text ?>
            </p>
        </div>
    <? }?>