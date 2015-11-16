<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="/post/index">Сайтсофт</a>
        <ul class="nav">
            <li <? if (Yii::$app->controller->action->id == 'index') echo "class=\"active\""?> > <a href="/post/index">Главная</a></li>
            <? if (Yii::$app->user->isGuest) {?>
            <li <? if (Yii::$app->controller->action->id == 'login') echo "class=\"active\""?> > <a href="/main/login">Авторизация</a></li>
            <li <? if (Yii::$app->controller->action->id == 'reg') echo "class=\"active\""?> > <a href="/main/reg">Регистрация</a></li>
            <?} ?>
        </ul>
        <?
        if (!Yii::$app->user->isGuest) {
            ?>
            <ul class="nav pull-right">
                <li><a><?= Yii::$app->user->identity->username ?></a></li>
                <li><a href="/main/logout">Выход</a></li>
            </ul>
            <?
        }
        ?>
    </div>
</div>

<div class="row-fluid">
    <div class="span2"></div>
    <div class="span8">
        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
