<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Photographer $model */

$this->title = 'Добавить фотографа';
// $this->params['breadcrumbs'][] = ['label' => 'Photographers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="photographer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<style>
    h1 {
        text-align: center;
        color: rgba(54, 51, 47, 1); /* Цвет как у других заголовков */
        letter-spacing: 1px; /* Разрежение между буквами */
        font-size: 42px;
        margin: 0;
    }
</style>